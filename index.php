<?php
//------------------------------------------------------------------------------------------------------------+
  $time = microtime(true);
  header("Content-Type:text/html; charset=utf-8");

  require ("src/lgsl_config.php");
  require ("src/lgsl_language.php");
  $lang = new tltneon\LGSL\Lang($_COOKIE['lgsl_lang']);
	if (empty($lgsl_config['installed'])) header("Location: install.php");
  global $output, $title;

  function load_page($file) {
    global $lgsl_config;
    if ($lgsl_config['preloader']) {
      $loader = @file_get_contents('src/other/loader.html');
      $post = http_build_query($_POST);
      $get = http_build_query($_GET);
      return "
      <script>
        (function() {
          httpRequest = new XMLHttpRequest();
          if (!httpRequest) {
            return alert('Cannot create an XMLHTTP instance');
          }
          httpRequest.onreadystatechange = alertContents;
          httpRequest.open('POST', 'src/lgsl_{$file}.php?{$get}', true);
          httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          httpRequest.send('{$post}')

          function alertContents() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
              document.getElementById('container').innerHTML = httpRequest.responseText;
              if (httpRequest.status === 200) {
                if (document.querySelector('[id^=servername]')) {
                  document.title += ' | ' + document.querySelector('[id^=servername]').innerText;
                }
                window.document.dispatchEvent(new Event('DOMContentLoaded', {bubbles: true, cancelable: true }));
              } else {
                alert('There was a problem with the request.\\nHTTP Code: ' + httpRequest.status + '\\nSee php_error.log for details.');
              }
            }
          }
        })();
      </script>
      {$loader}";
    } else {
      $GLOBALS['lgsl_server_id'] = (int) $_GET['s'];
      require("src/lgsl_{$file}.php");
      return $output;
    }
  }

  $title = $lgsl_config['text']['ttl'];
  $s = $_GET['s'] ?? null;
  $ip = $_GET['ip'] ?? null;
  $port = $_GET['port'] ?? null;
  if ($s === "add")                     { $output = load_page("add");     $title .= " | {$lang->get("aas")}";}
  elseif ((int) $s > 0 || $ip && $port) { $output = load_page("details");                                    }
  else                                  { $output = load_page("list");                                       }
//------------------------------------------------------------------------------------------------------------+
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link rel="icon" href="src/other/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="src/other/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta http-equiv='content-style-type' content='text/css'>
    <link rel="canonical" href="<?php echo "http{$s}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">
    <link rel='stylesheet' href='src/styles/<?php echo $lgsl_config['style']; ?>' type='text/css'>
		<?php echo ($lgsl_config['locations'] ? "<link rel='stylesheet' href='src/other/_lgsl_locations.css' type='text/css' />" : ""); ?>
    <?php echo ($lgsl_config['autoreload'] ? "<META HTTP-EQUIV='REFRESH' CONTENT=" . ($lgsl_config['cache_time'] + 1) . " />" : ""); ?>
  </head>

  <body>
    <div id="topmenu">
      <?php
        $menu = [
          ["condition" => true, "link" => '../../', "text" => $lang->get("mpg")], // MAIN PAGE
          ["condition" => $lgsl_config['public_add'], "link" => '?s=add', "text" => $lang->get("aas")], // ADD SERVER
          ["condition" => file_exists("install.php"), "link" => './install.php', "text" => $lang->get("isp")], // INSTALLATION PAGE 
          ["condition" => $s || $ip, "link" => './', "text" => $lang->get("bak")] // BACK TO SERVERS LIST
        ];
        foreach ($menu as $item) {
          if ($item["condition"]) {
            echo "<li><a href='{$item["link"]}'>{$item["text"]}</a></li>";
          }
        }
      ?>
      <select name='language' onChange='changeLang(event)'>
      <?php
        foreach (tltneon\LGSL\Lang::list() as $lang) {
          $select = $_COOKIE['lgsl_lang'] === $lang ? "selected": "";
          echo "<option {$select}>{$lang}</option>";
        }
      ?>
      </select>
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
          echo "<script src='src/scripts/{$script}'></script>";
        }
      }
    ?>
    <script>
      function changeLang(event) {
        document.cookie = `lgsl_lang=${event.target.value}; expires=Thu, 18 Dec 2099 12:00:00 UTC; path=/`;
        location.reload();
      }
    </script>
  </body>
</html>
<!-- Powered by LGSL v7.0.0; <?php echo "Page loaded: ".round(microtime(true) - $time, 6)."s";?> -->