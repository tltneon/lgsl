<?php
  namespace tltneon\LGSL;

  /*----------------------------------------------------------------------------------------------------------\
  |                                                                                                            |
  |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                         |
  |                                                                                                            |
  |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
  |                                                                                                            |
  \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  if (!defined("LGSL_ADMIN")) { exit("DIRECT ACCESS ADMIN FILE NOT ALLOWED"); }

  require "lgsl_class.php";

  $db = LGSL::db();
  $lgsl_type_list     = Protocol::lgsl_type_list();
  $lgsl_protocol_list = Protocol::lgsl_protocol_list();

  $id        = 0;
  $last_type = "source";
  $zone_list = [0,1,2,3,4,5,6,7,8,9];

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists("fsockopen") && !$lgsl_config['feed']['method']) {
    if ((function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec"))) {
      $output = "<div class='center'><i class='space'></i><b>FSOCKOPEN IS DISABLED - YOU MUST ENABLE THE FEED OPTION</b><i class='space'></i></div>".lgsl_help_info(); return;
    } else {
      $output = "<div class='center'><i class='space'></i><b>FSOCKOPEN AND CURL ARE DISABLED - LGSL WILL NOT WORK ON THIS HOST</b><i class='space'></i></div>".lgsl_help_info(); return;
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if ($_POST) { $_POST = lgsl_stripslashes_deep($_POST); }

  @$db->set_charset("utf8");

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_save_1']) || !empty($_POST['lgsl_save_2'])) {
    if (!empty($_POST['lgsl_save_1'])) {
      // LOAD SERVER CACHE INTO MEMORY
      $servers = array();
      $mysqli_result = $db->query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`");
      foreach ($mysqli_result as $mysqli_row) {
        $servers["{$mysqli_row['type']}:{$mysqli_row['ip']}:{$mysqli_row['q_port']}"] = [$mysqli_row['status'], $mysqli_row['cache'], $mysqli_row['cache_time']];
      }
    }

    // EMPTY SQL TABLE
    $mysqli_result = $db->query("TRUNCATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ");

    // CONVERT ADVANCED TO NORMAL DATA FORMAT
    if (!empty($_POST['lgsl_management'])) {
      $form_lines = explode("\r\n", trim($_POST['form_list']));

      foreach ($form_lines as $form_key => $form_line) {
        list($_POST['form_type']    [$form_key],
             $_POST['form_ip']      [$form_key],
             $_POST['form_c_port']  [$form_key],
             $_POST['form_q_port']  [$form_key],
             $_POST['form_s_port']  [$form_key],
             $_POST['form_zone']    [$form_key],
             $_POST['form_disabled'][$form_key],
             $_POST['form_comment'] [$form_key]) = explode(":", "{$form_line}:::::::");
      }
    }

    foreach ($_POST['form_type'] as $form_key => $not_used) {
      // COMMENTS LEFT IN THEIR NATIVE ENCODING WITH JUST HTML SPECIAL CHARACTERS CONVERTED
      $_POST['form_comment'][$form_key] = lgsl_htmlspecialchars($_POST['form_comment'][$form_key]);

      $type       = $db->escape_string(strtolower(trim($_POST['form_type']   [$form_key])));
      $ip         = $db->escape_string(           trim($_POST['form_ip']     [$form_key]));
      $c_port     = $db->escape_string(intval(    trim($_POST['form_c_port'] [$form_key])));
      $q_port     = $db->escape_string(intval(    trim($_POST['form_q_port'] [$form_key])));
      $s_port     = $db->escape_string(intval(    trim($_POST['form_s_port'] [$form_key])));
      $zone       = $db->escape_string(           trim($_POST['form_zone']   [$form_key]));
      $disabled   = isset($_POST['form_disabled'][$form_key]) ? intval(trim($_POST['form_disabled'][$form_key])) : "0";
      $comment    = $db->escape_string(           trim($_POST['form_comment'][$form_key]));

      // CACHE INDEXED BY TYPE:IP:Q_PORT SO IF THEY CHANGE THE CACHE IS IGNORED
      list($status, $cache, $cache_time) = isset($servers["{$type}:{$ip}:{$q_port}"]) ? $servers["{$type}:{$ip}:{$q_port}"] : ["0", "", ""];

      $status     = $db->escape_string($status);
      $cache      = $db->escape_string($cache);
      $cache_time = $db->escape_string($cache_time);

      // THIS PREVENTS PORTS OR WHITESPACE BEING PUT IN THE IP
      $ip = trim($ip);
      if (strpos($ip, ':') !== false) {
        $c_port = explode(":", $ip)[1];
        $ip = explode(":", $ip)[0];
      }

      list($c_port, $q_port, $s_port) = Protocol::lgsl_port_conversion($type, $c_port, $q_port, $s_port);

      // DISCARD SERVERS WITH AN EMPTY IP AND AUTO DISABLE SERVERS WITH SOMETHING WRONG
      if     (!$ip)                               { continue; }
      elseif ($c_port < 1 || $c_port > 99999)     { $disabled = 1; $c_port = 0; }
      elseif ($q_port < 1 || $q_port > 99999)     { $disabled = 1; $q_port = 0; }
      elseif (!isset($lgsl_protocol_list[$type])) { $disabled = 1; }

      $mysqli_query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`zone`,`disabled`,`comment`,`status`,`cache`,`cache_time`) VALUES ('{$type}','{$ip}','{$c_port}','{$q_port}','{$s_port}','{$zone}','{$disabled}','{$comment}','{$status}','{$cache}','{$cache_time}')";
      $db->query($mysqli_query);
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_check_updates'])) {
    $context = stream_context_create(["http" => ["header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"]]);
    $lgsl_fp = file_get_contents("https://api.github.com/repos/tltneon/lgsl/branches/master", false, $context);
    $buffer1 = json_decode($lgsl_fp, true);
		$date1 = date($lgsl_config['text']['tzn'], strtotime($buffer1["commit"]["commit"]["author"]["date"]));

    $lgsl_fp = file_get_contents("https://api.github.com/repos/tltneon/lgsl/releases/latest", false, $context);
    $buffer2 = json_decode($lgsl_fp, true);
		$date2 = date($lgsl_config['text']['tzn'], strtotime($buffer2["published_at"]));
		
		

    $output .= "
      <div class='tt'>
        <div class='inlined'>
          <div>
            <h4>Latest commit (beta)</h4>
          </div>
          <div>
            <div>{$buffer1["commit"]["commit"]["message"]}</div>
            <tt>{$date1}</tt>
            <div>
              <a href='https://github.com/tltneon/lgsl/archive/master.zip'>Download</a> / <a href='{$buffer1["commit"]["html_url"]}'>Changes</a>
            </div>
          </div>
        </div>
        <div class='inlined'>
          <div>
            <h4>Latest release (stable)</h4>
          </div>
          <div>
            <div>{$buffer2["name"]}</div>
            <tt>{$date2}</tt>
            <div>
              <a href='{$buffer2["assets"][0]["browser_download_url"]}'>Download</a> / <a href='{$buffer2["html_url"]}'>Changes</a>
            </div>
          </div>
        </div>
      </div>
			<form method='post' action='' style='padding-top: 40px; text-align: center;'>
				<input type='hidden' name='lgsl_management' value='{$_POST['lgsl_management']}' />
				<input type='submit' name='lgsl_return' value='RETURN TO ADMIN' />
			</form>";

    return;
  }

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_map_image_paths'])) {
    if(!empty($_POST['lgsl_map_image_upload'])) {
      $ext = strtolower(pathinfo($_FILES['map']['name'], PATHINFO_EXTENSION));
      if ($ext === "jpg" || $ext === "gif") {
        $uploadfolder = preg_replace("/[^a-z0-9_\/]/", "_", strtolower("lgsl_files/maps/{$_POST['lgsl_map_upload_path']}/"));
        $uploadfile = preg_replace("/[^a-z0-9_]/", "_", strtolower($_POST['lgsl_map_upload_file'])) . ".{$ext}";
        if (!file_exists("{$uploadfolder}{$uploadfile}")) {
          mkdir($uploadfolder, 0666, true);
        }
        if (move_uploaded_file($_FILES['map']['tmp_name'], "{$uploadfolder}{$uploadfile}")) {
          echo "Image {$uploadfile} uploaded successfully.\n";
        } else {
          echo "File not uploaded. Something wrong.\n";
        }
      } else {
        echo "Allowed only .jpg and .gif extensions.\n";
      }
    }
    $server_list = Database::get_servers_group(["request" => "sc"]);

    $output .= "
		<div class='center'>
			<p style='padding: 5px;'>
				Haven't got images? <a href='https://github.com/tltneon/lgsl/wiki#how-can-i-add-map-images' target='_blank'>How to: add map images</a>
			</p>
    ";

    foreach ($server_list as $server) {
      if (!$server->isOnline()) { continue; }

      $image_map = $server->get_map_image();

      $output .= "
      <p style='padding-bottom: 5px;'>
        <div style='display: inline-block;'>
          <img src='{$image_map}' width='64' height='60' />
        </div>
        <div style='display: inline-block;vertical-align: super;text-align: left;'>
          <div>{$lgsl_config['text']['map']}: {$server->get_map()}</div>
          <div>Expected: /maps/{$server->get_type()}/{$server->get_game()}/{$server->get_map(true)}.jpg</div>
          <div>Current: <a href='{$image_map}' target='_blank'>{$image_map}</a></div>
          <form action='admin.php' method='post' enctype='multipart/form-data'>
            Select image to upload:
            <input type='file' name='map' id='map' />
            <input type='hidden' name='lgsl_map_upload_path' value='{$server->get_type()}/{$server->get_game()}' />
            <input type='hidden' name='lgsl_map_upload_file' value='{$server->get_map()}' />
            <input type='hidden' name='lgsl_management' value='{$_POST['lgsl_management']}' />
            <input type='hidden' name='lgsl_map_image_paths' value='true' />
            <input type='submit' name='lgsl_map_image_upload' value='Upload Image' />
          </form>
        </div>
      </p>";
    }

    $output .= "
			<form method='post' action='' style='padding: 15px;'>
				<input type='hidden' name='lgsl_management' value='{$_POST['lgsl_management']}' />
				<input type='submit' name='lgsl_return' value='RETURN TO ADMIN' />
			</form>
		</div>";

    return;
  }

//------------------------------------------------------------------------------------------------------------+

  if ((!empty($_POST['lgsl_management']) && empty($_POST['lgsl_switch'])) || (empty($_POST['lgsl_management']) && !empty($_POST['lgsl_switch'])) || (!isset($_POST['lgsl_management']) && $lgsl_config['management'])) {
    $output .= "
    <form method='post' action=''>
      <div class='center'>
        <b>TYPE : IP : C PORT : Q PORT : S PORT : ZONES : DISABLED : COMMENT</b>
        <i class='space2x'></i>
      </div>
      <div class='center'>
        <textarea name='form_list' cols='90' rows='30' wrap='off' spellcheck='false'>\r\n";

//---------------------------------------------------------+
        $mysqli_result = $db->query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ORDER BY `id` ASC;");

        foreach ($mysqli_result as $mysqli_row) {
          $output .=
          lgsl_string_html(str_pad($mysqli_row['type'],     15, " ")).":".
          lgsl_string_html(str_pad($mysqli_row['ip'],       30, " ")).":".
          lgsl_string_html(str_pad($mysqli_row['c_port'],   6,  " ")).":".
          lgsl_string_html(str_pad($mysqli_row['q_port'],   6,  " ")).":".
          lgsl_string_html(str_pad($mysqli_row['s_port'],   7,  " ")).":".
          lgsl_string_html(str_pad($mysqli_row['zone'],     7,  " ")).":".
          lgsl_string_html(str_pad($mysqli_row['disabled'], 2,  " ")).":".
                                   $mysqli_row['comment']            ."\r\n";
        }
//---------------------------------------------------------+
        $output .= "
        </textarea>
      </div>
      <div class='center'>
        <input type='hidden' name='lgsl_management' value='1' />
        <table cellspacing='20' cellpadding='0' style='text-align:center;margin:auto'>
          <tr>
            <td><input type='submit' name='lgsl_save_1'          value='".$lgsl_config['text']['skc']."' /> </td>
            <td><input type='submit' name='lgsl_save_2'          value='".$lgsl_config['text']['srh']."' /> </td>
            <td><input type='submit' name='lgsl_map_image_paths' value='".$lgsl_config['text']['mip']."' /> </td>
            <td><input type='submit' name='lgsl_switch'          value='".$lgsl_config['text']['nrm']."' /> </td>
          </tr>
        </table>
      </div>
    </form>";

    $output .= lgsl_help_info();

    return $output;
  }

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <form method='post' action=''>
    <div class='admin-server-table'>
      <table cellspacing='5' cellpadding='0'>
        <tr>
          <td>[ ID ]                           </td>
          <td>[ Game Type | Query Protocol ]   </td>
          <td>[ IP ]                           </td>
          <td>[ {$lgsl_config['text']['cpt']} ]</td>
          <td>[ {$lgsl_config['text']['qpt']} ]</td>
          <td>[ Software Port ]                </td>
          <td>[ Zones ]                        </td>
          <td>[ {$lgsl_config['text']['dsb']} ]</td>
          <td>[ Comment ]                      </td>
        </tr>";

//---------------------------------------------------------+

      $mysqli_result = $db->query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ORDER BY `id` ASC");

      foreach ($mysqli_result as $mysqli_row) {
        $id = $mysqli_row['id']; // ID USED AS [] ONLY RETURNS TICKED CHECKBOXES
        $disabled = ($mysqli_row['type'] === 'discord' ? 'readonly onclick="return false;" style="background: #777;"' : '');

        $output .= "
        <tr>
          <td>
            <a href='".LGSL::link($id)."' style='text-decoration:none' target='_blank'>{$id}</a>
          </td>
          <td>
            <select name='form_type[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_type_list as $type => $description) {
              $output .= "
              <option ".($type === $mysqli_row['type'] ? "selected='selected'" : "")." value='{$type}'>{$description}</option>";
            }

            if (!isset($lgsl_type_list[$mysqli_row['type']])) {
              $output .= "
              <option selected='selected' value='".lgsl_string_html($mysqli_row['type'])."'>".lgsl_string_html($mysqli_row['type'])."</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td class='center'><input type='text'   name='form_ip[{$id}]'     value='".lgsl_string_html($mysqli_row['ip'])."'   size='15' maxlength='255' /></td>
          <td class='center'><input type='number' name='form_c_port[{$id}]' value='".lgsl_string_html($mysqli_row['c_port'])."' min='0' max='65536' {$disabled} /></td>
          <td class='center'><input type='number' name='form_q_port[{$id}]' value='".lgsl_string_html($mysqli_row['q_port'])."' min='0' max='65536' {$disabled} /></td>
          <td class='center'><input type='number' name='form_s_port[{$id}]' value='".lgsl_string_html($mysqli_row['s_port'])."' min='0' max='65536' {$disabled} /></td>
          <td>
            <select name='form_zone[$id]'>";
//---------------------------------------------------------+
            foreach ($zone_list as $zone) {
              $output .= "
              <option ".($zone == $mysqli_row['zone'] ? "selected='selected'" : "")." value='{$zone}'>{$zone}</option>";
            }

            if (!isset($zone_list[$mysqli_row['zone']])) {
              $output .= "
              <option selected='selected' value='".lgsl_string_html($mysqli_row['zone'])."'>".lgsl_string_html($mysqli_row['zone'])."</option>";
            }
//---------------------------------------------------------+
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td class='center'><input type='checkbox' name='form_disabled[{$id}]' value='1' ".(empty($mysqli_row['disabled']) ? "" : "checked='checked'")." /></td>
          <td class='center'><input type='text'     name='form_comment[{$id}]'  value='{$mysqli_row['comment']}' size='20' maxlength='255' /></td>
        </tr>";

        $last_type = $mysqli_row['type']; // SET LAST TYPE ( $mysqli_row EXISTS ONLY WITHIN THE LOOP )
      }
//---------------------------------------------------------+
        $id ++; // NEW SERVER ID CONTINUES ON FROM LAST

        $output .= "
        <tr>
          <td>NEW<a href='https://github.com/tltneon/lgsl/wiki/Supported-Games,-Query-protocols,-Default-ports' target='_blank' id='new_q' style='position: absolute;background: #fff;border-radius: 10px;width: 14px;height: 14px;border: 2px solid;margin-top: 7px;' title='How to choose query protocol?'>?</a></td>
          <td>
            <select name='form_type[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_type_list as $type => $description) {
              $output .= "
              <option ".($type == $last_type ? "selected='selected'" : "")." value='{$type}'>{$description}</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td class='center'><input type='text'   name='form_ip[{$id}]'     value=''  size='15' maxlength='255' /></td>
          <td class='center'><input type='number' name='form_c_port[{$id}]' value=''  min='0'   max='65536'   /></td>
          <td class='center'><input type='number' name='form_q_port[{$id}]' value=''  min='0'   max='65536'   /></td>
          <td class='center'><input type='number' name='form_s_port[{$id}]' value='0' min='0'   max='65536'   /></td>
          <td>
            <select name='form_zone[{$id}]'>";
//---------------------------------------------------------+
            foreach ($zone_list as $zone) {
              $output .= "
              <option value='{$zone}'>{$zone}</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td class='center'><input type='checkbox' name='form_disabled[{$id}]' value='' /></td>
          <td class='center'><input type='text'     name='form_comment[{$id}]'  value='' size='20' maxlength='255' /></td>
        </tr>
      </table>

      <input type='hidden' name='lgsl_management' value='0' />
      <table cellspacing='20' cellpadding='0' style='text-align:center;margin:auto'>
        <tr>
          <td><input type='submit' name='lgsl_save_1'          value='{$lgsl_config['text']['skc']}' /> </td>
          <td><input type='submit' name='lgsl_save_2'          value='{$lgsl_config['text']['srh']}' /> </td>
          <td><input type='submit' name='lgsl_map_image_paths' value='{$lgsl_config['text']['mip']}' /> </td>
          <td><input type='submit' name='lgsl_switch'          value='{$lgsl_config['text']['avm']}' /> </td>
          <td><input type='submit' name='lgsl_check_updates'   value='{$lgsl_config['text']['upd']}' /> </td>
        </tr>
      </table>
    </div>
  </form>";

  $output .= lgsl_help_info();

//------------------------------------------------------------------------------------------------------------+

  function lgsl_help_info() {
    global $lgsl_config;
    return "
    <div class='admin-help-info'>
      <i class='space'></i>
      <a href='https://github.com/tltneon/lgsl/wiki'>[ LGSL ONLINE WIKI ]</a> <a href='https://github.com/tltneon/lgsl'>[ LGSL GITHUB ]</a>
      <i class='space'></i>
      {$lgsl_config['text']['faq']}
      <i class='space'></i>
      <table cellspacing='10' cellpadding='0'>
        <tr>
          <td> <a href='http://php.net/fsockopen'>FSOCKOPEN</a> </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("fsockopen") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( {$lgsl_config['text']['fso']} ) </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/curl'>CURL</a> </td>
          <td> {$lgsl_config['text']['enb']}: ".((function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec")) ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( {$lgsl_config['text']['crl']} ) </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/mbstring'>MBSTRING</a> </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("mb_convert_encoding") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( {$lgsl_config['text']['mbs']} ) </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/bzip2'>BZIP2</a> </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("bzdecompress") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( {$lgsl_config['text']['bz2']} ) </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/gd2'>GD</a> </td>
          <td> {$lgsl_config['text']['enb']}: ".(extension_loaded("gd") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( {$lgsl_config['text']['gd2']} ) </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/zlib'>ZLIB</a> </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("gzuncompress") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( {$lgsl_config['text']['zli']} ) </td>
        </tr>
      </table>
      <i class='space2x'></i>
    </div>";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_stripslashes_deep($value) {
    $value = is_array($value) ? array_map('tltneon\LGSL\lgsl_stripslashes_deep', $value) : stripslashes($value);
    return $value;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_htmlspecialchars($string) {
    // PHP4 COMPATIBLE WAY OF CONVERTING SPECIAL CHARACTERS WITHOUT DOUBLE ENCODING EXISTING ENTITIES
    $string = str_replace("\x05\x06", "", $string);
    $string = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x05\x06$1", $string);
    $string = htmlspecialchars($string, ENT_QUOTES);
    $string = str_replace("\x05\x06", "&", $string);

    return $string;
  }

//------------------------------------------------------------------------------------------------------------+
