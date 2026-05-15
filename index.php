<?php
//------------------------------------------------------------------------------------------------------------+
  $time = microtime(true);
  header("Content-Type:text/html; charset=utf-8");

  require ("lgsl_files/lgsl_config.php");
  global $output, $title;

  $lgsl_admin_cookie = isset($_COOKIE['lgsl_admin_auth']) ? $_COOKIE['lgsl_admin_auth'] : "";
  $lgsl_admin_auth = "";
  $lgsl_admin_logged_in = false;
  $lgsl_admin_user = isset($lgsl_config['admin']['user']) ? $lgsl_config['admin']['user'] : "";

  if (!empty($lgsl_config['admin']['user']) && !empty($lgsl_config['admin']['pass'])) {
    $lgsl_admin_auth = md5($_SERVER['REMOTE_ADDR'].md5($lgsl_config['admin']['user'].md5($lgsl_config['admin']['pass'])));
    $lgsl_admin_logged_in = ($lgsl_admin_cookie === $lgsl_admin_auth);
  }

  function load_page($file) {
    global $lgsl_config;
    if ($lgsl_config['preloader']) {
      $loader = @file_get_contents('lgsl_files/other/loader.html');
      $post = http_build_query($_POST);
      $get = http_build_query($_GET);
      return "
      <script>
        (function() {
          httpRequest = new XMLHttpRequest();
          if (!httpRequest) {
            alert('Cannot create an XMLHTTP instance');
            return false;
          }
          httpRequest.onreadystatechange = alertContents;
          httpRequest.open('POST', 'lgsl_files/lgsl_{$file}.php?{$get}', true);
          httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          httpRequest.send('{$post}')

          function alertContents() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
              if (httpRequest.status === 200) {
                document.getElementById('container').innerHTML = httpRequest.responseText;
                if (document.querySelector('[id^=servername]')) {
                  document.title = document.title + ' | ' + document.querySelector('[id^=servername]').innerText;
                }
                window.document.dispatchEvent(new Event('DOMContentLoaded', {
                  bubbles: true,
                  cancelable: true
                }));
              } else {
                alert('There was a problem with the request.');
              }
            }
          }
        })();
      </script>
      {$loader}";
    }
    else {
      global $lgsl_server_id;
      $lgsl_server_id = isset($_GET['s']) ? $_GET['s'] : "";
      require("lgsl_files/lgsl_{$file}.php");
      return $output;
    }
  }

  $title = $lgsl_config['text']['ttl'];
  $s = isset($_GET['s']) ? $_GET['s'] : null;
  $ip = isset($_GET['ip']) ? $_GET['ip'] : null;
  $port = isset($_GET['port']) ? $_GET['port'] : null;
  if     (is_numeric($s)) { $output = load_page("details"); }
  elseif (isset($ip) && isset($port)) { $output = load_page("details");                                   }
  elseif ($s === "add")   { $output = load_page("add");     $title .= " | {$lgsl_config["text"]["aas"]}"; }
  else                    { $output = load_page("list");                                                  }
//------------------------------------------------------------------------------------------------------------+
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link rel="icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="lgsl_files/other/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta http-equiv='content-style-type' content='text/css'>
    <link rel='stylesheet' href='lgsl_files/styles/<?php echo $lgsl_config['style']; ?>' type='text/css'>
    <?php echo ($lgsl_config['autoreload'] ? "<META HTTP-EQUIV='REFRESH' CONTENT=" . ($lgsl_config['cache_time'] + 1) . ">" : ""); ?>
  </head>

  <body>
    <div id="topmenu">
      <?php
                                        echo "<li><a href='../../'>{$lgsl_config['text']['mpg']}</a></li>";   // MAIN PAGE
        if ($lgsl_config['public_add']) echo "<li><a href='?s=add'>{$lgsl_config['text']['aas']}</a></li>";   // ADD SERVER
        if (file_exists("install.php")) echo "<li><a href='./install.php'>INSTALLATION PAGE</a></li>";        // INSTALLATION PAGE
        if (isset($_GET['s']))          echo "<li><a href='./'>{$lgsl_config['text']['bak']}</a></li>";       // BACK TO SERVERS LIST
        $admin_name = htmlspecialchars($lgsl_admin_user ? $lgsl_admin_user : "Admin", ENT_QUOTES, "UTF-8");
        if ($lgsl_admin_logged_in) {
          echo "
          <li id='adminlink' class='admin_profile admin_logged_in'>
            <button type='button' class='admin_profile_button' aria-haspopup='true' aria-expanded='false'>
              <span class='admin_avatar' aria-hidden='true'>".strtoupper(substr($admin_name, 0, 1))."</span>
              <span class='admin_profile_text'>{$admin_name}</span>
            </button>
            <div class='admin_profile_menu'>
              <a href='admin.php'>".(isset($lgsl_config['text']['apn']) ? $lgsl_config['text']['apn'] : "Admin panel")."</a>
              <a href='admin.php?logout=1'>".(isset($lgsl_config['text']['lgo']) ? $lgsl_config['text']['lgo'] : "Logout")."</a>
            </div>
          </li>";
        } else {
          echo "
          <li id='adminlink' class='admin_profile admin_guest'>
            <a href='admin.php' class='admin_profile_button'>
              <span class='admin_avatar' aria-hidden='true'>?</span>
              <span class='admin_profile_text'>{$lgsl_config['text']['lgn']}</span>
            </a>
          </li>";
        }
      ?>
    </div>

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
<!-- Powered by LGSL v6.2.2; <?php echo "Page loaded: ".round(microtime(true) - $time, 6)."s";?> -->
