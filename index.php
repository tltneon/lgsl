<?php
//------------------------------------------------------------------------------------------------------------+
	header("Content-Type:text/html; charset=utf-8");
	
	require "lgsl_files/lgsl_config.php";
//------------------------------------------------------------------------------------------------------------+
?>


<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $lgsl_config['text']['ttl']; ?></title>
		<link rel="icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<meta http-equiv='content-style-type' content='text/css' />
		<link rel='stylesheet' href='lgsl_files/styles/<?php echo $lgsl_config['style']; ?>' type='text/css' />
	</head>

	<body>
	
		<div id="topmenu">
			<li><a href="../../">TO MAIN PAGE</a></li>
			<?php if($lgsl_config['public_add']) echo '<li><a href="?s=add">'.$lgsl_config["text"]["aas"].'</a></li>';?>
			<?php if(file_exists("install.php")) echo '<li><a href="./install.php">INSTALLATION PAGE</a></li>';?>
			<?php if(isset($_GET['s'])) echo '<li><a href="./">'.$lgsl_config['text']['bak'].'</a></li>';?>
		</div>
		<a id="adminlink" href="admin.php"></a>
		
		<div id="container">
<?php
//------------------------------------------------------------------------------------------------------------+
  global $output, $lgsl_server_id;
	

  $s = isset($_GET['s']) ? $_GET['s'] : "";

  if     (is_numeric($s)) { $lgsl_server_id = $s; require "lgsl_files/lgsl_details.php"; }
  elseif ($s == "add")    {                       require "lgsl_files/lgsl_add.php";     }
  else                    {                       require "lgsl_files/lgsl_list.php";    }
   
  if(isset($lgsl_config['scripts']))
		foreach($lgsl_config['scripts'] as $script)
			$output .= "<script src='lgsl_files/scripts/".$script."'></script>";
  
  echo $output;
  unset($output);
//------------------------------------------------------------------------------------------------------------+
?>
		</div>
	</body>
</html>
