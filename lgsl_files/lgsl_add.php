<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+

  require "lgsl_class.php";

//-----------------------------------------------------------------------------------------------------------+

  if (!$lgsl_config['public_add'])
  {
    $output .= "
    <div id='annotation'> {$lgsl_config['text']['asd']} </div>";

    return;
  }

//-----------------------------------------------------------------------------------------------------------+

  $lgsl_type_list = lgsl_type_list();
  unset($lgsl_type_list['test']);
  asort($lgsl_type_list);

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

  list($c_port, $q_port, $s_port) = lgsl_port_conversion($type, $c_port, $q_port, $s_port);

//-----------------------------------------------------------------------------------------------------------+

  $output .= "
  <form method='post' action=''>
    <div>
      <table class='addserver_table'>

        <tr>
          <td colspan='2' style='text-align:center'>
            <br />
            {$lgsl_config['text']['awm']}
            <br />
            <br />
          </td>
        </tr>

        <tr>
          <td> {$lgsl_config['text']['typ']}: </td>
          <td>
            <select name='form_type'>";
  //---------------------------------------------------------+
            foreach ($lgsl_type_list as $key => $value)
            {
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
          <td> <input type='text' name='form_ip' value='".lgsl_string_html($ip)."' size='15' maxlength='128' /> </td>
        </tr>

        <tr>
          <td> {$lgsl_config['text']['cpt']} </td>
          <td> <input type='number' name='form_c_port' value='".lgsl_string_html($c_port)."' min='1' max='65536' /> </td>
        </tr>

        <tr>
          <td> {$lgsl_config['text']['qpt']} </td>
          <td> <input type='number' name='form_q_port' value='".lgsl_string_html($q_port)."' min='1' max='65536' /> </td>
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

  if (empty($_POST['lgsl_submit_test']) && empty($_POST['lgsl_submit_add'])) { return; }
  if (!isset($lgsl_type_list[$type]) || !$ip || !$c_port || !$q_port)        { return; }

//-----------------------------------------------------------------------------------------------------------+

	global $lgsl_database;
  lgsl_database();

  $ip     = mysqli_real_escape_string($lgsl_database, $ip);
  $q_port = mysqli_real_escape_string($lgsl_database, $q_port);
  $c_port = mysqli_real_escape_string($lgsl_database, $c_port);
  $s_port = mysqli_real_escape_string($lgsl_database, $s_port);
  $type   = mysqli_real_escape_string($lgsl_database, $type);

//-----------------------------------------------------------------------------------------------------------+

  $ip_check     = gethostbyname($ip);
  $mysql_result = mysqli_query($lgsl_database, "SELECT `ip`,`disabled` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `type`='{$type}' AND `q_port`='{$q_port}'");

  while ($mysql_row = mysqli_fetch_array($mysql_result, MYSQLI_ASSOC))
  {
    if ($ip_check == gethostbyname($mysql_row['ip']))
    {
      $output .= "
      <div class='annotation'>";

        if ($mysql_row['disabled'])
        {
          $output .= $lgsl_config['text']['aaa'];
        }
        else
        {
          $output .= $lgsl_config['text']['aan'];
        }

        $output .="
      </div>

      <div>
      <br />
      </div>";

      return;
    }
  }

//-----------------------------------------------------------------------------------------------------------+

  $server = lgsl_query_live($type, $ip, $c_port, $q_port, $s_port, "s");
  $server = lgsl_server_html($server);

  if (!$server['b']['status'])
  {
    $output .= "
    <div class='annotation'> {$lgsl_config['text']['anr']} </div>

    <div>
    <br />
    </div>";

    return;
  }

//-----------------------------------------------------------------------------------------------------------+

  if (!empty($_POST['lgsl_submit_add']))
  {
    $disabled = ($lgsl_config['public_add'] == "2") ? "0" : "1";

    $mysql_query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`disabled`,`cache`,`cache_time`) VALUES ('{$type}','{$ip}','{$c_port}','{$q_port}','{$s_port}','{$disabled}','','')";
    $mysql_result = mysqli_query($lgsl_database, $mysql_query) or die(mysqli_error($lgsl_database));

    $output .= "
    <div class='annotation'>";

      if ($disabled)
      {
        $output .= $lgsl_config['text']['ada'];
      }
      else
      {
        $output .= $lgsl_config['text']['adn'];
      }

      $output .="
    </div>

    <div>
    <br />
    </div>";

    return;
  }

//-----------------------------------------------------------------------------------------------------------+

	$output .= "
  <form method='post' action=''>
    <div class='annotation'> {$lgsl_config['text']['asc']} </div>

    <div>
    <br />
    </div>

    <table class='details_table'>
      <tr> <td> <b> Name:                         </b> </td> <td style='white-space:nowrap'> {$server['s']['name']}                                   </td> </tr>
      <tr> <td> <b> {$lgsl_config['text']['gme']} </b> </td> <td style='white-space:nowrap'> {$server['s']['game']}                                   </td> </tr>
      <tr> <td> <b> {$lgsl_config['text']['map']} </b> </td> <td style='white-space:nowrap'> {$server['s']['map']}                                    </td> </tr>
      <tr> <td> <b> {$lgsl_config['text']['plr']} </b> </td> <td style='white-space:nowrap'> {$server['s']['players']} / {$server['s']['playersmax']} </td> </tr>
    </table>

    <div>
    <br />
    </div>

    <div class='annotation'>
      <input type='hidden' name='form_type'       value='".lgsl_string_html($type)."'   />
      <input type='hidden' name='form_ip'         value='".lgsl_string_html($ip)."'     />
      <input type='hidden' name='form_c_port'     value='".lgsl_string_html($c_port)."' />
      <input type='hidden' name='form_q_port'     value='".lgsl_string_html($q_port)."' />
      <input type='submit' name='lgsl_submit_add' value='{$lgsl_config['text']['aas']}' />
    </div>

    <div>
    <br />
    </div>

  </form>";

//------------------------------------------------------------------------------------------------------------+
