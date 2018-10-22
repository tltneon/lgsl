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

  $server_list = lgsl_query_group();
  $server_list = lgsl_sort_servers($server_list);

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='text-align:center'>
    <table style='margin:auto' cellpadding='4' cellspacing='2'>";

    foreach ($server_list as $server)
    {
      $misc   = lgsl_server_misc($server);
      $server = lgsl_server_html($server);

      $output .= "
      <tr style='".lgsl_bg()."; table-layout:fixed'>

        <td style='white-space:nowrap; text-align:center'>
          <img alt='' src='{$misc['icon_status']}' title='{$misc['text_status']}'    style='vertical-align:middle' />
          <img alt='' src='{$misc['icon_game']}'   title='{$misc['text_type_game']}' style='vertical-align:middle' />
        </td>

        <td title='{$lgsl_config['text']['slk']}' style='text-align:right'>
          <a href='{$misc['software_link']}' style='text-decoration:none'>
            {$server['b']['ip']}:{$server['b']['c_port']}
          </a>
        </td>

        <td title='{$server['s']['name']}' style='text-align:left'>
          <div style='width:100%; overflow:hidden; height:1.3em; line-height:1.3em'>
            {$misc['name_filtered']}
          </div>
        </td>

        <td style='white-space:nowrap; text-align:left'>
          {$server['s']['map']}
        </td>

        <td style='white-space:nowrap; text-align:right'>
          {$server['s']['players']} / {$server['s']['playersmax']}
        </td>

        <td style='white-space:nowrap; text-align:center'>";

        if ($lgsl_config['locations'])
        {
          $output .= "
          <a href='".lgsl_location_link($server['o']['location'])."' style='text-decoration:none'>
            <img alt='' src='{$misc['icon_location']}' title='{$misc['text_location']}' style='vertical-align:middle; border:none' />
          </a>";
        }

        $output .= "
          <a href='".lgsl_link($server['o']['id'])."' style='text-decoration:none'>
            <img alt='' src='{$misc['icon_details']}' title='{$lgsl_config['text']['vsd']}' style='vertical-align:middle; border:none' />
          </a>
        </td>

      </tr>";
    }

    $output .= "
    </table>
  </div>";

//------------------------------------------------------------------------------------------------------------+

  if ($lgsl_config['list']['totals'])
  {
    $total = lgsl_group_totals($server_list);

    $output .= "
    <div>
      <br />
    </div>
    <div style='text-align:center'>
      <table style='margin:auto' cellpadding='4' cellspacing='2'>
        <tr style='".lgsl_bg()."'>
          <td> {$lgsl_config['text']['tns']} {$total['servers']}    </td>
          <td> {$lgsl_config['text']['tnp']} {$total['players']}    </td>
          <td> {$lgsl_config['text']['tmp']} {$total['playersmax']} </td>
        </tr>
      </table>
    </div>";
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px'><br /><br /><br /><a href='http://www.greycube.com' style='text-decoration:none'>".lgsl_version()."</a><br /></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
