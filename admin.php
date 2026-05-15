<?php
//------------------------------------------------------------------------------------------------------------+
  require "lgsl_files/lgsl_config.php";

  if (empty($lgsl_config['admin']['user']) || empty($lgsl_config['admin']['pass']))
  {
    exit($lgsl_config['text']['aum']);
  }
  elseif ($lgsl_config['admin']['pass'] == "changeme")
  {
    exit($lgsl_config['text']['apc']);
  }

  $auth   = md5($_SERVER['REMOTE_ADDR'].md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
  $cookie = isset($_COOKIE['lgsl_admin_auth']) ? $_COOKIE['lgsl_admin_auth'] : "";

  if (isset($_GET['logout']))
  {
    setcookie("lgsl_admin_auth", "", (time() - 3600), "/", "", false, true);
    header("Location: ./");
    exit;
  }

  if (isset($_POST['lgsl_user']) && isset($_POST['lgsl_pass']) && $lgsl_config['admin']['user'] == $_POST['lgsl_user'] && $lgsl_config['admin']['pass'] == $_POST['lgsl_pass'])
  {
    setcookie("lgsl_admin_auth", $auth, (time() + (60 * 60 * 24)), "/", "", false, true);
    define("LGSL_ADMIN", TRUE);
  }
  elseif ($cookie === $auth)
  {
    setcookie("lgsl_admin_auth", $auth, (time() + (60 * 60 * 24)), "/", "", false, true);
    define("LGSL_ADMIN", TRUE);
  }

  header("Content-Type:text/html; charset=utf-8");

  $admin_name = htmlspecialchars($lgsl_config['admin']['user'], ENT_QUOTES, "UTF-8");
  $admin_title = isset($lgsl_config['text']['apn']) ? $lgsl_config['text']['apn'] : "Admin Panel";
  $admin_description = isset($lgsl_config['text']['apd']) ? $lgsl_config['text']['apd'] : "Manage servers, maps, updates, and LGSL settings.";
  $admin_section = isset($lgsl_config['text']['asm']) ? $lgsl_config['text']['asm'] : "Server management";
//------------------------------------------------------------------------------------------------------------+
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Live Game Server List Admin</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta http-equiv='content-style-type' content='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='lgsl_files/styles/<?php echo $lgsl_config['style'];?>' type='text/css'>
  </head>
  <body>
    <div id="topmenu" class="admin_topmenu">
      <li><a href='./'><?php echo $lgsl_config['text']['bak'];?></a></li>
      <li><a href='admin.php'><?php echo $admin_title;?></a></li>
      <?php if (defined("LGSL_ADMIN")) { ?>
      <li id='adminlink' class='admin_profile admin_logged_in'>
        <button type='button' class='admin_profile_button' aria-haspopup='true' aria-expanded='false'>
          <span class='admin_avatar' aria-hidden='true'><?php echo strtoupper(substr($admin_name, 0, 1));?></span>
          <span class='admin_profile_text'><?php echo $admin_name;?></span>
        </button>
        <div class='admin_profile_menu'>
          <a href='./'><?php echo $lgsl_config['text']['bak'];?></a>
          <a href='admin.php?logout=1'><?php echo $lgsl_config['text']['lgo'];?></a>
        </div>
      </li>
      <?php } else { ?>
      <li id='adminlink' class='admin_profile admin_guest'>
        <a href='admin.php' class='admin_profile_button'>
          <span class='admin_avatar' aria-hidden='true'>?</span>
          <span class='admin_profile_text'><?php echo $lgsl_config['text']['lgn'];?></span>
        </a>
      </li>
      <?php } ?>
    </div>
    <div id='admin_page'>
      <div class='admin_hero'>
        <div>
          <span><?php echo $admin_section;?></span>
          <h1><?php echo $admin_title;?></h1>
          <p><?php echo $admin_description;?></p>
        </div>
      </div>
      <div class='admin_content'>
        <div id='back_to_servers_list'><a href='./'><?php echo $lgsl_config['text']['bak'];?></a></div>

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
    <div id='admin_login_page'>
    <form method='post' action=''>
      <table style='margin:auto; text-align:center'>
        <tr><td> ".$lgsl_config['text']['umn'].": </td><td> <input type='text'     name='lgsl_user' value=''> </td></tr>
        <tr><td> ".$lgsl_config['text']['pwd'].": </td><td> <input type='password' name='lgsl_pass' value=''> </td></tr>
        <tr>
          <td colspan='2'>
            <input type='submit' name='lgsl_admin_login' value='".$lgsl_config['text']['lgn']."'>
          </td>
        </tr>
      </table>
    </form>
    </div>";
  }
//------------------------------------------------------------------------------------------------------------+
?>
      </div>
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
