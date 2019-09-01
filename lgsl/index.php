<?php
//------------------------------------------------------------------------------------------------------------+
  header("Content-Type:text/html; charset=utf-8");
	
	require "lgsl_files/lgsl_config.php";
//------------------------------------------------------------------------------------------------------------+
?>


<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <title><?php echo $lgsl_config['text']['ttl']; ?></title>
		<link rel="icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='content-style-type' content='text/css' />
    <link rel='stylesheet' href='lgsl_files/styles/<?php echo $lgsl_config['style']; ?>' type='text/css' />
  </head>

  <body>
	
<?php
//------------------------------------------------------------------------------------------------------------+
  global $output, $lgsl_server_id;

  $output = "";

  $s = isset($_GET['s']) ? $_GET['s'] : "";

  if     (is_numeric($s)) { $lgsl_server_id = $s; require "lgsl_files/lgsl_details.php"; }
  elseif ($s == "add")    {                       require "lgsl_files/lgsl_add.php";     }
  else                    {                       require "lgsl_files/lgsl_list.php";    }

  echo $output;

  unset($output);
//------------------------------------------------------------------------------------------------------------+
?>

  </body>
</html>
