<?php
//------------------------------------------------------------------------------------------------------------+
  require "lgsl_files/lgsl_config.php";

  if (empty($lgsl_config['admin']['user']) || empty($lgsl_config['admin']['pass']))
  {
    exit("ADMIN USERNAME OR PASSWORD MISSING FROM CONFIG");
  }
  elseif ($lgsl_config['admin']['pass'] == "changeme")
  {
    exit("ADMIN PASSWORD MUST BE CHANGED FROM THE DEFAULT");
  }

  $auth   = md5($_SERVER['REMOTE_ADDR'].md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
  $cookie = isset($_COOKIE['lgsl_admin_auth']) ? $_COOKIE['lgsl_admin_auth'] : "";

  if (isset($_POST['lgsl_user']) && isset($_POST['lgsl_pass']) && $lgsl_config['admin']['user'] == $_POST['lgsl_user'] && $lgsl_config['admin']['pass'] == $_POST['lgsl_pass'])
  {
    setcookie("lgsl_admin_auth", $auth, (time() + (60 * 60 * 24)), "/");
    define("LGSL_ADMIN", TRUE);
  }
  elseif ($cookie == $auth)
  {
    setcookie("lgsl_admin_auth", $auth, (time() + (60 * 60 * 24)), "/");
    define("LGSL_ADMIN", TRUE);
  }

  header("Content-Type:text/html; charset=utf-8");
//------------------------------------------------------------------------------------------------------------+
?>



<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <title>Live Game Server List</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='content-style-type' content='text/css' />
    <link rel='stylesheet' href='lgsl_files/styles/<?php echo $lgsl_config['style'];?>' type='text/css' />
  </head>

  <body>

<?php
//------------------------------------------------------------------------------------------------------------+
  if (defined("LGSL_ADMIN"))
  {
    global $output;
    $output = "";
    require "lgsl_files/lgsl_admin.php";
    echo $output;
  }
  else
  {
    echo "
    <form method='post' action=''>
      <table style='margin:auto; text-align:center'>
        <tr><td> ".$lgsl_config['text']['umn'].": </td><td> <input type='text'     name='lgsl_user' value='' /> </td></tr>
        <tr><td> ".$lgsl_config['text']['pwd'].": </td><td> <input type='password' name='lgsl_pass' value='' /> </td></tr>
        <tr>
          <td colspan='2'>
            <br />
            <input type='submit' name='lgsl_admin_login' value='".$lgsl_config['text']['lgn']."' />
          </td>
        </tr>
      </div>
    </form>";
  }
//------------------------------------------------------------------------------------------------------------+
?>


  </body>
</html>
