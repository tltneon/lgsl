param(
  [string]$ProjectRoot = (Resolve-Path "$PSScriptRoot\.."),
  [string]$MysqlPassword = "usbw",
  [string]$AdminPassword = "localtest"
)

$ErrorActionPreference = "Stop"

$UsbRoot = Join-Path $ProjectRoot "usbwebserver"
$WebRoot = Join-Path $UsbRoot "root"
$PhpExe = Join-Path $UsbRoot "php\php.exe"

if (-not (Test-Path -LiteralPath $UsbRoot)) {
  throw "USBWebserver folder was not found: $UsbRoot"
}

if (-not (Test-Path -LiteralPath $WebRoot)) {
  New-Item -ItemType Directory -Path $WebRoot | Out-Null
}

$backup = Join-Path $WebRoot "_usbwebserver_default_backup"
if (-not (Test-Path -LiteralPath $backup)) {
  New-Item -ItemType Directory -Path $backup | Out-Null
  foreach ($name in @("index.php", "style.css", "images")) {
    $src = Join-Path $WebRoot $name
    if (Test-Path -LiteralPath $src) {
      Move-Item -LiteralPath $src -Destination $backup -Force
    }
  }
}

Get-ChildItem -LiteralPath $ProjectRoot -Force |
  Where-Object { $_.Name -notin @("usbwebserver", ".git") } |
  ForEach-Object {
    Copy-Item -LiteralPath $_.FullName -Destination $WebRoot -Recurse -Force
  }

$configPath = Join-Path $WebRoot "lgsl_files\lgsl_config.php"
$config = Get-Content -LiteralPath $configPath -Raw
$config = $config -replace '\$lgsl_config\[''admin''\]\[''pass''\]\s*=\s*"[^"]*";', "`$lgsl_config['admin']['pass'] = `"$AdminPassword`";"
$config = $config -replace '\$lgsl_config\[''db''\]\[''pass''\]\s*=\s*"[^"]*";', "`$lgsl_config['db']['pass']   = `"$MysqlPassword`";"
$config = $config -replace '\$lgsl_config\[''style''\]\s*=\s*"[^"]*";', "`$lgsl_config['style'] = `"modern_style.css`";"
$config = $config -replace '\$lgsl_config\[''scripts''\]\s*=\s*\[[^\]]*\];', "`$lgsl_config['scripts'] = [`"modern.js`"];"
$config = $config -replace 'include\("languages/english\.php"\);', 'include("languages/turkish.php");'
$utf8NoBom = New-Object System.Text.UTF8Encoding($false)
[System.IO.File]::WriteAllText($configPath, $config, $utf8NoBom)

$phpCode = @"
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
`$db = mysqli_connect('127.0.0.1', 'root', '$MysqlPassword', '', 3306);
mysqli_query(`$db, 'CREATE DATABASE IF NOT EXISTS ``lgsl`` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
mysqli_select_db(`$db, 'lgsl');
`$sql = "CREATE TABLE IF NOT EXISTS ``lgsl`` (
  ``id`` INT(11) NOT NULL auto_increment,
  ``type`` VARCHAR(50) NOT NULL DEFAULT '',
  ``ip`` VARCHAR(255) NOT NULL DEFAULT '',
  ``c_port`` VARCHAR(5) NOT NULL DEFAULT '0',
  ``q_port`` VARCHAR(5) NOT NULL DEFAULT '0',
  ``s_port`` VARCHAR(5) NOT NULL DEFAULT '0',
  ``zone`` VARCHAR(255) NOT NULL DEFAULT '',
  ``disabled`` TINYINT(1) NOT NULL DEFAULT '0',
  ``comment`` VARCHAR(255) NOT NULL DEFAULT '',
  ``status`` TINYINT(1) NOT NULL DEFAULT '0',
  ``cache`` MEDIUMTEXT NOT NULL,
  ``cache_time`` TEXT NOT NULL,
  PRIMARY KEY (``id``)
) ENGINE=MyISAM CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
mysqli_query(`$db, `$sql);
mysqli_query(`$db, 'ALTER TABLE ``lgsl`` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
echo "LGSL database/table ready\n";
"@

$phpCode | & $PhpExe

& (Join-Path $ProjectRoot "tools\seed-local-servers.ps1") -ProjectRoot $ProjectRoot -MysqlPassword $MysqlPassword

Write-Host "Local LGSL test copy is ready: http://localhost/"
Write-Host "Admin login: lgsladmin / $AdminPassword"
