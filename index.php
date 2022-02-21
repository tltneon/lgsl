<?php
//------------------------------------------------------------------------------------------------------------+
  $time = microtime(true);
	header("Content-Type:text/html; charset=utf-8");

  global $output, $lgsl_server_id;
  $s = isset($_GET['s']) ? $_GET['s'] : "";
  $title = "";
  
  if     (is_numeric($s)) { $lgsl_server_id = $s; require "lgsl_files/lgsl_details.php"; $title .= $server['s']['name'] . " - "; }
  elseif ($s == "add")    {                       require "lgsl_files/lgsl_add.php"; $title .= $lgsl_config["text"]["aas"] . " - "; }
  else                    {                       require "lgsl_files/lgsl_list.php"; }
  $title .= $lgsl_config['text']['ttl'];
//------------------------------------------------------------------------------------------------------------+
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link rel="icon" href="lgsl_files/other/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="lgsl_files/other/favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='content-style-type' content='text/css' />
    <link rel='stylesheet' href='lgsl_files/styles/<?php echo $lgsl_config['style']; ?>' type='text/css' />
    <?php echo ($lgsl_config['autoreload'] ? "<META HTTP-EQUIV='REFRESH' CONTENT=" . ($lgsl_config['cache_time'] + 1) . " />" : ""); ?>
  </head>

  <body>
    <div id="topmenu">
      <?php
                                       echo '<li><a href="../../">' . $lgsl_config['text']['mpg'] . '</a></li>';   // MAIN PAGE
        if($lgsl_config['public_add']) echo '<li><a href="?s=add">'.$lgsl_config["text"]["aas"].'</a></li>';       // ADD SERVER
        if(file_exists("install.php")) echo '<li><a href="./install.php">INSTALLATION PAGE</a></li>';              // INSTALLATION PAGE  
        if(isset($_GET['s']))          echo '<li><a href="./">'.$lgsl_config['text']['bak'].'</a></li>';           // BACK TO SERVERS LIST
      ?>
    </div>
    <a id="adminlink" href="admin.php"></a>

    <div id="container">
<?php
  echo $output;
  unset($output);
?>
    </div>
    <?php
      if (isset($lgsl_config['scripts'])) {
        foreach ($lgsl_config['scripts'] as $script) {
          echo "<script src='lgsl_files/scripts/{$script}'></script>";
        }
      }
    ?>
  </body>
</html>
<!-- Powered by LGSL v6.1.1; <?php echo "Page loaded: ".round(microtime(true) - $time, 6)."s";?> -->