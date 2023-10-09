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

  require "lgsl_class.php";
  global $output;

//-----------------------------------------------------------------------------------------------------------+

  if ($lgsl_config['public_add']) {

  //-----------------------------------------------------------------------------------------------------------+

    $lgsl_type_list = Protocol::lgsl_type_list();
    unset($lgsl_type_list['test']);

    $url    = $lgsl_config['preloader'] ? '?s=add' : '';
    $type   = empty($_POST['form_type'])   ? "source" :        trim($_POST['form_type']);
    $ip     = empty($_POST['form_ip'])     ? ""       :        trim($_POST['form_ip']);
    $c_port = empty($_POST['form_c_port']) ? 0        : intval(trim($_POST['form_c_port']));
    $q_port = empty($_POST['form_q_port']) ? 0        : intval(trim($_POST['form_q_port']));
    $s_port = 0;

    if     (preg_match("/(\[[0-9a-z\:]+\])/iU", $ip, $match)) { $ip = $match[1]; }
    elseif (preg_match("/([0-9a-z\.\-]+)/i", $ip, $match))    { $ip = $match[1]; }
    else                                                      { $ip = ""; }

    if ($c_port > 65535 || $c_port < 1024) { $c_port = 0; }
    if ($q_port > 65535 || $q_port < 1024) { $q_port = 0; }

    list($c_port, $q_port, $s_port) = Protocol::lgsl_port_conversion($type, $c_port, $q_port, $s_port);

  //-----------------------------------------------------------------------------------------------------------+

    $output .= "
    <form method='post' action='{$url}'>
      <div>
        <table class='addserver_table'>

          <tr>
            <td colspan='2' class='center'>
              <br />
              {$lgsl_config['text']['awm']}
              <br />
              <br />
            </td>
          </tr>

          <tr>
            <td> {$lgsl_config['text']['typ']} </td>
            <td>
              <select name='form_type'>";
    //---------------------------------------------------------+
              foreach ($lgsl_type_list as $key => $value) {
                $output .= "
                <option ".($key == $type ? "selected='selected'" : "")." value='{$key}'> {$value} </option>";
              }
    //---------------------------------------------------------+
              $output .= "
              </select>
            </td>
          </tr>

          <tr>
            <td> {$lgsl_config['text']['adr']} </td>
            <td> <input type='text' name='form_ip' value='$ip' onpaste='javascript:setTimeout(function(){const v=event.srcElement.value.split(\":\")[1];document.querySelector(\"input[name=form_ip]\").value=event.srcElement.value.trim();document.querySelector(\"input[name=form_c_port]\").value=v;document.querySelector(\"input[name=form_q_port]\").value=v;});' size='15' maxlength='128' /> </td>
          </tr>

          <tr>
            <td> {$lgsl_config['text']['cpt']} </td>
            <td> <input type='number' name='form_c_port' value='$c_port' min='1024' max='65535' /> </td>
          </tr>

          <tr>
            <td> {$lgsl_config['text']['qpt']}
              <a href='https://github.com/tltneon/lgsl/wiki/Supported-Games,-Query-protocols,-Default-ports' target='_blank' id='new_q' style='position: absolute;background: #fff;  text-align: center;border-radius: 10px;width: 14px;height: 14px;border: 2px solid;margin-top: 7px;' title='How to choose protocol or query port?'>?</a>
            </td>
            <td> <input type='number' name='form_q_port' value='$q_port' min='1024' max='65535' /> </td>
          </tr>

          <tr>
            <td colspan='2' class='annotation'>
              <input type='submit' name='lgsl_submit_test' value='{$lgsl_config['text']['ats']}' />
            </td>
          </tr>

        </table>

        <br />
        <br />

      </div>
    </form>";

  //-----------------------------------------------------------------------------------------------------------+

    if (isset($_POST['lgsl_submit_test']) || isset($_POST['lgsl_submit_add'])) {
      if (isset($lgsl_type_list[$type]) && $ip && $c_port && $q_port) {
        if ($type === "discord") {$c_port = 1; $q_port = 1;}

      //-----------------------------------------------------------------------------------------------------------+

        $db = LGSL::db();

        $ip     = $db->escape_string($ip);
        $q_port = $db->escape_string($q_port);
        $c_port = $db->escape_string($c_port);
        $s_port = $db->escape_string($s_port);
        $type   = $db->escape_string($type);

      //-----------------------------------------------------------------------------------------------------------+

        $ip_check = gethostbyname($ip);
        $mysql_query = $db->query("SELECT `ip`,`disabled` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE (`ip`='{$ip}' OR `ip`='$ip_check') AND `q_port`='{$q_port}'", true);
        if ($mysql_query) {
          $output .= "
            <div class='annotation'>";

              if ($mysql_query['disabled']) {
                $output .= $lgsl_config['text']['aaa'];
              } else {
                $output .= $lgsl_config['text']['aan'];
              }

              $output .="
            </div>";
        } else {

        //-----------------------------------------------------------------------------------------------------------+

          $server = new Server(["type" => $type, "ip" => $ip, "c_port" => $c_port, "q_port" => $q_port, "s_port" => $s_port]);
					$server->lgsl_live_query("s");

          if ($server->get_status() != Server::OFFLINE) {
          //-----------------------------------------------------------------------------------------------------------+

            if (!empty($_POST['lgsl_submit_add'])) {
              $disabled = ($lgsl_config['public_add'] == "2") ? "0" : "1";

              $mysql_query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`disabled`,`cache`,`cache_time`) VALUES ('{$type}','{$ip}','{$c_port}','{$q_port}','{$s_port}','{$disabled}','','')";
              $mysql_result = $db->execute($mysql_query);

              $output .= "
              <div class='annotation'>";

                if ($disabled) {
                  $output .= $lgsl_config['text']['ada'];
                } else {
                  $output .= $lgsl_config['text']['adn'];
                }

                $output .="
              </div>

              <div>
              <br />
              </div>";
            } else {

            //-----------------------------------------------------------------------------------------------------------+

              $output .= "
              <form method='post' action=''>
                <div class='annotation'> {$lgsl_config['text']['asc']} </div>

                <div>
                <br />
                </div>

                <table class='details_table' style='text-align: center; margin: auto; max-width: 500px;'>
                  <tr> <td> <b> {$lgsl_config['text']['adr']} </b> </td> <td> {$server->get_ip()}:{$server->get_c_port()}                                          </td> </tr>
                  <tr> <td> <b> {$lgsl_config['text']['sts']} </b> </td> <td> {$lgsl_config['text'][$server->get_status()]}                                   </td> </tr>
                  <tr> <td> <b> {$lgsl_config['text']['nam']} </b> </td> <td> {$server->get_name()}                                   </td> </tr>
                  <tr> <td> <b> {$lgsl_config['text']['gme']} </b> </td> <td> {$server->get_game()}                                   </td> </tr>
                  <tr> <td> <b> {$lgsl_config['text']['map']} </b> </td> <td> {$server->get_map()}                                    </td> </tr>
                  <tr> <td> <b> {$lgsl_config['text']['plr']} </b> </td> <td> {$server->get_players_count('active')} / {$server->get_players_count('max')} </td> </tr>
                </table>

                <div>
                <br />
                </div>

                <div class='annotation'>
                  <input type='hidden' name='form_type'       value='$type'   />
                  <input type='hidden' name='form_ip'         value='$ip'     />
                  <input type='hidden' name='form_c_port'     value='$c_port' />
                  <input type='hidden' name='form_q_port'     value='$q_port' />
                  <input type='submit' name='lgsl_submit_add' value='{$lgsl_config['text']['aas']}' />
                </div>

                <div>
                <br />
                </div>

              </form>";
            }
          } else {
            $output .= "
            <div class='annotation'> {$lgsl_config['text']['anr']} </div>";
          }


        }
      } else {
        $output .= "<div id='annotation'> {$lgsl_config['text']['anr']} </div>";
      }
    }
  } else {
    $output .= "<div id='annotation'> {$lgsl_config['text']['asd']} </div>";
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
//------ WANNA BE HERE? https://github.com/tltneon/lgsl/wiki/Who-uses-LGSL -> LET CREDITS STAY :P --------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px; padding: 33px 0px 11px 0px;'><a href='https://github.com/tltneon/lgsl' style='text-decoration:none'>".lgsl_version()."</a></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

if ($lgsl_config['preloader'])
  echo $output;