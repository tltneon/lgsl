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
// CRON SETTINGS:

  @set_time_limit(3600);           // MAXIMUM TIME THE CRON IS ALLOWED TO TAKE
  $lgsl_config['cache_time'] = 60; // HOW OLD CACHE MUST BE BEFORE IT NEEDS REFRESHING
  $request = "seph";                // WHAT TO PRE-CACHE: [s] = BASIC INFO [e] = SETTINGS [p] = PLAYERS [h] = HISTORY

//------------------------------------------------------------------------------------------------------------+

  echo "<pre>STARTING [ TIME LIMIT: ".ini_get("max_execution_time")." ] [ CACHE TIME: {$lgsl_config['cache_time']} ]\r\n\r\n";

//------------------------------------------------------------------------------------------------------------+

  $db_query  = "SELECT `type`,`ip`,`c_port`,`q_port`,`s_port` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `disabled`= 0 ORDER BY `cache_time` ASC;";
  $db_result = $db->query($db_query);

  foreach ($db_result as $db_row) {
    echo str_pad(LGSL::timer("taken"),  8,  " ").":".
         str_pad($db_row['type'],   15, " ").":".
         str_pad($db_row['ip'],     30, " ").":".
         str_pad($db_row['c_port'], 6,  " ").":".
         str_pad($db_row['q_port'], 6,  " ").":".
         str_pad($db_row['s_port'], 12, " ")."\r\n";

    $server = new Server(["type" => $db_row['type'], "ip" => $db_row['ip'], "c_port" => $db_row['c_port'], "q_port" => $db_row['q_port']]);
    $server->lgsl_cached_query($request);

    flush();
    ob_flush();
  }

//------------------------------------------------------------------------------------------------------------+

  echo "\r\nFINISHED</pre>";

//------------------------------------------------------------------------------------------------------------+
