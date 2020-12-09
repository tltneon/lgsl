<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  if (!defined("LGSL_ADMIN")) { exit("DIRECT ACCESS ADMIN FILE NOT ALLOWED"); }

  require "lgsl_class.php";
	
	global $lgsl_database;

  lgsl_database();
  $lgsl_type_list     = lgsl_type_list(); asort($lgsl_type_list);
  $lgsl_protocol_list = lgsl_protocol_list();

  $id        = 0;
  $last_type = "source";
  $zone_list = array(0,1,2,3,4,5,6,7,8);

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists("fsockopen") && !$lgsl_config['feed']['method'])
  {
    if ((function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec")))
    {
      $output = "<div style='text-align:center'><br /><br /><b>FSOCKOPEN IS DISABLED - YOU MUST ENABLE THE FEED OPTION</b><br /><br /></div>".lgsl_help_info(); return;
    }
    else
    {
      $output = "<div style='text-align:center'><br /><br /><b>FSOCKOPEN AND CURL ARE DISABLED - LGSL WILL NOT WORK ON THIS HOST</b><br /><br /></div>".lgsl_help_info(); return;
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if ($_POST) { $_POST = lgsl_stripslashes_deep($_POST); }

  if (function_exists("mysqli_set_charset"))
  {
    @mysqli_set_charset($lgsl_database, "utf8");
  }
  else
  {
    @mysqli_query($lgsl_database, "SET NAMES 'utf8'");
  }

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_save_1']) || !empty($_POST['lgsl_save_2']))
  {
    if (!empty($_POST['lgsl_save_1']))
    {
      // LOAD SERVER CACHE INTO MEMORY
      $db = array();
      $mysqli_result = mysqli_query($lgsl_database, "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`");
      while($mysqli_row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC))
      {
        $db["{$mysqli_row['type']}:{$mysqli_row['ip']}:{$mysqli_row['q_port']}"] = array($mysqli_row['status'], $mysqli_row['cache'], $mysqli_row['cache_time']);
      }
    }

    // EMPTY SQL TABLE
    $mysqli_result = mysqli_query($lgsl_database, "TRUNCATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`") or die(mysqli_error($lgsl_database));

    // CONVERT ADVANCED TO NORMAL DATA FORMAT
    if (!empty($_POST['lgsl_management']))
    {
      $form_lines = explode("\r\n", trim($_POST['form_list']));

      foreach ($form_lines as $form_key => $form_line)
      {
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

    foreach ($_POST['form_type'] as $form_key => $not_used)
    {
      // COMMENTS LEFT IN THEIR NATIVE ENCODING WITH JUST HTML SPECIAL CHARACTERS CONVERTED
      $_POST['form_comment'][$form_key] = lgsl_htmlspecialchars($_POST['form_comment'][$form_key]);

      $type       = mysqli_real_escape_string($lgsl_database,                strtolower(trim($_POST['form_type']    [$form_key])));
      $ip         = mysqli_real_escape_string($lgsl_database,                           trim($_POST['form_ip']      [$form_key]));
      $c_port     = mysqli_real_escape_string($lgsl_database,                    intval(trim($_POST['form_c_port']  [$form_key])));
      $q_port     = mysqli_real_escape_string($lgsl_database,                    intval(trim($_POST['form_q_port']  [$form_key])));
      $s_port     = mysqli_real_escape_string($lgsl_database,                    intval(trim($_POST['form_s_port']  [$form_key])));
      $zone       = mysqli_real_escape_string($lgsl_database,                           trim($_POST['form_zone']    [$form_key]));
      $disabled   = isset($_POST['form_disabled'][$form_key]) ? intval(trim($_POST['form_disabled'][$form_key])) : "0";
      $comment    = mysqli_real_escape_string($lgsl_database,                           trim($_POST['form_comment'] [$form_key]));

      // CACHE INDEXED BY TYPE:IP:Q_PORT SO IF THEY CHANGE THE CACHE IS IGNORED
      list($status, $cache, $cache_time) = isset($db["{$type}:{$ip}:{$q_port}"]) ? $db["{$type}:{$ip}:{$q_port}"] : array("0", "", "");

      $status     = mysqli_real_escape_string($lgsl_database, $status);
      $cache      = mysqli_real_escape_string($lgsl_database, $cache);
      $cache_time = mysqli_real_escape_string($lgsl_database, $cache_time);

      // THIS PREVENTS PORTS OR WHITESPACE BEING PUT IN THE IP
			$ip = trim($ip);
			if (strpos($ip, ':') !== false){
				$c_port = explode(":", $ip)[1];
				$ip = explode(":", $ip)[0];
			}

      list($c_port, $q_port, $s_port) = lgsl_port_conversion($type, $c_port, $q_port, $s_port);

      // DISCARD SERVERS WITH AN EMPTY IP AND AUTO DISABLE SERVERS WITH SOMETHING WRONG
      if     (!$ip)                               { continue; }
      elseif ($c_port < 1 || $c_port > 99999)     { $disabled = 1; $c_port = 0; }
      elseif ($q_port < 1 || $q_port > 99999)     { $disabled = 1; $q_port = 0; }
      elseif (!isset($lgsl_protocol_list[$type])) { $disabled = 1; }

      $mysqli_query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`zone`,`disabled`,`comment`,`status`,`cache`,`cache_time`) VALUES ('{$type}','{$ip}','{$c_port}','{$q_port}','{$s_port}','{$zone}','{$disabled}','{$comment}','{$status}','{$cache}','{$cache_time}')";
      $mysqli_result = mysqli_query($lgsl_database, $mysqli_query) or die(mysqli_error($lgsl_database));
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_check_updates']))
  {
		
		$context = stream_context_create(
				array(
						"http" => array(
								"header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
						)
				)
		);
		$lgsl_fp = file_get_contents("https://api.github.com/repos/tltneon/lgsl/branches/master", false, $context);
		$buffer1 = json_decode($lgsl_fp, true);
		 
		$lgsl_fp = file_get_contents("https://api.github.com/repos/tltneon/lgsl/releases/latest", false, $context);
		$buffer2 = json_decode($lgsl_fp, true);
 
		$output .= '
			<div class="tt">
				<div class="inlined">
					<div>
						<h4>Latest commit (beta)</h4>
					</div>
					<div>
						<div>'.$buffer1["commit"]["commit"]["message"].'</div>
						<tt>'.date("Y-m-d H:i:s", strtotime($buffer1["commit"]["commit"]["author"]["date"])).'</tt>
						<div>
							<a href="https://github.com/tltneon/lgsl/archive/master.zip">Download</a> or <a href="'.$buffer1["commit"]["html_url"].'">Changes</a>
						</div>
					</div>
				</div>
				<div  class="inlined">
					<div>
						<h4>Latest release (stable)</h4>
					</div>
					<div>
						<div>'.$buffer2["name"].'</div>
						<tt>'.date("Y-m-d H:i:s", strtotime($buffer2["published_at"])).'</tt>
						<div>
							<a href="'.$buffer2["assets"][0]["browser_download_url"].'">Download</a> or <a href="'.$buffer2["html_url"].'">Changelog</a>
						</div>
					</div>
				</div>
			</div>
			<style>
				.inlined {
					display: inline-block; 
					width: 300px;
					vertical-align: top;
				}
				.tt{
					margin: auto;
					width: 610px;
				}
				.tt > .inlined:nth-child(2) {
					text-align: end;
				}
				.inlined > div > div:first-child {
					height: 46px;
					overflow-y: auto;
				}
				::-webkit-scrollbar-thumb {
					background-color: gray;
				}

				::-webkit-scrollbar {
					width: 6px;
					background: #3e3e3e;
				}
				@media(max-width: 414px){
					.inlined {
						display: block;
						width: 100%;
						vertical-align: top;
					}
					.tt{
						width: auto;
						padding: 7px;
					}
				}
			</style>
		';

    $output .= "
    <form method='post' action='' style='padding-top: 40px; text-align: center;'>
			<input type='hidden' name='lgsl_management' value='{$_POST['lgsl_management']}' />
			<input type='submit' name='lgsl_return' value='RETURN TO ADMIN' />
    </form>";

    return;
  }
	
//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_map_image_paths']))
  {
    $server_list = lgsl_query_cached_all("s");
		
		$output .= "
		<div style='padding: 5px;'>
			Haven't got images? <a href='https://github.com/tltneon/lgsl/wiki#how-can-i-add-map-images' target='_blank'>How to: add map icons</a>
		</div>
		";

    foreach ($server_list as $server)
    {
      if (!$server['b']['status']) { continue; }

      $image_map = lgsl_image_map($server['b']['status'], $server['b']['type'], $server['s']['game'], $server['s']['map'], FALSE);

      $output .= "
      <div style='padding-bottom: 5px;'>
				<div style='display: inline-block;'>	
					<img src='{$image_map}' width='32' height='32' />
				</div>	
				<div style='display: inline-block;vertical-align: super;'>	
					<div>Map Name: {$server['s']['map']}</div>
					<div>Link: <a href='{$image_map}' target='_blank'>{$image_map}</a></div>
				</div>
      </div>";
    }

    $output .= "
    <form method='post' action='' style='padding: 15px;'>
			<input type='hidden' name='lgsl_management' value='{$_POST['lgsl_management']}' />
			<input type='submit' name='lgsl_return' value='RETURN TO ADMIN' />
    </form>";

    return;
  }

//------------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_backup']))
	{
		$mysqli_result = mysqli_query($lgsl_database, "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ORDER BY `id` ASC");
		$content = "";
		while($mysqli_row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC))
		{
			$content .= $mysqli_row['ip'] . ':' . $mysqli_row['c_port'] . "\r\n";
		}
		$fp = fopen("lgslBackup.txt", "wb");
		fwrite($fp,$content);
		fclose($fp);
	}	
	
//------------------------------------------------------------------------------------------------------------+

  if ((!empty($_POST['lgsl_management']) && empty($_POST['lgsl_switch'])) || (empty($_POST['lgsl_management']) && !empty($_POST['lgsl_switch'])) || (!isset($_POST['lgsl_management']) && $lgsl_config['management']))
  {
    $output .= "
    <form method='post' action=''>
      <div style='text-align:center'>
        <b>TYPE : IP : C PORT : Q PORT : S PORT : ZONES : DISABLED : COMMENT</b>
        <br />
        <br />
      </div>
      <div style='text-align:center'>
        <textarea name='form_list' cols='90' rows='30' wrap='off' spellcheck='false' style='width:95%; height:500px; font-size:1.2em; font-family:courier new, monospace'>\r\n";

//---------------------------------------------------------+
        $mysqli_result = mysqli_query($lgsl_database, "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ORDER BY `id` ASC");

        while($mysqli_row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC))
        {
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
      <div style='text-align:center'>
        <input type='hidden' name='lgsl_management' value='1' />
        <table cellspacing='20' cellpadding='0' style='text-align:center;margin:auto'>
          <tr>
            <td><input type='submit' name='lgsl_save_1'          value='".$lgsl_config['text']['skc']."' />	</td>
            <td><input type='submit' name='lgsl_save_2'          value='".$lgsl_config['text']['srh']."' />	</td>
            <td><input type='submit' name='lgsl_map_image_paths' value='".$lgsl_config['text']['mip']."' />	</td>
            <td><input type='submit' name='lgsl_switch'          value='".$lgsl_config['text']['nrm']."' />	</td>
            <td><input type='submit' name='lgsl_backup'          value='Backup' />	</td>
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
    <div style='text-align:center; overflow:auto'>
      <table cellspacing='5' cellpadding='0' style='margin:auto'>
        <tr>
          <td style='text-align:center; white-space:nowrap'>[ ID ]             </td>
          <td style='text-align:center; white-space:nowrap'>[ Game Type | Query Protocol ]      </td>
          <td style='text-align:center; white-space:nowrap'>[ IP ]             </td>
          <td style='text-align:center; white-space:nowrap'>[ {$lgsl_config['text']['cpt']} ]</td>
          <td style='text-align:center; white-space:nowrap'>[ {$lgsl_config['text']['qpt']} ]     </td>
          <td style='text-align:center; white-space:nowrap'>[ Software Port ]  </td>
          <td style='text-align:center; white-space:nowrap'>[ Zones ]          </td>
          <td style='text-align:center; white-space:nowrap'>[ {$lgsl_config['text']['dsb']} ]       </td>
          <td style='text-align:center; white-space:nowrap'>[ Comment ]        </td>
        </tr>";

//---------------------------------------------------------+

      $mysqli_result = mysqli_query($lgsl_database, "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ORDER BY `id` ASC");

      while($mysqli_row = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC))
      {
        $id = $mysqli_row['id']; // ID USED AS [] ONLY RETURNS TICKED CHECKBOXES

        $output .= "
        <tr>
          <td>
            <a href='".lgsl_link($id)."' style='text-decoration:none' target='_blank'>{$id}</a>
          </td>
          <td>
            <select name='form_type[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_type_list as $type => $description)
            {
              $output .= "
              <option ".($type == $mysqli_row['type'] ? "selected='selected'" : "")." value='{$type}'>{$description}</option>";
            }

            if (!isset($lgsl_type_list[$mysqli_row['type']]))
            {
              $output .= "
              <option selected='selected' value='".lgsl_string_html($mysqli_row['type'])."'>".lgsl_string_html($mysqli_row['type'])."</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td style='text-align:center'><input type='text' name='form_ip[{$id}]'     value='".lgsl_string_html($mysqli_row['ip'])."'     size='15' maxlength='255' /></td>
          <td style='text-align:center'><input type='number' name='form_c_port[{$id}]' value='".lgsl_string_html($mysqli_row['c_port'])."' min='0' max='65536'   /></td>
          <td style='text-align:center'><input type='number' name='form_q_port[{$id}]' value='".lgsl_string_html($mysqli_row['q_port'])."' min='0' max='65536'   /></td>
          <td style='text-align:center'><input type='number' name='form_s_port[{$id}]' value='".lgsl_string_html($mysqli_row['s_port'])."' min='0' max='65536'   /></td>
          <td>
            <select name='form_zone[$id]'>";
//---------------------------------------------------------+
            foreach ($zone_list as $zone)
            {
              $output .= "
              <option ".($zone == $mysqli_row['zone'] ? "selected='selected'" : "")." value='{$zone}'>{$zone}</option>";
            }

            if (!isset($zone_list[$mysqli_row['zone']]))
            {
              $output .= "
              <option selected='selected' value='".lgsl_string_html($mysqli_row['zone'])."'>".lgsl_string_html($mysqli_row['zone'])."</option>";
            }
//---------------------------------------------------------+
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td style='text-align:center'><input type='checkbox' name='form_disabled[{$id}]' value='1' ".(empty($mysqli_row['disabled']) ? "" : "checked='checked'")." /></td>
          <td style='text-align:center'><input type='text'     name='form_comment[{$id}]'  value='{$mysqli_row['comment']}' size='20' maxlength='255' /></td>
        </tr>";

        $last_type = $mysqli_row['type']; // SET LAST TYPE ( $mysqli_row EXISTS ONLY WITHIN THE LOOP )
      }
//---------------------------------------------------------+
        $id ++; // NEW SERVER ID CONTINUES ON FROM LAST

        $output .= "
        <tr>
          <td>NEW<a href='https://github.com/tltneon/lgsl/wiki/Supported-Games' target='_blank' style='position: absolute;background: #fff;border-radius: 10px;width: 14px;height: 14px;border: 2px solid;margin-top: 7px;' title='How to choose query protocol?'>?</a></td>
          <td>
            <select name='form_type[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_type_list as $type => $description)
            {
              $output .= "
              <option ".($type == $last_type ? "selected='selected'" : "")." value='{$type}'>{$description}</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td style='text-align:center'><input type='text' name='form_ip[{$id}]'     value=''  size='15' maxlength='255' /></td>
          <td style='text-align:center'><input type='number' name='form_c_port[{$id}]' value=''  min='0' max='65536'   /></td>
          <td style='text-align:center'><input type='number' name='form_q_port[{$id}]' value=''  min='0' max='65536'   /></td>
          <td style='text-align:center'><input type='number' name='form_s_port[{$id}]' value='0' min='0' max='65536'   /></td>
          <td>
            <select name='form_zone[{$id}]'>";
//---------------------------------------------------------+
            foreach ($zone_list as $zone)
            {
              $output .= "
              <option value='{$zone}'>{$zone}</option>";
            }
//---------------------------------------------------------+
            $output .= "
            </select>
          </td>
          <td style='text-align:center'><input type='checkbox' name='form_disabled[{$id}]' value='' /></td>
          <td style='text-align:center'><input type='text'     name='form_comment[{$id}]'  value='' size='20' maxlength='255' /></td>
        </tr>
      </table>

      <input type='hidden' name='lgsl_management' value='0' />
      <table cellspacing='20' cellpadding='0' style='text-align:center;margin:auto'>
        <tr>
          <td><input type='submit' name='lgsl_save_1'          value='".$lgsl_config['text']['skc']."' />  </td>
          <td><input type='submit' name='lgsl_save_2'          value='".$lgsl_config['text']['srh']."' /> </td>
          <td><input type='submit' name='lgsl_map_image_paths' value='".$lgsl_config['text']['mip']."' />    </td>
          <td><input type='submit' name='lgsl_switch'          value='".$lgsl_config['text']['avm']."' /></td>
          <td><input type='submit' name='lgsl_check_updates'          value='Updates' /></td>
        </tr>
      </table>
    </div>
  </form>";

  $output .= lgsl_help_info();

//------------------------------------------------------------------------------------------------------------+

  function lgsl_help_info()
  {
		global $lgsl_config;
    return "
    <div style='text-align:center; line-height:1em; font-size:1em;'>
      <br /><br />
      <a href='https://github.com/tltneon/lgsl/wiki'>[ LGSL ONLINE WIKI ]</a> <a href='https://github.com/tltneon/lgsl'>[ LGSL GITHUB ]</a>  <br /><br />
      - To remove a server, delete the IP, then click Save.                           <br /><br />
      - Leave the query port blank to have LGSL try to fill it in for you.            <br /><br />
      - Software port is only needed for a few games so it being set 0 is normal.     <br /><br />
      - Edit the lgsl_config.php to set the style and other options.      						<br /><br />
      <table cellspacing='10' cellpadding='0' style='border:1px solid; margin:auto; text-align:left'>
        <tr>
          <td> <a href='http://php.net/fsockopen'>FSOCKOPEN</a>           </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("fsockopen") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( Required for direct querying of servers )                </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/curl'>CURL</a>                                                                                         </td>
          <td> {$lgsl_config['text']['enb']}: ".((function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec")) ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( Used for the feed when fsockopen is disabled )                                                                               </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/mbstring'>MBSTRING</a>                       </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("mb_convert_encoding") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( Used to show UTF-8 server and player names correctly )             </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/bzip2'>BZIP2</a>                      </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("bzdecompress") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( Used to show Source server settings over a certain size )   </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/gd2'>GD2</a>                        </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("gd2") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( Required for Image Mod )                             </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/zlib'>ZLIB</a>                        </td>
          <td> {$lgsl_config['text']['enb']}: ".(function_exists("gzuncompress") ? $lgsl_config['text']['yes'] : $lgsl_config['text']['nno'])." </td>
          <td> ( Required for America's Army 3 )                             </td>
        </tr>
      </table>
      <br /><br />
      <br /><br />
    </div>";
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_stripslashes_deep($value)
  {
    $value = is_array($value) ? array_map('lgsl_stripslashes_deep', $value) : stripslashes($value);
    return $value;
  }

//------------------------------------------------------------------------------------------------------------+

  function lgsl_htmlspecialchars($string)
  {
    // PHP4 COMPATIBLE WAY OF CONVERTING SPECIAL CHARACTERS WITHOUT DOUBLE ENCODING EXISTING ENTITIES
    $string = str_replace("\x05\x06", "", $string);
    $string = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x05\x06$1", $string);
    $string = htmlspecialchars($string, ENT_QUOTES);
    $string = str_replace("\x05\x06", "&", $string);

    return $string;
  }

//------------------------------------------------------------------------------------------------------------+
