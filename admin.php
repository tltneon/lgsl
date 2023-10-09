<?php
//------------------------------------------------------------------------------------------------------------+
  require "src/lgsl_config.php";

  if (empty($lgsl_config['admin']['user']) || empty($lgsl_config['admin']['pass'])) {
    exit($lgsl_config['text']['aum']);
  }
  if ($lgsl_config['admin']['pass'] === "changeme") {
    exit($lgsl_config['text']['apc']);
  }

  $auth   = md5($_SERVER['REMOTE_ADDR'].md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
  $cookie = isset($_COOKIE['lgsl_admin_auth']) ? $_COOKIE['lgsl_admin_auth'] : "";

  if ((isset($_POST['lgsl_user']) && isset($_POST['lgsl_pass']) && $lgsl_config['admin']['user'] == $_POST['lgsl_user'] && $lgsl_config['admin']['pass'] == $_POST['lgsl_pass']) || ($cookie === $auth)) {
    setcookie("lgsl_admin_auth", $auth, (time() + (60 * 60 * 24)), "/");
    define("LGSL_ADMIN", TRUE);
  }

  header("Content-Type:text/html; charset=utf-8");
//------------------------------------------------------------------------------------------------------------+
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Live Game Server List Admin</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='content-style-type' content='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='src/other/_lgsl_admin.css' type='text/css' />
    <link rel='stylesheet' href='src/styles/<?php echo $lgsl_config['style'];?>' type='text/css' />
  </head>
  <body>
    <div id='admin_page'>
      <div id='back_to_servers_list'><a href='./'><?php echo $lgsl_config['text']['bak'];?></a></div>

<?php
//------------------------------------------------------------------------------------------------------------+
  if (defined("LGSL_ADMIN")) {
    global $output;
    $output = "";
    require "src/lgsl_admin.php";
    echo $output;
  } else {
    echo "
    <div id='admin_login_page'>
			<form method='post' action=''>
				<table>
					<tr><td>{$lgsl_config['text']['umn']}: </td><td><input type='text'     name='lgsl_user' value='' /></td></tr>
					<tr><td>{$lgsl_config['text']['pwd']}: </td><td><input type='password' name='lgsl_pass' value='' /></td></tr>
					<tr>
						<td colspan='2'>
							<input type='submit' name='lgsl_admin_login' value='{$lgsl_config['text']['lgn']}' />
						</td>
					</tr>
				</div>
			</form>
    </div>";
  }
//------------------------------------------------------------------------------------------------------------+
?>
    </div>
  </body>
</html>