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
	if(count($server_list) == 0)
	{
		$output .= "<div id='back_to_servers_list'><a href='./admin.php'>TO ADMIN PANEL</a></div>";
	}
	
  $output .= "
	<table id='server_list_table'>
		<tr id='server_list_table_top'>
			<th class='status_cell'>{$lgsl_config['text']['sts']}:</th>
			<th class='connectlink_cell'>{$lgsl_config['text']['adr']}:</th>
			<th class='servername_cell'>{$lgsl_config['text']['tns']}:</th>
			<th class='map_cell'>{$lgsl_config['text']['map']}:</th>
			<th class='players_cell'>{$lgsl_config['text']['plr']}:</th>
			<th class='details_cell'>{$lgsl_config['text']['dtl']}:</th>
		</tr>";

	foreach ($server_list as $server)
	{
		$misc   = lgsl_server_misc($server);
		$server = lgsl_server_html($server);

		$output .= "
		<tr class='server_{$misc['text_status']}'>

			<td class='status_cell'>
				<span title='{$lgsl_config['text'][$misc['text_status']]}' class='status_icon_{$misc['text_status']}'></span>
				<img alt='{$misc['name_filtered']}' src='{$misc['icon_game']}' title='{$misc['text_type_game']}' class='game_icon' />
			</td>

			<td title='{$lgsl_config['text']['slk']}' class='connectlink_cell'>
				<a href='{$misc['software_link']}'>
					{$server['b']['ip']}:{$server['b']['c_port']}
				</a>
			</td>

			<td title='{$server['s']['name']}' class='servername_cell'>
				<div class='servername_nolink'>
					{$misc['name_filtered']}
				</div>
				<div class='servername_link'>
					<a href='".lgsl_link($server['o']['id'])."'>
						{$misc['name_filtered']}
					</a>
				</div>
			</td>

			<td class='map_cell'>
				{$server['s']['map']}
			</td>

			<td class='players_cell'>
				{$server['s']['players']} / <span class='maxplayers'>{$server['s']['playersmax']}</span>
			</td>

			<td class='details_cell'>";

			if ($lgsl_config['locations'])
			{
				$output .= "
				<a href='".lgsl_location_link($server['o']['location'])."'>
					<img alt='' src='{$misc['icon_location']}' title='{$misc['text_location']}' class='contry_icon' />
				</a>";
			}

			$output .= "
				<a href='".lgsl_link($server['o']['id'])."' class='details_icon' title='{$lgsl_config['text']['vsd']}'></a>
			</td>

		</tr>";
	}

	$output .= "
	</table>";

//------------------------------------------------------------------------------------------------------------+

  if ($lgsl_config['list']['totals'])
  {
    $total = lgsl_group_totals($server_list);

    $output .= "
    <div id='totals'>
		<div> {$lgsl_config['text']['tns']}: {$total['servers']}    </div>
		<div> {$lgsl_config['text']['tnp']}: {$total['players']}    </div>
		<div> {$lgsl_config['text']['tmp']}: {$total['playersmax']} </div>
    </div>";
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------ PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ----------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px; padding: 33px 0px 11px 0px;'><a href='http://www.greycube.com' style='text-decoration:none'>".lgsl_version()."</a></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
