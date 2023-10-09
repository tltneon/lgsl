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

  $db = LGSL::db();
//------------------------------------------------------------------------------------------------------------+

  $json        = empty($_GET['json'])        ? FALSE : TRUE;
  $xml         = empty($_GET['xml'])         ? FALSE : TRUE;
  $online      = empty($_GET['online'])      ? FALSE : TRUE;
  $nodisabled  = empty($_GET['nodisabled'])  ? FALSE : TRUE;
  $download    = empty($_GET['download'])    ? FALSE : TRUE;
  $sort        = empty($_GET['sort'])        ? FALSE : $_GET['sort'];
  $randomzones = empty($_GET['randomzones']) ? FALSE : intval($_GET['randomzones']);

//------------------------------------------------------------------------------------------------------------+

  $output    = "";
  $db_filter = "";
  $db_where  = [];

  if ($json)        { $jsarray = []; }
  if ($nodisabled)  { $db_where[] = "`disabled`=0"; } // ONLY LIST ENABLED
  if ($online)      { $db_where[] = "`status`=1"; }   // ONLY LIST ONLINE
  if ($db_where) { $db_filter  = "WHERE ".implode(" AND ", $db_where); }

  if     ($sort === "ip")   { $db_filter .= " ORDER BY CONCAT(`ip`, `c_port`) ASC"; }
  elseif ($sort === "type") { $db_filter .= " ORDER BY `type` ASC"; }
  else                      { $db_filter .= " ORDER BY `id` ASC"; }

//------------------------------------------------------------------------------------------------------------+

  $db_result = $db->query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` {$db_filter}");

  foreach ($db_result as $db_row) {
    $db_row['zone'] = (int) $db_row['zone'];
    if ($randomzones) { $db_row['zone'] = rand(1, $randomzones); } // FILL ZONES WITH RANDOM NUMBERS ( 1 TO $randomzones )

    if ($xml) {
      $output .= "
      <server>
        <type>{$db_row['type']}</type>
        <ip>{$db_row['ip']}</ip>
        <c_port>{$db_row['c_port']}</c_port>
        <q_port>{$db_row['q_port']}</q_port>
        <s_port>{$db_row['s_port']}</s_port>
        <zone>{$db_row['zone']}</zone>
        <disabled>{$db_row['disabled']}</disabled>
      </server>";
    } elseif ($json) {
      array_push($jsarray, [
          'type'     => $db_row['type'],
          'ip'       => $db_row['ip'],
          'c_port'   => $db_row['c_port'],
          'q_port'   => $db_row['q_port'],
          's_port'   => $db_row['s_port'],
          'zone'     => $db_row['zone'],
          'disabled' => $db_row['disabled']
      ]);
    } else {
      $output .= "{$db_row['type']} : {$db_row['ip']} : {$db_row['c_port']} : {$db_row['q_port']} : {$db_row['s_port']} : {$db_row['zone']} : {$db_row['disabled']} \r\n";
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if ($json) {
    $output = json_encode($jsarray);
  }
  
  if ($download) {
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"servers.txt\"");
    echo $output;
    exit;
  }

  if ($xml) {
    header("content-type: text/xml");
    echo "<?xml version='1.0' encoding='UTF-8' ?>
    <servers>{$output}</servers>";
    exit;
  }

//------------------------------------------------------------------------------------------------------------+
?>
<!DOCTYPE html>

<html>
  <head>
    <title>Live Game Server List: Export Page</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  </head>

  <body>
    <pre><?php echo $output; ?></pre>
  </body>
</html>
