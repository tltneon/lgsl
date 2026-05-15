param(
  [string]$ProjectRoot = (Resolve-Path "$PSScriptRoot\.."),
  [string]$MysqlPassword = "usbw"
)

$ErrorActionPreference = "Stop"

$PhpExe = Join-Path $ProjectRoot "usbwebserver\php\php.exe"
$SeedFile = Join-Path $ProjectRoot "tools\seed-local-servers.php"

if (-not (Test-Path -LiteralPath $PhpExe)) {
  throw "USBWebserver PHP was not found: $PhpExe"
}

if (-not (Test-Path -LiteralPath $SeedFile)) {
  throw "Seed file was not found: $SeedFile"
}

& $PhpExe $SeedFile $MysqlPassword
