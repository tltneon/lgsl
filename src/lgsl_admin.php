<?php
  namespace tltneon\LGSL;

  /*----------------------------------------------------------------------------------------------------------\
  |                                                                                                            |
  |                      [ LIVE GAME SERVER LIST ] [ RICHARD PERRY FROM GREYCUBE.COM ]                         |
  |                                                                                                            |
  |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
  |                                                                                                            |
  \-----------------------------------------------------------------------------------------------------------*/

  if (!defined("LGSL_ADMIN")) { header('HTTP/1.0 404 Not Found'); exit(); }

  require_once "lgsl_class.php";
  require_once "lgsl_language.php";
  $lang = new Lang($_COOKIE['lgsl_lang'] ?? Lang::EN);

  if (!function_exists("fsockopen") && !$lgsl_config['feed']['method']) {
    if (LGSL::isEnabled("curl")) {
      $note = "FSOCKOPEN IS DISABLED - YOU MUST ENABLE THE FEED OPTION";
    } else {
      $note = "FSOCKOPEN AND CURL ARE DISABLED - LGSL WILL NOT WORK ON THIS HOST";
    }
    $output = "<div class='center'><i class='space'></i><b>{$note}</b><i class='space'></i></div>".lgslHelpInfo(); return;
  }

  $lgsl_admin_class = new LGSLAdmin();
  $db = LGSL::db();
  $id = 0;

  if ($_POST) { $_POST = lgslStripSlashesDeep($_POST); }
  @$db->set_charset("utf8");

  if (!empty($_POST['lgsl_save_1']) || !empty($_POST['lgsl_save_2'])) {
    if (!empty($_POST['lgsl_save_1'])) {
      // LOAD SERVER CACHE INTO MEMORY
      $servers = [];
      $result = $db->get_all();
			
      foreach ($result as $row) {
        $servers["{$row['type']}:{$row['ip']}:{$row['q_port']}"] = [$row['status'], $row['cache'], $row['cache_time']];
      }
    }

    // EMPTY SQL TABLE		
    $result = $db->clear();

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
             $_POST['form_comment'] [$form_key]) = explode(":", "{$form_line}", 8);
      }
    }

    $duplicateCheck = [];
    foreach ($_POST['form_type'] as $form_key => $not_used) {
      // THIS PREVENTS PORTS OR WHITESPACE BEING PUT IN THE IP
      $_POST['form_ip'][$form_key] = trim($_POST['form_ip'][$form_key]);
      if (strpos($_POST['form_ip'][$form_key], ':') !== false) {
        $_POST['form_c_port'][$form_key] = explode(":", $_POST['form_ip'][$form_key])[1];
        $_POST['form_ip'][$form_key] = explode(":", $_POST['form_ip'][$form_key])[0];
      }

      // COMMENTS LEFT IN THEIR NATIVE ENCODING WITH JUST HTML SPECIAL CHARACTERS CONVERTED
      $_POST['form_comment'][$form_key] = htmlspecialchars($_POST['form_comment'][$form_key], ENT_QUOTES);

      $type       = $db->escape_string(strtolower(trim($_POST['form_type']   [$form_key])));
      $ip         = $db->escape_string(           trim($_POST['form_ip']     [$form_key]));
      $c_port     = $db->escape_string(intval(    trim($_POST['form_c_port'] [$form_key])));
      $q_port     = $db->escape_string(intval(    trim($_POST['form_q_port'] [$form_key])));
      $s_port     = $db->escape_string(intval(    trim($_POST['form_s_port'] [$form_key])));
      $zone       = $db->escape_string(           trim($_POST['form_zone']   [$form_key]));
      $disabled   = isset($_POST['form_disabled'][$form_key]) ? intval(trim($_POST['form_disabled'][$form_key])) : "0";
      $comment    = $db->escape_string(           trim($_POST['form_comment'][$form_key]));

      // REMOVE DUPLICATES
      if (in_array("{$ip}:{$c_port}", $duplicateCheck)) {
        continue;
      } else {
        array_push($duplicateCheck, "{$ip}:{$c_port}");
      };

      // CACHE INDEXED BY TYPE:IP:Q_PORT SO IF THEY CHANGE THE CACHE IS IGNORED
      list($status, $cache, $cache_time) = isset($servers["{$type}:{$ip}:{$q_port}"]) ? $servers["{$type}:{$ip}:{$q_port}"] : ["0", "", ""];

      $status     = $db->escape_string($status);
      $cache      = $db->escape_string($cache);
      $cache_time = $db->escape_string($cache_time);


      list($c_port, $q_port, $s_port) = Protocol::lgsl_port_conversion($type, $c_port, $q_port, $s_port);

      // DISCARD SERVERS WITH AN EMPTY IP AND AUTO DISABLE SERVERS WITH SOMETHING WRONG
      if     (!$ip)                               { continue; }
      elseif ($c_port < 1 || $c_port > 65535)     { $disabled = 1; $c_port = 0; }
      elseif ($q_port < 1 || $q_port > 65535)     { $disabled = 1; $q_port = 0; }
      elseif (!isset($lgsl_admin_class->getProtocols()[$type])) { $disabled = 1; }

      $query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`zone`,`disabled`,`comment`,`status`,`cache`,`cache_time`) VALUES ('{$type}','{$ip}','{$c_port}','{$q_port}','{$s_port}','{$zone}','{$disabled}','{$comment}','{$status}','{$cache}','{$cache_time}')";
			$db->execute($query);
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_check_updates'])) {
    $stream = new Stream(PROTOCOL::HTTP);
    $stream->open();
    $stream->write("https://api.github.com/repos/tltneon/lgsl/branches/lgsl7");
    $buffer1 = $stream->readJson();
    if (!$buffer1) {
      $output .= "
      <div class='tt' style='padding: 10px;'>
        CAN'T LOAD DATA FROM GITHUB.COM -> NO INTERNET CONNECTION?
      </div>
      " . lgslReturnButtons();
      return;
    }
    $stream->write("https://api.github.com/repos/tltneon/lgsl/releases/latest");
    $buffer2 = $stream->readJson();
    if (isset($buffer1["message"]) || isset($buffer2["message"])) {
      $output .= "
      <div class='tt' style='padding: 10px;'>
        {$buffer1["message"]}<br>{$buffer2["message"]}
      </div>
      " . lgslReturnButtons();
      return;
    }

    $blocks = [
      ["Latest commit (LGSL7)", $buffer1["commit"]["commit"]["message"], date($lgsl_config['text']['tzn'], strtotime($buffer1["commit"]["commit"]["author"]["date"])), "https://github.com/tltneon/lgsl/archive/refs/heads/lgsl7.zip", $buffer1["commit"]["html_url"]],
      ["Latest release (stable)", $buffer2["name"], date($lgsl_config['text']['tzn'], strtotime($buffer2["published_at"])), $buffer2["assets"][0]["browser_download_url"], $buffer2["html_url"]],
    ];
    $output .= "
      <div class='tt'>";
      foreach ($blocks as $block) {
        $output .= "
        <div class='inlined'>
          <div>
            <h4>{$block[0]}</h4>
          </div>
          <div>
            <div>{$block[1]}</div>
            <tt>{$block[2]}</tt>
            <div>
              <a href='{$block[3]}'>Download</a> / <a href='{$block[4]}'>Changes</a>
            </div>
          </div>
        </div>
        ";
      }
        $output .= "
      </div>
			" . lgslReturnButtons() . "
      ";
    return;
  }
  if (!empty($_POST['lgsl_wiki_games_list'])) {
    $output .= lgslShowWikiPage();
    return;
  }

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_map_image_paths'])) {
    if(!empty($_POST['lgsl_map_image_upload'])) {
      $ext = strtolower(pathinfo($_FILES['map']['name'], PATHINFO_EXTENSION));
      if ($ext === "jpg" || $ext === "gif") {
        $uploadfolder = preg_replace("/[^a-z0-9_\/]/", "_", strtolower("src/maps/{$_POST['lgsl_map_upload_path']}/"));
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
    $server_list = Database::getServersGroup(["request" => "sc"]);

    $output .= "
		<div class='center'>
			<p style='padding: 5px;'>
				Haven't got images? <a href='https://github.com/tltneon/lgsl/wiki#how-can-i-add-map-images' target='_blank'>How to: add map images</a>
			</p>
    ";

    foreach ($server_list as $server) {
      if (!$server->isOnline()) { continue; }

      $image_map = $server->getMapImage();

      $output .= "
      <p style='padding-bottom: 5px;'>
        <div style='display: inline-block;'>
          <img src='{$image_map}' width='64' height='60' />
        </div>
        <div style='display: inline-block;vertical-align: super;text-align: left;'>
          <div>{$lgsl_config['text']['map']}: {$server->getMap()}</div>
          <div>Expected: /maps/{$server->getType()}/{$server->getGame()}/{$server->getMap(true)}.jpg</div>
          <div>Current: <a href='{$image_map}' target='_blank'>{$image_map}</a></div>
          <form action='admin.php' method='post' enctype='multipart/form-data'>
            Select image to upload:
            <input type='file' name='map' id='map' />
            <input type='hidden' name='lgsl_map_upload_path' value='{$server->getType()}/{$server->getGame()}' />
            <input type='hidden' name='lgsl_map_upload_file' value='{$server->getMap()}' />
            <input type='hidden' name='lgsl_management' value='{$_POST['lgsl_management']}' />
            <input type='hidden' name='lgsl_map_image_paths' value='true' />
            <input type='submit' name='lgsl_map_image_upload' value='Upload Image' />
          </form>
        </div>
      </p>";
    }

    $output .= "
    " . lgslReturnButtons() . "
		</div>";

    return;
  }

//------------------------------------------------------------------------------------------------------------+

if (!empty($_POST['lgsl_server_protocol_detection'])) {
  $time = microtime(true);
  $_POST["q_port"] = isset($_POST["q_port"]) ? explode(",", str_replace(" ", "", $_POST["q_port"])) : [27015, 27016];
  $_POST['ip'] = $_POST['ip'] ?? "127.0.0.1";
  $_POST['protocols'] = $_POST['protocols'] ?? ["source"];
  $log = "";
  foreach ($_POST["q_port"] as $q) {
    $log .= "Querying {$_POST['ip']}:{$q}<br>";
    foreach ($_POST["protocols"] as $p) {
      $server = new Server([
          "ip" => $_POST["ip"], // server ip or hostname
          "q_port" => $q, // for querying
          "type" => $p // protocol name from lgsl_type_list()
      ]);
      $server->queryLive("s"); // s - server info, e - extra data, p - players info
      $log .= "[type: {$server->getType()}] " . ($server->getStatus() === Server::OFFLINE ? $lgsl_config['text'][$server->getStatus()] : "[game: {$server->getGame()}] [data: {$server->getName(true)} | {$server->getPlayersCount()} | {$lgsl_config['text'][$server->getStatus()]}]") ."<br>";
    }
    $log .= "<br>";
  }
  $log .= "Querying takes: ".round(microtime(true) - $time, 6)."s.";

  $output .= "
  <h5 style='text-align:center;margin:auto;padding:10px;'>Protocol Detection Section: be aware that selecting bunch of protocols or ports may take a lot of time to proceed.</h5>
  <div id='protocols_list'>
    <form method='post'>
      Protocols:
      <select multiple name='protocols[]' style='height:175px'>
        ";
          $prot = $lgsl_admin_class->getProtocols();
          foreach ($prot as $k => $v) {
            $active = in_array($k, $_POST['protocols']) ? "selected='selected'" : '';
            $output .= "<option value='{$k}' {$active}>{$v}</option>";
          }
      $output .=  "
      </select>
      <div>Server IP: <input type='input' name='ip' value='{$_POST['ip']}'></div>
      <div>Query ports: <input type='input' name='q_port' value='" . implode(',', $_POST['q_port']) . "'></div>
      <div>Query limit: {$lgsl_config['live_time']}s. per server</div>
      <input type='submit' name='lgsl_server_protocol_detection'>
    </form>
  </div>
  <div id='protocols_log'>
    {$log}
  </div>
  ";

  $output .= "
    " . lgslReturnButtons() . "
  </div>";

  return;
}
//------------------------------------------------------------------------------------------------------------+
  $headers = ['Game Type | Query Protocol', 'IP | ID', $lgsl_config['text']['cpt'], $lgsl_config['text']['qpt'], 'S Port', 'Zone', $lgsl_config['text']['dsb'], 'Comment | Additional Data'];
  if ((!empty($_POST['lgsl_management']) && empty($_POST['lgsl_switch'])) || (empty($_POST['lgsl_management']) && !empty($_POST['lgsl_switch'])) || (!isset($_POST['lgsl_management']) && $lgsl_config['management'])) {
    $headersHtml = rtrim(array_reduce($headers,
			function($a, $b) {
				return "{$a}{$b} : ";
			}), ': ');
    $output .= "
    <form method='post' action=''>
      <div class='center'>
        <b>{$headersHtml}</b>
        <i class='space2x'></i>
      </div>
      <div class='center'>
        <textarea name='form_list' cols='90' rows='30' wrap='off' spellcheck='false'>\r\n";

        $result = $db->get_all();

        foreach ($result as $row) {
          $output .=
          str_pad($row['type'],     15, " ").":".
          str_pad($row['ip'],       30, " ").":".
          str_pad($row['c_port'],   6,  " ").":".
          str_pad($row['q_port'],   6,  " ").":".
          str_pad($row['s_port'],   7,  " ").":".
          str_pad($row['zone'],     7,  " ").":".
          str_pad($row['disabled'], 2,  " ").":".
              $row['comment']            ."\r\n";
        }
        $output .= "
        </textarea>
      </div>
      <div class='center'>
        <input type='hidden' name='lgsl_management' value='1'>
        " . lgslMainButtons() . "
      </div>
    </form>";

    $output .= lgslHelpInfo();

    return $output;
  }

//------------------------------------------------------------------------------------------------------------+

  $headersHtml = array_reduce([...['#'], ...$headers],
			function($a, $b) {
				return "{$a}<th>[ {$b} ]</th>";
			});
  $output .= "
  <form method='post' action=''>
    <div class='admin-server-table'>
      <table>
        <tr>
        " . $headersHtml . "
        </tr>";

      $result = $db->get_all();
      foreach ($result as $row) {
        $output .= $lgsl_admin_class->drawServerRow($row);
      }
      $output .= $lgsl_admin_class->drawServerRow(['id' => $id++], true);
      $output .= "
      </table>

      <input type='hidden' name='lgsl_management' value='0'>
      " . lgslMainButtons() . "
    </div>
  </form>";

  $output .= lgslHelpInfo();

//------------------------------------------------------------------------------------------------------------+
  class LGSLAdmin {
    private $protocols = [];
    private $zoneList = [0,1,2,3,4,5,6,7,8,9];
    private $lastType = "source";
    function __construct() {
      $this->protocols = Protocol::lgsl_type_list();
    }
    function getProtocols() {
      return $this->protocols;
    }
    function generateSelectBlock($form, $id, &$list, $code, $useDescription = false) {
      $output = "
      <select name='form_{$form}[$id]'>";
        foreach ($list as $key => $item) {
          if ($useDescription) $output .= "<option ".($key === $code ? "selected='selected'" : "")." value='{$key}'>{$item}</option>";
          else $output .= "<option ".($item === $code ? "selected='selected'" : "")." value='{$item}'>{$item}</option>";
        }
        if (!isset($list[$code])) {
          $output .= "<option selected='selected' value='{$code}'>{$code}</option>";
        }
      $output .= "
      </select>";
      return $output;
    }
    function drawServerRow(array $row, bool $isNew = false) {
      $id = $row['id'];
      if ($isNew) {
        $row = ['type' => $this->lastType, 'ip' => '', 'c_port' => '', 'q_port' => '', 's_port' => '', 'zone' => 0, 'disabled' => '', 'comment' => ''];
      }
      $isDisabled = function($check) {
        return $check ? 'readonly onclick="return false;" style="background: #777; cursor: not-allowed;"' : '';
      };
      $hasSPort = $isDisabled(!in_array($row['type'], [Protocol::UT2003, Protocol::UT2004]));
      $noPort = $isDisabled(Protocol::lgslProtocolWithoutPort($row['type']));
      $output = "
      <tr>";
        if ($isNew) {
          $output .= "<td>NEW<a href='https://github.com/tltneon/lgsl/wiki/Supported-Games,-Query-protocols,-Default-ports' target='_blank' id='new_q' style='position: absolute;background: #fff;border-radius: 10px;width: 14px;height: 14px;border: 2px solid;margin-top: 7px;' title='How to choose query protocol?'>?</a></td>";
        } else {
          $output .= "<td><a href='".LGSL::link($id)."' style='text-decoration:none' target='_blank'>{$id}</a></td>";
        }
        $output .= "
        <td>";
          $output .= $this->generateSelectBlock("type", $id, $this->protocols, $row['type'], true);
          $output .= "
        </td>
        <td class='center'><input type='text'   name='form_ip[{$id}]'     value='{$row['ip']}'   size='15' maxlength='255'></td>
        <td class='center'><input type='number' name='form_c_port[{$id}]' value='{$row['c_port']}' min='0' max='65536' {$noPort}></td>
        <td class='center'><input type='number' name='form_q_port[{$id}]' value='{$row['q_port']}' min='0' max='65536' {$noPort}></td>
        <td class='center'><input type='number' name='form_s_port[{$id}]' value='{$row['s_port']}' min='0' max='65536' {$hasSPort}></td>
        <td>";
          $output .= $this->generateSelectBlock("zone", $id, $this->zoneList, $row['zone']);
          $output .= "
        </td>
        <td class='center'><input type='checkbox' name='form_disabled[{$id}]' value='1' ".(empty($row['disabled']) ? "" : "checked='checked'")."></td>
        <td class='center'><input type='text'     name='form_comment[{$id}]'  value='{$row['comment']}' size='20' maxlength='255'></td>
      </tr>";
      $this->lastType = $row['type'];
      return $output;
    }
  }

  function lgslHelpInfo() {
    global $lgsl_config;
    $funcs = [
      ["href" => "http://php.net/fsockopen", "name" => "FSOCKOPEN", "test" => function_exists("fsockopen"), "desc" => "fso"],
      ["href" => "http://php.net/curl", "name" => "CURL", "test" => LGSL::isEnabled("curl"), "desc" => "crl"],
      ["href" => "http://php.net/mbstring", "name" => "MBSTRING", "test" => function_exists("mb_convert_encoding"), "desc" => "mbs"],
      ["href" => "http://php.net/bzip2", "name" => "BZIP2", "test" => function_exists("bzdecompress"), "desc" => "bz2"],
      ["href" => "http://php.net/gd", "name" => "GD", "test" => LGSL::isEnabled("gd"), "desc" => "gd2"],
      ["href" => "http://php.net/zlib", "name" => "ZLIB", "test" => function_exists("gzuncompress"), "desc" => "zli"],
    ];
    $output = "";
    foreach ($funcs as $func) {
      $output .= "
      <tr>
        <td> <a href='{$func['href']}' target='_blank'>{$func['name']}</a> </td>
        <td> {$lgsl_config['text']['enb']}: ".($func['test'] ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
        <td> ( {$lgsl_config['text'][$func['desc']]} ) </td>
      </tr>
      ";
    }
    return "
    <div class='admin-help-info'>
      <i class='space'></i>
      <a href='https://github.com/tltneon/lgsl/wiki'>[ LGSL ONLINE WIKI ]</a> <a href='https://github.com/tltneon/lgsl'>[ LGSL GITHUB ]</a>
      <i class='space'></i>
      {$lgsl_config['text']['faq']}
      <i class='space'></i>
      <table cellspacing='10' cellpadding='0'>
        {$output}
      </table>
      <i class='space2x'></i>
    </div>";
  }

  function isNormal() {
    return (int) ($_POST['lgsl_management'] ?? 0);
  }
  function lgslStripSlashesDeep($value) {
    $value = is_array($value) ? array_map('tltneon\LGSL\lgslStripSlashesDeep', $value) : stripslashes($value);
    return $value;
  }

  function lgslReturnButtons() {
    $management = isNormal();
    return "
    <form method='post' action='' style='padding: 15px;text-align:center;margin:auto'>
      <input type='hidden' name='lgsl_management' value='{$management}'>
      <input type='submit' name='lgsl_return' value='RETURN TO ADMIN'>
    </form>";
  }
  function lgslMainButtons() {
    global $lgsl_config;
    $management = isNormal() ? $lgsl_config['text']['nrm'] : $lgsl_config['text']['avm'];
    return "
    <div id='lgsl_main_buttons'>
      <input type='submit' name='lgsl_save_1'          value='{$lgsl_config['text']['skc']}'>
      <input type='submit' name='lgsl_save_2'          value='{$lgsl_config['text']['srh']}'>
      <input type='submit' name='lgsl_map_image_paths' value='{$lgsl_config['text']['mip']}'>
      <input type='submit' name='lgsl_switch'          value='{$management}'>
      <input type='submit' name='lgsl_server_protocol_detection' value='Detect Protocol'>
      <input type='submit' name='lgsl_check_updates'   value='{$lgsl_config['text']['upd']}'>
      <input type='submit' name='lgsl_wiki_games_list' value='Games List'>
    </div>";
  }
  function lgslShowWikiPage() {
    $stream = new Stream(PROTOCOL::HTTP);
    $stream->open();
    $stream->write("https://raw.githubusercontent.com/wiki/tltneon/lgsl/Supported-Games,-Query-protocols,-Default-ports.md");
    $stream->setOpt(CURLOPT_TIMEOUT, 10);
    $markdown = $stream->readRaw();
    $markdown = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $markdown);
    $markdown = preg_replace('/^#### (.*)$/m', '<h4>$1</h4>', $markdown);
    $markdown = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/^\* (.*)$/m', '<ul><li>$1</li></ul>', $markdown);
    $markdown = preg_replace('/<\/ul><ul>/', '', $markdown);
    $markdown = preg_replace('/^\d+\. (.*)$/m', '<ol><li>$1</li></ol>', $markdown);
    $markdown = preg_replace('/<\/ol><ol>/', '', $markdown);

    // Регулярное выражение для извлечения строк таблицы
    $pattern = '/\| (.*?) \| (.*?) \| (.*?) \| (.*?) \|/';

    // Применяем регулярное выражение
    preg_match_all($pattern, $markdown, $matches, PREG_OFFSET_CAPTURE);
    // Начало HTML-таблицы
    $output = "<table id='protocols_table'>";

    // Перебираем результаты и выводим строки в таблицу
    foreach ($matches[1] as $index => $match) {
        // Извлекаем значения для каждого столбца
        $game = $match[0];
        $queryProtocol = $matches[2][$index][0];
        $defaultQueryPort = $matches[3][$index][0];

        $output .= "<tr><td>{$game}</td><td>{$queryProtocol}</td><td>{$defaultQueryPort}</td></tr>";
    }

    // Закрытие таблицы
    $output .= "</table>
    <a href='https://github.com/tltneon/lgsl/wiki/Supported-Games,-Query-protocols,-Default-ports' target='_blank'>For more information visit wiki page</a>";
    return $output . lgslReturnButtons();
  }
