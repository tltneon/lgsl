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
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_version')) { // START OF DOUBLE LOAD PROTECTION

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
  class Protocol {
    // Transport protocols
		public const UDP = "udp";
		public const TCP = "tcp";
		public const HTTP = "http";
		// Query protocols
    public const AARMY = "aarmy";
    public const AARMY3 = "aarmy3";
    public const ARCASIMRACING = "arcasimracing";
    public const ARMA = "arma";
    public const ARMA2 = "arma2";
    public const ARMA3 = "arma3";
    public const AVP2 = "avp2";
    public const BEAMMP = "beammp";
    public const BFBC2 = "bfbc2";
    public const BFVIETNAM = "bfvietnam";
    public const BF1942 = "bf1942";
    public const BF2 = "bf2";
    public const BF3 = "bf3";
    public const BF4 = "bf4";
    public const BF2142 = "bf2142";
    public const CALLOFDUTY = "callofduty";
    public const CALLOFDUTYBO3 = "callofdutybo3";
    public const CALLOFDUTYIW = "callofdutyiw";
    public const CALLOFDUTYUO = "callofdutyuo";
    public const CALLOFDUTYWAW = "callofdutywaw";
    public const CALLOFDUTY2 = "callofduty2";
    public const CALLOFDUTY4 = "callofduty4";
    public const CNCRENEGADE = "cncrenegade";
    public const CONANEXILES = "conanexiles";
    public const CRYOFALL = "cryofall";
    public const CRYSIS = "crysis";
    public const CRYSISWARS = "crysiswars";
    public const CS2D = "cs2d";
    public const CUBE = "cube";
    public const DISCORD = "discord";
    public const DOOMSKULLTAG = "doomskulltag";
    public const DOOMZDAEMON = "doomzdaemon";
    public const DOOM3 = "doom3";
    public const DH2005 = "dh2005";
    public const ECO = "eco";
    public const FACTORIO = "factorio";
    public const HAD2 = "had2";
    public const HALFLIFE = "halflife";
    public const HALFLIFEWON = "halflifewon";
    public const HALO = "halo";
    public const IL2 = "il2";
    public const FARCRY = "farcry";
    public const FARMSIM = "farmsim";
    public const FEAR = "fear";
    public const FIVEM = "fivem";
    public const FLASHPOINT = "flashpoint";
    public const FREELANCER = "freelancer";
    public const FRONTLINES = "frontlines";
    public const F1C9902 = "f1c9902";
    public const GAMESPY1 = "gamespy1";
    public const GAMESPY2 = "gamespy2";
    public const GAMESPY3 = "gamespy3";
    public const GHOSTRECON = "ghostrecon";
    public const GRAW = "graw";
    public const GRAW2 = "graw2";
    public const GTAC = "gtac";
    public const GTR2 = "gtr2";
    public const JEDIKNIGHT2 = "jediknight2";
    public const JEDIKNIGHTJA = "jediknightja";
    public const JC2MP = "jc2mp";
    public const KILLINGFLOOR = "killingfloor";
    public const KINGPIN = "kingpin";
    public const M2MP = "m2mp";
    public const MAFIAC = "mafiac";
    public const MINECRAFT = "minecraft";
    public const MOHAA = "mohaa";
    public const MOHAAB = "mohaab";
    public const MOHAAS = "mohaas";
    public const MOHPA = "mohpa";
    public const MTA = "mta";
    public const MUMBLE = "mumble";
    public const NASCAR2004 = "nascar2004";
    public const NECESSE = "necesse";
    public const NEVERWINTER = "neverwinter";
    public const NEVERWINTER2 = "neverwinter2";
    public const NEXUIZ = "nexuiz";
    public const OPENTTD = "openttd";
    public const PAINKILLER = "painkiller";
    public const PLAINSIGHT = "plainsight";
    public const PREY = "prey";
    public const QUAKEWORLD = "quakeworld";
    public const QUAKEWARS = "quakewars";
    public const QUAKE2 = "quake2";
    public const QUAKE3 = "quake3";
    public const QUAKE4 = "quake4";
    public const RAGEMP = "ragemp";
    public const RAVENSHIELD = "ravenshield";
    public const REDORCHESTRA = "redorchestra";
    public const RFACTOR = "rfactor";
    public const SAMP = "samp";
    public const SAVAGE = "savage";
    public const SAVAGE2 = "savage2";
    public const SERIOUSSAM = "serioussam";
    public const SERIOUSSAM2 = "serioussam2";
    public const SCUM = "scum";
    public const SF = "sf";
    public const SHATTEREDH = "shatteredh";
    public const SOF2 = "sof2";
    public const SOLDAT = "soldat";
    public const SOURCE = "source";
    public const SRB2 = "srb2";
    public const STALKER = "stalker";
    public const STALKERCOP = "stalkercop";
    public const STALKERCS = "stalkercs";
    public const STARTREKEF = "startrekef";
    public const STARWARSBF = "starwarsbf";
    public const STARWARSBF2 = "starwarsbf2";
    public const STARWARSRC = "starwarsrc";
    public const SWAT4 = "swat4";
    public const TEEWORLDS = "teeworlds";
    public const TERRARIA = "terraria";
    public const TRIBES = "tribes";
    public const TRIBES2 = "tribes2";
    public const TRIBESV = "tribesv";
    public const TS = "ts";
    public const TS3 = "ts3";
    public const TEASPEAK = "teaspeak";
    public const WARSOW = "warsow";
    public const WARSOWOLD = "warsowold";
    public const URBANTERROR = "urbanterror";
    public const UT = "ut";
    public const UT2003 = "ut2003";
    public const UT2004 = "ut2004";
    public const UT3 = "ut3";
    public const VCMP = "vcmp";
    public const VIETCONG = "vietcong";
    public const VIETCONG2 = "vietcong2";
    public const WINDWARD = "windward";
    public const WOLFET = "wolfet";
    public const WOLFRTCW = "wolfrtcw";
    public const WOLF2009 = "wolf2009";
    public const WOW = "wow";
    public const TEST = "test";
    // Variables
    private $_server;
    private $_server_timestamp;
    private $_lgsl_need;
    private $_lgsl_fp;
    
    public function __construct(&$server, $need) {
      $this->_server = &$server;
      $this->_lgsl_need = ["a" => false, "c" => false, "s" => false, "e" => false, "p" => false];
      $lgsl_need = str_split($need);
      foreach ($lgsl_need as $value) {
        $this->_lgsl_need[$value] = true;
      }
    }
    static public function lgsl_connection_type($type) {
      $protocol = [
        self::BEAMMP        => self::HTTP,
        self::BFBC2         => self::TCP,
        self::BF3           => self::TCP,
        self::DISCORD       => self::HTTP,
        self::FARMSIM       => self::HTTP,
        self::ECO           => self::HTTP,
        self::FIVEM         => self::HTTP,
        self::RAGEMP        => self::HTTP,
        self::SCUM          => self::HTTP,
        self::TERRARIA      => self::HTTP,
        self::TS            => self::TCP,
        self::TS3           => self::TCP,
        self::TEASPEAK      => self::TCP,
        self::WINDWARD      => self::TCP,
        self::WOW           => self::TCP
      ];
      return $protocol[$type] ?? self::UDP;
    }
    static public function lgslList($type = null) {
      $list = [
        self::AARMY         => ["09", "Americas Army"],
        self::AARMY3        => ["26", "Americas Army 3"],
        self::ARCASIMRACING => ["16", "Arca Sim Racing"],
        self::ARMA          => ["09", "ArmA: Armed Assault"],
        self::ARMA2         => ["09", "ArmA 2"],
        self::ARMA3         => ["05", "ArmA 3 / DayZ"],
        self::AVP2          => ["03", "Aliens VS. Predator 2"],
        self::BEAMMP        => ["Query48", "BeamMP"],
        self::BFBC2         => ["30", "Battlefield Bad Company 2"],
        self::BFVIETNAM     => ["09", "Battlefield Vietnam"],
        self::BF1942        => ["03", "Battlefield 1942"],
        self::BF2           => ["06", "Battlefield 2"],
        self::BF3           => ["30", "Battlefield 3"],
        self::BF4           => ["06", "Battlefield 4"],
        self::BF2142        => ["06", "Battlefield 2142"],
        self::CALLOFDUTY    => ["02", "Call Of Duty"],
        self::CALLOFDUTYBO3 => ["05", "Call Of Duty: Black Ops 3"],
        self::CALLOFDUTYIW  => ["02", "Call Of Duty (IW5, IW6x)"],
        self::CALLOFDUTYUO  => ["02", "Call Of Duty: United Offensive"],
        self::CALLOFDUTYWAW => ["02", "Call Of Duty: World at War"],
        self::CALLOFDUTY2   => ["02", "Call Of Duty 2"],
        self::CALLOFDUTY4   => ["02", "Call Of Duty 4 / CoD4X"],
        self::CNCRENEGADE   => ["03", "Command and Conquer: Renegade"],
        self::CONANEXILES   => ["05", "Conan Exiles"],
        self::CRYOFALL      => ["Query44", "Cryofall"],
        self::CRYSIS        => ["06", "Crysis"],
        self::CRYSISWARS    => ["06", "Crysis Wars"],
        self::CS2D          => ["29", "Counter-Strike 2D"],
        self::CUBE          => ["24", "Cube Engine"],
        self::DISCORD       => ["Query36", "Discord"],
        self::DOOMSKULLTAG  => ["27", "Doom - Skulltag"],
        self::DOOMZDAEMON   => ["28", "Doom - ZDaemon"],
        self::DOOM3         => ["10", "Doom 3"],
        self::DH2005        => ["09", "Deer Hunter 2005"],
        self::ECO           => ["Query40", "ECO"],
        self::FACTORIO      => ["Query42", "Factorio"],
        self::HAD2          => ["03", "Hidden and Dangerous 2"],
        self::HALFLIFE      => ["05", "Half-Life Steam Protocol (CS 1.6, etc)"],
        self::HALFLIFEWON   => ["05", "Half-Life WON Protocol [OLD] (CS 1.5)"],
        self::HALO          => ["03", "Halo"],
        self::IL2           => ["03", "IL-2 Sturmovik"],
        self::FARCRY        => ["08", "Far Cry"],
        self::FARMSIM       => ["40", "Farming Simulator 2019"],
        self::FEAR          => ["09", "F.E.A.R."],
        self::FIVEM         => ["Query35", "FiveM / RedM"],
        self::FLASHPOINT    => ["03", "Operation Flashpoint"],
        self::FREELANCER    => ["14", "Freelancer"],
        self::FRONTLINES    => ["20", "Frontlines: Fuel Of War"],
        self::F1C9902       => ["03", "F1 Challenge 99-02"],
        self::GAMESPY1      => ["03", "Generic GameSpy 1"],
        self::GAMESPY2      => ["09", "Generic GameSpy 2"],
        self::GAMESPY3      => ["06", "Generic GameSpy 3"],
        self::GHOSTRECON    => ["19", "Ghost Recon"],
        self::GRAW          => ["06", "Ghost Recon: Advanced Warfighter"],
        self::GRAW2         => ["09", "Ghost Recon: Advanced Warfighter 2"],
        self::GTAC          => ["Query45", "GTA Connected"],
        self::GTR2          => ["15", "GTR 2"],
        self::JEDIKNIGHT2   => ["02", "JediKnight 2: Jedi Outcast"],
        self::JEDIKNIGHTJA  => ["02", "JediKnight: Jedi Academy"],
        self::JC2MP         => ["06", "Just Cause 2 Multiplayer"],
        self::KILLINGFLOOR  => ["13", "Killing Floor"],
        self::KINGPIN       => ["03", "Kingpin: Life of Crime"],
        self::M2MP          => ["Query39", "Mafia II Multiplayer"],
        self::MAFIAC        => ["Query45", "Mafia Connected"],
        self::MINECRAFT     => ["06", "Minecraft"],
        self::MOHAA         => ["03", "Medal of Honor: Allied Assault"],
        self::MOHAAB        => ["03", "Medal of Honor: Allied Assault Breakthrough"],
        self::MOHAAS        => ["03", "Medal of Honor: Allied Assault Spearhead"],
        self::MOHPA         => ["03", "Medal of Honor: Pacific Assault"],
        self::MTA           => ["08", "Multi Theft Auto"],
        self::MUMBLE        => ["Query43", "Mumble"],
        self::NASCAR2004    => ["09", "Nascar Thunder 2004"],
        self::NECESSE       => ["Query47", "Necesse"],
        self::NEVERWINTER   => ["09", "NeverWinter Nights"],
        self::NEVERWINTER2  => ["09", "NeverWinter Nights 2"],
        self::NEXUIZ        => ["02", "Nexuiz"],
        self::OPENTTD       => ["22", "Open Transport Tycoon Deluxe"],
        self::PAINKILLER    => ["08", "PainKiller"],
        self::PLAINSIGHT    => ["Query32", "Plain Sight"],
        self::PREY          => ["10", "Prey"],
        self::QUAKEWORLD    => ["07", "Quake World"],
        self::QUAKEWARS     => ["10", "Enemy Territory: Quake Wars"],
        self::QUAKE2        => ["02", "Quake 2"],
        self::QUAKE3        => ["02", "Quake 3"],
        self::QUAKE4        => ["10", "Quake 4"],
        self::RAGEMP        => ["Query34", "Rage:MP"],
        self::RAVENSHIELD   => ["04", "Raven Shield"],
        self::REDORCHESTRA  => ["13", "Red Orchestra"],
        self::RFACTOR       => ["16", "rFactor"],
        self::SAMP          => ["12", "San Andreas Multiplayer"],
        self::SAVAGE        => ["17", "Savage"],
        self::SAVAGE2       => ["18", "Savage 2"],
        self::SERIOUSSAM    => ["03", "Serious Sam"],
        self::SERIOUSSAM2   => ["09", "Serious Sam 2"],
        self::SCUM          => ["Query37", "SCUM"],
        self::SF            => ["Query41", "Satisfactory"],
        self::SHATTEREDH    => ["05", "Shattered Horizon"],
        self::SOF2          => ["02", "Soldier of Fortune 2"],
        self::SOLDAT        => ["08", "Soldat"],
        self::SOURCE        => ["05", "Source Protocol (Half-Life 2, etc.)"],
        self::SRB2          => ["Query46", "Sonic Robo Blast 2"],
        self::STALKER       => ["06", "S.T.A.L.K.E.R."],
        self::STALKERCOP    => ["09", "S.T.A.L.K.E.R. Call of Pripyat"],
        self::STALKERCS     => ["09", "S.T.A.L.K.E.R. Clear Sky"],
        self::STARTREKEF    => ["02", "StarTrek Elite-Force"],
        self::STARWARSBF    => ["09", "Star Wars: Battlefront"],
        self::STARWARSBF2   => ["09", "Star Wars: Battlefront 2"],
        self::STARWARSRC    => ["09", "Star Wars: Republic Commando"],
        self::SWAT4         => ["03", "SWAT 4"],
        self::TEEWORLDS     => ["21", "Teeworlds"],
        self::TERRARIA      => ["Query38", "Terraria"],
        self::TRIBES        => ["23", "Tribes (Starsiege)"],
        self::TRIBES2       => ["25", "Tribes 2"],
        self::TRIBESV       => ["09", "Tribes Vengeance"],
        self::TS            => ["Query33", "Teamspeak"],
        self::TS3           => ["Query33", "Teamspeak 3"],
        self::TEASPEAK      => ["Query33", "Teaspeak"],
        self::WARSOW        => ["02", "Warsow"],
        self::WARSOWOLD     => ["02", "Warsow (v0.4.2 <)"],
        self::URBANTERROR   => ["02", "UrbanTerror"],
        self::UT            => ["03", "Unreal Tournament"],
        self::UT2003        => ["13", "Unreal Tournament 2003"],
        self::UT2004        => ["13", "Unreal Tournament 2004"],
        self::UT3           => ["11", "Unreal Tournament 3"],
        self::VCMP          => ["12", "Vice City Multiplayer"],
        self::VIETCONG      => ["03", "Vietcong"],
        self::VIETCONG2     => ["09", "Vietcong 2"],
        self::WINDWARD      => ["Query49", "Windward"],
        self::WOLFET        => ["02", "Wolfenstein: Enemy Territory"],
        self::WOLFRTCW      => ["02", "Wolfenstein: Return To Castle Wolfenstein"],
        self::WOLF2009      => ["10", "Wolfenstein (2009 By Raven)"],
        self::WOW           => ["QueryStatus", "World of Warcraft"],
        self::TEST          => ["QueryTest", "~ Test (For PHP Developers)"],
      ];
      return $list[$type] ?? $list;
    }
    static public function lgsl_protocol_list() {
      return array_map(function($k) {
        return $k[0];
      }, Protocol::lgslList());
    }
    static public function lgsl_type_list() {
      global $lgsl_config;
      $lgsl_type_list = array_map(function($k) {
        return $k[1];
      }, Protocol::lgslList());
      if ($lgsl_config['disabled_types']) {
        foreach ($lgsl_config['disabled_types'] as $type) {
          unset($lgsl_type_list[$type]);
        }
      }
      return $lgsl_type_list;
    }
    static public function lgsl_port_conversion($type, $c_port, $q_port, $s_port) { // GAMES WHERE Q_PORT IS NOT EQUAL TO C_PORT
      $types = [ //        |C > Q |C def |Q def |C > S
        "aarmy"         => [1,     1716,  1717],
        "aarmy3"        => [0,     8777,  39300],
        "arcasimracing" => [-100,  34397, 34297],
        "arma3"         => [0,     2302,  2303],
        "bfbc2"         => [0,     19567, 48888],
        "bfvietnam"     => [0,     15567, 23000],
        "bf1942"        => [0,     14567, 23000],
        "bf2"           => [0,     16567, 29900],
        "bf3"           => [22000, 25200, 47200],
        "bf2142"        => [0,     17567, 29900],
        "callofdutybo3" => [0,     27017, 27017],
        "cube"          => [1,     28785, 28786],
        "dh2005"        => [0,     23459, 34567],
        "discord"       => [0,     1,     1],
        "factorio"      => [0,     34197, 34197],
        "farcry"        => [123,   49001, 49124],
        "fivem"         => [0,     30120, 30120],
        "flashpoint"    => [1,     2302,  2303],
        "frontlines"    => [2,     5476,  5478],
        "ghostrecon"    => [2,     2346,  2348],
        "gtr2"          => [1,     34297, 34298],
        "had2"          => [3,     11001, 11004],
        "kingpin"       => [-10,   31510, 31500],
        "killingfloor"  => [1,     7708,  7709],
        "minecraft"     => [0,     25565, 25565],
        "mohaa"         => [97,    12203, 12300],
        "mohaab"        => [97,    12203, 12300],
        "mohaas"        => [97,    12203, 12300],
        "mohpa"         => [97,    13203, 13300],
        "mta"           => [123,   22003, 22126],
        "painkiller"    => [123,   3455,  3578],
        "ragemp"        => [0,     22005, 22005],
        "ravenshield"   => [1000,  7777,  8777],
        "redorchestra"  => [1,     7758,  7759],
        "rfactor"       => [-100,  34397, 34297],
        "serioussam"    => [1,     25600, 25601],
        "soldat"        => [123,   23073, 23196],
        "sf"            => [0,     7777,  15777],
        "stalker"       => [2,     5447,  5445],
        "stalkercop"    => [2,     5447,  5445],
        "stalkercs"     => [2,     5447,  5445],
        "starwarsrc"    => [0,     7777,  11138],
        "swat4"         => [1,     10780, 10781],
        "terraria"      => [101,   7777,  7878],
        "tribesv"       => [1,     7777,  7778],
        "ts"            => [0,     8767,  51234],
        "ts3"           => [0,     9987,  10011],
        "teaspeak"      => [0,     9987,  10101],
        "ut"            => [1,     7777,  7778],
        "ut2003"        => [1,     7757,  7758,  10],
        "ut2004"        => [1,     7777,  7778,  10],
        "ut3"           => [0,     7777,  6500],
        "vietcong"      => [10000, 5425,  15425],
        "vietcong2"     => [0,     5001,  19967],
        "wow"           => [0,     3724,  8085],
      ];
      if (!isset($types[$type])) {
        if (!$q_port) $q_port = $c_port;
        return [$c_port, $q_port, $s_port];
      }
      $c_to_q = $types[$type][0];
      $c_def = $types[$type][1];
      $q_def = $types[$type][2];
      $c_to_s = $types[$type][3] ?? 0;

      if     (!$c_port && !$q_port && $c_def)  { $c_port = $c_def; $q_port = $q_def; }
      if     (!$c_port &&  $q_port && $c_to_q) { $c_port = $q_port - $c_to_q; }
      elseif (!$c_port &&  $q_port && $c_def)  { $c_port = $c_def; }
      elseif (!$c_port &&  $q_port)            { $c_port = $q_port; }
      if     (!$q_port &&  $c_port && $c_to_q) { $q_port = $c_port + $c_to_q; }
      elseif (!$q_port &&  $c_port && $q_def)  { $q_port = $q_def; }
      elseif (!$q_port &&  $c_port)            { $q_port = $c_port; }
      if     (!$s_port &&  $c_to_s)            { $s_port = $c_port + $c_to_s; }
  
      return [(int) $c_port, (int) $q_port, (int) $s_port];
    }
  
    public function lgsl_protocol_function($type) {
      $list = $this->lgsl_protocol_list();
      return $list[$type] ?? "err";
    }
		public function set_requested($types = 'sep') {
			$types = str_split($types);
			foreach ($types as $type) {
				$this->_lgsl_need[$type] = false;
				$this->_server->set_timestamp($type, time());
			}
			$this->_server_timestamp = $this->_server->get_timestamps();
		}
    public function query() {
			/*if ($this->_server->get_type() === "test") {
				$status = $this->lgsl_query_01();
				$this->_server->set_status($status);
				$this->set_requested();
				return;
			}*/
      $protocol = $this->lgsl_connection_type($this->_server->get_type());
			$this->_lgsl_fp = new Stream($protocol);
			if ($status = $this->_lgsl_fp->open($this->_server)) {
        $isNew = strpos($this->lgsl_protocol_function($this->_server->get_type()), "Query") !== false;
        if ($isNew) {
          $query = __NAMESPACE__ . "\\" . $this->lgsl_protocol_function($this->_server->get_type());
          $status = (new $query($this->_server, $this->_lgsl_fp, $this->_lgsl_need))->execute();
        } else {
				  $status = call_user_func([$this, "lgsl_query_{$this->lgsl_protocol_function($this->_server->get_type())}"], $this->_server->get_type());
        }
			} else {
        $this->_server->set_extra_value('_error', 'Can\'t establish the connection to server.');
				$this->set_requested();
      }
      $this->_server->set_status($status);
			$this->_server->set_timestamps($this->_server_timestamp);
			if ($this->_server->get_timestamp('s', true) == 0) $this->_server->set_timestamp('s', time());
			$this->_lgsl_fp->close();
    }
    private function _fp_write($string) {
			$this->_lgsl_fp->write($string);
    }
    private function _fp_read($length = 4096) {
      return $this->_lgsl_fp->read($length);
    }
    private function _fp_read_raw($length = 4096) {
      return $this->_lgsl_fp->readRaw($length);
    }
    
    public function lgsl_query_err($type = null) {
      return $this->_server->set_name("LGSL PROBLEM: FUNCTION DOES NOT EXIST FOR TYPE {$type}");
    }
    public function lgsl_query_02() {
      $server = $this->_server->to_array();

      if     ($server['b']['type'] == "quake2")              { $this->_fp_write("\xFF\xFF\xFF\xFFstatus");        }
      elseif ($server['b']['type'] == "warsowold")           { $this->_fp_write("\xFF\xFF\xFF\xFFgetinfo");       }
      elseif ($server['b']['type'] == "callofdutyiw")        { $this->_fp_write("\xFF\xFF\xFF\xFFgetinfo LGSL");  } // IW6x
      elseif (strpos($server['b']['type'], "moh") !== FALSE) { $this->_fp_write("\xFF\xFF\xFF\xFF\x02getstatus"); } // mohaa_ mohaab_ mohaas_ mohpa_
      else                                                   { $this->_fp_write("\xFF\xFF\xFF\xFFgetstatus");     }

      $buffer = $this->_fp_read_raw();
      if (!$buffer) { return FALSE; }

      //---------------------------------------------------------+

      $part = explode("\n", $buffer);  // SPLIT INTO PARTS: HEADER/SETTINGS/PLAYERS/FOOTER
      if ($server['b']['type'] !== "callofdutyiw") {
        array_pop($part);              // REMOVE FOOTER WHICH IS EITHER NULL OR "\challenge\"
      }
      $item = explode("\\", $part[1]); // SPLIT PART INTO ITEMS

      foreach ($item as $item_key => $data_key) {
        if (!($item_key % 2)) { continue; } // SKIP EVEN KEYS

        $s = 1;
        if ($item[0]) $s = 0; // IW4 HAS NO EXTRA "\"
        for ($i = $s; $i < count($item); $i += 2) { // SKIP EVEN KEYS
          $data_key               = strtolower(Helper::lgslParseColor($item[$i], "1"));
          $server['e'][$data_key] = Helper::lgslParseColor($item[$i+1], "1");
        }
      }

      //---------------------------------------------------------+

      if (!empty($server['e']['hostname']))    { $server['s']['name'] = $server['e']['hostname']; }
      if (!empty($server['e']['sv_hostname'])) { $server['s']['name'] = Helper::lgslParseColor($server['e']['sv_hostname'], "1"); }

      if (isset($server['e']['gamename'])) { $server['s']['game'] = $server['e']['gamename']; }
      if (isset($server['e']['protocol'])) {
				$games = ['6' => 'iw3', '20604' => 'iw5', '101' => 'iw6x'];
				$server['s']['game'] = $games[$server['e']['protocol']];
      }
      if (isset($server['e']['g_gametype'])) { $server['s']['mode'] = $server['e']['g_gametype']; }
      if (isset($server['e']['mapname']))  { $server['s']['map']  = $server['e']['mapname']; }

      $server['s']['players'] = empty($part['2']) ? 0 : count($part) - 2;
      if ($server['s']['players'])

      if (isset($server['e']['maxclients']))    { $server['s']['playersmax'] = $server['e']['maxclients']; }    // QUAKE 2
      if (isset($server['e']['sv_maxclients'])) { $server['s']['playersmax'] = $server['e']['sv_maxclients']; }

      if (isset($server['e']['pswrd']))      { $server['s']['password'] = $server['e']['pswrd']; }              // CALL OF DUTY
      if (isset($server['e']['needpass']))   { $server['s']['password'] = $server['e']['needpass']; }           // QUAKE 2
      if (isset($server['e']['g_needpass'])) { $server['s']['password'] = (int) $server['e']['g_needpass']; }

      array_shift($part); // REMOVE HEADER
      array_shift($part); // REMOVE SETTING

      //---------------------------------------------------------+

      if ($server['b']['type'] == "nexuiz") { // (SCORE) (PING) (TEAM IF TEAM GAME) "(NAME)"
        $pattern = "/(.*) (.*) (.*)\"(.*)\"/U";                    $fields = [1=>"score", 2=>"ping", 3=>"team", 4=>"name"];
      }
      elseif ($server['b']['type'] == "warsow") { // (SCORE) (PING) "(NAME)" (TEAM)
        $pattern = "/(.*) (.*) \"(.*)\" (.*)/";                    $fields = [1=>"score", 2=>"ping", 3=>"name", 4=>"team"];
      }
      elseif ($server['b']['type'] == "sof2") { // (SCORE) (PING) "(NAME)"
        $pattern = "/(.*) (.*) \"(.*)\"/";                    $fields = [1=>"score", 2=>"ping", 3=>"name"];
      }
      elseif (strpos($server['b']['type'], "mohpa") !== FALSE) { // (?) (SCORE) (?) (TIME) (?) "(RANK?)" "(NAME)"
        $pattern = "/(.*) (.*) (.*) (.*) (.*) \"(.*)\" \"(.*)\"/"; $fields = [2=>"score", 3=>"deaths", 4=>"time", 6=>"rank", 7=>"name"];
      }
      elseif (strpos($server['b']['type'], "moh") !== FALSE) { // (PING) "(NAME)"
        $pattern = "/(.*) \"(.*)\"/";                              $fields = [1=>"ping", 2=>"name"];
      }
      else { // (SCORE) (PING) "(NAME)"
        $pattern = "/(.*) (.*) \"(.*)\"/";                         $fields = [1=>"score", 2=>"ping", 3=>"name"];
      }

      //---------------------------------------------------------+

      foreach ($part as $player_key => $data) {
        if (!$data) { continue; }

        preg_match($pattern, $data, $match);

        foreach ($fields as $match_key => $field_name) {
          if (isset($match[$match_key])) { $server['p'][$player_key][$field_name] = trim($match[$match_key]); }
        }

        $server['p'][$player_key]['name'] = Helper::lgslParseColor($server['p'][$player_key]['name'], "1");

        if (isset($server['p'][$player_key]['time'])) {
          $server['p'][$player_key]['time'] = Helper::lgslTime($server['p'][$player_key]['time']);
        }
      }

      //---------------------------------------------------------+

      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_03() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      // BF1942 BUG: RETURNS 'GHOST' NAMES - TO SKIP THESE WE NEED AN [s] REQUEST FOR AN ACCURATE PLAYER COUNT
      if ($server['b']['type'] == "bf1942" && $this->_lgsl_need['p'] && !$this->_lgsl_need['s'] && !isset($this->_lgsl_need['sp'])) { $this->_lgsl_need['s'] = TRUE; $this->_lgsl_need['sp'] = TRUE; }
  
      if     ($server['b']['type'] == "cncrenegade")            { $this->_fp_write("\\status\\"); }
      elseif ($this->_lgsl_need['s'] || $this->_lgsl_need['e']) { $this->_fp_write("\\basic\\\\info\\\\rules\\"); $this->_lgsl_need['s'] = FALSE; $this->_lgsl_need['e'] = FALSE; }
      elseif ($this->_lgsl_need['p'])                           { $this->_fp_write("\\players\\");                $this->_lgsl_need['p'] = FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer = "";
      $packet_count = 0;
      $packet_total = 20;
  
      do {
        $packet = $this->_fp_read(4096);
  
        // QUERY PORT CHECK AS THE CONNECTION PORT WILL ALSO RESPOND
        if (strpos($packet, "\\") === FALSE) { return FALSE; }
  
        // REMOVE SLASH PREFIX
        if ($packet[0] == "\\") { $packet = substr($packet, 1); }
  
        while ($packet) {
          $key   = strtolower(lgsl_cut_string($packet, 0, "\\"));
          $value =       trim(lgsl_cut_string($packet, 0, "\\"));
  
          // CHECK IF KEY IS PLAYER DATA
          if (preg_match("/(.*)_([0-9]+)$/", $key, $match)) {
            // SEPERATE TEAM NAMES
            if ($match[1] == "teamname") { $server['t'][$match[2]]['name'] = $value; continue; }
  
            // CONVERT TO LGSL STANDARD
            if     ($match[1] == "player")     { $match[1] = "name";  }
            elseif ($match[1] == "playername") { $match[1] = "name";  }
            elseif ($match[1] == "frags")      { $match[1] = "score"; }
            elseif ($match[1] == "ngsecret")   { $match[1] = "stats"; }
  
            $server['p'][$match[2]][$match[1]] = $value; continue;
          }
  
          // SEPERATE QUERYID
          if ($key == "queryid") { $queryid = $value; continue; }
  
          // SERVER SETTING
          $server['e'][$key] = $value;
        }
  
        // FINAL PACKET NUMBER IS THE TOTAL
        if (isset($server['e']['final'])) {
          preg_match("/([0-9]+)\.([0-9]+)/", $queryid, $match);
          $packet_total = intval($match[2]);
          unset($server['e']['final']);
        }
  
        $packet_count ++;
      }
      while ($packet_count < $packet_total);
  
      //---------------------------------------------------------+
  
      if (isset($server['e']['mapname'])) {
        $server['s']['map'] = $server['e']['mapname'];
  
        if (!empty($server['e']['hostname']))    { $server['s']['name'] = LGSL::removeChars($server['e']['hostname']); }
        if (!empty($server['e']['sv_hostname'])) { $server['s']['name'] = $server['e']['sv_hostname']; }
  
        if (isset($server['e']['password']))   { $server['s']['password']   = $server['e']['password']; }
        if (isset($server['e']['numplayers'])) { $server['s']['players']    = $server['e']['numplayers']; }
        if (isset($server['e']['maxplayers'])) { $server['s']['playersmax'] = $server['e']['maxplayers']; }
  
        if (!empty($server['e']['gamename']))                                   { $server['s']['game'] = $server['e']['gamename']; }
        if (!empty($server['e']['gameid']) && empty($server['e']['gamename']))  { $server['s']['game'] = $server['e']['gameid']; }
        if (!empty($server['e']['gameid']) && $server['b']['type'] == "bf1942") { $server['s']['game'] = $server['e']['gameid']; }
				
				if (!empty($server['e']['gametype'])) { $server['s']['mode'] = $server['e']['gametype']; }
      }
  
      //---------------------------------------------------------+
  
      if ($server['p']) {
        // BF1942 BUG - REMOVE 'GHOST' PLAYERS
        if ($server['b']['type'] == "bf1942" && $server['s']['players']) {
          $server['p'] = array_slice($server['p'], 0, $server['s']['players']);
        }
  
        // OPERATION FLASHPOINT BUG: 'GHOST' PLAYERS IN UN-USED 'TEAM' FIELD
        if ($server['b']['type'] == "flashpoint") {
          foreach ($server['p'] as $key => $value) {
            unset($server['p'][$key]['team']);
          }
        }
  
        // AVP2 BUG: PLAYER NUMBER PREFIXED TO NAMES
        if ($server['b']['type'] == "avp2") {
          foreach ($server['p'] as $key => $value) {
            $server['p'][$key]['name'] = preg_replace("/[0-9]+~/", "", $server['p'][$key]['name']);
          }
        }
  
        // IF TEAM NAMES AVAILABLE USED INSTEAD OF TEAM NUMBERS
        if (isset($server['t'][0]['name'])) {
          foreach ($server['p'] as $key => $value) {
            $team_key = $server['p'][$key]['team'] - 1;
            $server['p'][$key]['team'] = $server['t'][$team_key]['name'];
          }
        }
  
        // RE-INDEX PLAYER KEYS TO REMOVE ANY GAPS
        $server['p'] = array_values($server['p']);
      }
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_04() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      $this->_fp_write("REPORT");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $lgsl_ravenshield_key = [
      "A1" => "playersmax",
      "A2" => "tkpenalty",
      "B1" => "players",
      "B2" => "allowradar",
      "D2" => "version",
      "E1" => "mapname",
      "E2" => "lid",
      "F1" => "maptype",
      "F2" => "gid",
      "G1" => "password",
      "G2" => "hostport",
      "H1" => "dedicated",
      "H2" => "terroristcount",
      "I1" => "hostname",
      "I2" => "aibackup",
      "J1" => "mapcycletypes",
      "J2" => "rotatemaponsuccess",
      "K1" => "mapcycle",
      "K2" => "forcefirstpersonweapons",
      "L1" => "players_name",
      "L2" => "gamename",
      "L3" => "punkbuster",
      "M1" => "players_time",
      "N1" => "players_ping",
      "O1" => "players_score",
      "P1" => "queryport",
      "Q1" => "rounds",
      "R1" => "roundtime",
      "S1" => "bombtimer",
      "T1" => "bomb",
      "W1" => "allowteammatenames",
      "X1" => "iserver",
      "Y1" => "friendlyfire",
      "Z1" => "autobalance"];
  
      //---------------------------------------------------------+
  
      $item = explode("\xB6", $buffer);
  
      foreach ($item as $data_value) {
        $tmp = explode(" ", $data_value, 2);
        $data_key = isset($lgsl_ravenshield_key[$tmp[0]]) ? $lgsl_ravenshield_key[$tmp[0]] : $tmp[0]; // CONVERT TO DESCRIPTIVE KEYS
        $server['e'][$data_key] = trim($tmp[1]); // ALL VALUES NEED TRIMMING
      }
  
      $server['e']['mapcycle']      = str_replace("/"," ", $server['e']['mapcycle']);      // CONVERT SLASH TO SPACE
      $server['e']['mapcycletypes'] = str_replace("/"," ", $server['e']['mapcycletypes']); // SO LONG LISTS WRAP
  
      //---------------------------------------------------------+
  
      $server['s']['game']       = $server['e']['gamename'];
      $server['s']['name']       = $server['e']['hostname'];
      $server['s']['map']        = $server['e']['mapname'];
      $server['s']['players']    = $server['e']['players'];
      $server['s']['playersmax'] = $server['e']['playersmax'];
      $server['s']['password']   = $server['e']['password'];
  
      //---------------------------------------------------------+
  
      $player_name  = isset($server['e']['players_name'])  ? explode("/", substr($server['e']['players_name'],  1)) : []; unset($server['e']['players_name']);
      $player_time  = isset($server['e']['players_time'])  ? explode("/", substr($server['e']['players_time'],  1)) : []; unset($server['e']['players_time']);
      $player_ping  = isset($server['e']['players_ping'])  ? explode("/", substr($server['e']['players_ping'],  1)) : []; unset($server['e']['players_ping']);
      $player_score = isset($server['e']['players_score']) ? explode("/", substr($server['e']['players_score'], 1)) : []; unset($server['e']['players_score']);
  
      foreach ($player_name as $key => $name) {
        $server['p'][$key]['name']  = $player_name[$key];
        $server['p'][$key]['time']  = $player_time[$key];
        $server['p'][$key]['ping']  = $player_ping[$key];
        $server['p'][$key]['score'] = $player_score[$key];
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_05() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://developer.valvesoftware.com/wiki/Server_Queries

			$xf = "\xFF\xFF\xFF\xFF";
      if ($server['b']['type'] == "halflifewon") {
        if     ($this->_lgsl_need['s']) { $this->_fp_write("{$xf}details\x00"); }
        elseif ($this->_lgsl_need['e']) { $this->_fp_write("{$xf}rules\x00");   }
        elseif ($this->_lgsl_need['p']) { $this->_fp_write("{$xf}players\x00"); }
      } else {
        $challenge_code = isset($this->_lgsl_need['challenge']) ? $this->_lgsl_need['challenge'] : "\x00\x00\x00\x00";
        if     ($this->_lgsl_need['s']) { $this->_fp_write("{$xf}\x54Source Engine Query\x00" . (isset($this->_lgsl_need['challenge']) ? $challenge_code : "")); }
        elseif ($this->_lgsl_need['e']) { $this->_fp_write("{$xf}\x56{$challenge_code}");                                                                 }
        elseif ($this->_lgsl_need['p']) { $this->_fp_write("{$xf}\x55{$challenge_code}");                                                                 }
      }

      //---------------------------------------------------------+
      //  THE STANDARD HEADER POSITION REVEALS THE TYPE BUT IT MAY NOT ARRIVE FIRST
      //  ONCE WE KNOW THE TYPE WE CAN FIND THE TOTAL NUMBER OF PACKETS EXPECTED

      $packet_temp  = [];
      $packet_type  = 0;
      $packet_count = 0;
      $packet_total = 4;

      do {
        if (!($packet = $this->_fp_read())) {
          if ($this->_lgsl_need['s']) { return FALSE; }
          elseif ($this->_lgsl_need['e']) { $this->set_requested('e'); return TRUE; }
          else { return TRUE; }
        }

        //---------------------------------------------------------------------------------------------------------------------------------+
        // NEWER HL1 SERVERS REPLY TO A2S_INFO WITH 3 PACKETS ( HL1 FORMAT INFO, SOURCE FORMAT INFO, PLAYERS )
        // THIS DISCARDS UN-EXPECTED PACKET FORMATS ON THE GO ( AS READING IN ADVANCE CAUSES TIMEOUT DELAYS FOR OTHER SERVER VERSIONS )
        // ITS NOT PERFECT AS [s] CAN FLIP BETWEEN HL1 AND SOURCE FORMATS DEPENDING ON ARRIVAL ORDER ( MAYBE FIX WITH RETURN ON HL1 APPID )
        if     ($this->_lgsl_need['s']) { if ($packet->char(4) == "D") { continue; } }
        elseif ($this->_lgsl_need['e']) { if ($packet->char(4) == "m" || $packet->char(4) == "I" || $packet->char(4) == "D") { continue; } }
        elseif ($this->_lgsl_need['p']) { if ($packet->char(4) == "m" || $packet->char(4) == "I") { continue; } }
        //---------------------------------------------------------------------------------------------------------------------------------+

        if     ($packet->get(0,  5) == "{$xf}\x41") { $this->_lgsl_need['challenge'] = $packet->get(5,  4); return call_user_func([$this, "lgsl_query_05"]); } // REPEAT WITH GIVEN CHALLENGE CODE
        elseif ($packet->get(0,  4) == "{$xf}")     { $packet_total = 1;                           $packet_type = 1;       } // SINGLE PACKET - HL1 OR HL2
        elseif ($packet->get(9,  4) == "{$xf}")     { $packet_total = ord($packet->char(8)) & 0xF; $packet_type = 2;       } // MULTI PACKET  - HL1 ( TOTAL IS LOWER NIBBLE OF BYTE )
        elseif ($packet->get(12, 4) == "{$xf}")     { $packet_total = ord($packet->char(8));       $packet_type = 3;       } // MULTI PACKET  - HL2
        elseif ($packet->get(18, 2) == "BZ")        { $packet_total = ord($packet->char(8));       $packet_type = 4;       } // BZIP PACKET   - HL2

        $packet_count ++;
        $packet_temp[] = $packet;
      }
      while ($packet && $packet_count < $packet_total);

      if ($packet_type == 0) { return $server['s'] ? TRUE : FALSE; } // UNKNOWN RESPONSE ( SOME SERVERS ONLY SEND [s] )

      //---------------------------------------------------------+
      //  WITH THE TYPE WE CAN NOW SORT AND JOIN THE PACKETS IN THE CORRECT ORDER
      //  REMOVING ANY EXTRA HEADERS IN THE PROCESS

      $buffer = $buffer_temp = [];

      foreach ($packet_temp as $packet) {
        if     ($packet_type == 1) { $packet_order = 0; }
        elseif ($packet_type == 2) { $packet_order = ord($packet->char(8)) >> 4; $packet->skip(9);  } // ( INDEX IS UPPER NIBBLE OF BYTE )
        elseif ($packet_type == 3) { $packet_order = ord($packet->char(9));      $packet->skip(12); }
        elseif ($packet_type == 4) { $packet_order = ord($packet->char(9));      $packet->skip(18); }

        $buffer_temp[$packet_order] = $packet;
      }
			unset($packet_temp);
      ksort($buffer_temp);

			$buffer = Buffer::join($buffer_temp);
			unset($buffer_temp);

      //---------------------------------------------------------+
      //  WITH THE PACKETS JOINED WE CAN NOW DECOMPRESS BZIP PACKETS
      //  THEN REMOVE THE STANDARD HEADER AND CHECK ITS CORRECT

      if ($packet_type == 4) {
        if (!function_exists("bzdecompress")) { // REQUIRES http://php.net/bzip2
          $server['e']['bzip2'] = "unavailable"; $this->_lgsl_need['e'] = FALSE;
          return TRUE;
        }

        $buffer->set(bzdecompress($buffer->getAll()));
      }

      $header = $buffer->cutByte(4);

      if ($header != $xf) { return FALSE; } // SOMETHING WENT WRONG

      //---------------------------------------------------------+

      $response_type = $buffer->cutByte();

      if ($response_type == "I") { // SOURCE INFO ( HALF-LIFE 2 )
        $server['e']['netcode']     = $buffer->cutByteOrd();
        $server['s']['name']        = $buffer->cutString();
        $server['s']['map']         = $buffer->cutString();
        $server['s']['game']        = $buffer->cutString();
        $server['e']['description'] = $buffer->cutString();
        $server['e']['appid']       = $buffer->cutByteUnpack(2, "S");
        $server['s']['players']     = $buffer->cutByteOrd();
        $server['s']['playersmax']  = $buffer->cutByteOrd();
        $server['e']['bots']        = $buffer->cutByteOrd();
        $server['e']['dedicated']   = $buffer->cutByte();
        $server['e']['os']          = $buffer->cutByte();
        $server['s']['password']    = $buffer->cutByteOrd();
        $server['e']['anticheat']   = $buffer->cutByteOrd();
        $server['e']['version']     = $buffer->cutString();

				$buffer->skip(6);
        if ($buffer->cutByteOrd() == 177) {
          $buffer->skip(4);
        }
        $server['e']['tags']        = $buffer->cutString();

        if ($server['s']['game'] === 'rust') {
          preg_match('/cp\d{1,3}/', $server['e']['tags'], $e);
          $server['s']['players'] = substr($e[0], 2);
          preg_match('/mp\d{1,3}/', $server['e']['tags'], $e);
          $server['s']['playersmax'] = substr($e[0], 2);
        }
				$this->set_requested('s');
      }
      elseif ($response_type == "m") { // HALF-LIFE 1 INFO
        $server_ip                  = $buffer->cutString();
        $server['s']['name']        = LGSL::removeChars($buffer->cutString());
        $server['s']['map']         = $buffer->cutString();
        $server['s']['game']        = $buffer->cutString();
        $server['e']['description'] = LGSL::removeChars($buffer->cutString());
        $server['s']['players']     = $buffer->cutByteOrd();
        $server['s']['playersmax']  = $buffer->cutByteOrd();
        $server['e']['netcode']     = $buffer->cutByteOrd();
        $server['e']['dedicated']   = $buffer->cutByte();
        $server['e']['os']          = $buffer->cutByte();
        $server['s']['password']    = $buffer->cutByteOrd();

        $mode = explode('_', $server['s']['map'])[0];
        switch ($mode) {
          case 'gg': $mode = 'gungame'; break;
          case 'zm': $mode = 'zombiemod'; break;
          case 'dm': $mode = 'deathmatch'; break;
          case 'ze': $mode = 'zombie escape'; break;
          case 'jail': $mode = 'jailbreak'; break;
          case 'deathrun': $mode = 'deathrun'; break;
          default: 'none';
        }

        if ($buffer->cutByteOrd()) { // MOD FIELDS ( OFF FOR SOME HALFLIFEWON-VALVE SERVERS )
          $server['e']['mod_url_info']     = $buffer->cutString();
          $server['e']['mod_url_download'] = $buffer->cutString();
          $buffer->skip(1);
          $server['e']['mod_version']      = $buffer->cutByteUnpack(4, "l");
          $server['e']['mod_size']         = $buffer->cutByteUnpack(4, "l");
          $server['e']['mod_server_side']  = $buffer->cutByteOrd();
          $server['e']['mod_custom_dll']   = $buffer->cutByteOrd();
        }

        $server['e']['anticheat'] = $buffer->cutByteOrd();
        $server['e']['bots']      = $buffer->cutByteOrd();
				$this->set_requested('s');
      }

      elseif ($response_type == "D") { // SOURCE AND HALF-LIFE 1 PLAYERS
        $buffer->skip(1);

        $player_key = 0;

        while ($buffer->length() > 4) {
          $buffer->skip(1);
          $server['p'][$player_key]['name']  = $buffer->cutString();
					if (strlen($server['p'][$player_key]['name']) == 0) $server['p'][$player_key]['name']  = "*unknown*";
          $server['p'][$player_key]['score'] = $buffer->cutByteUnpack(4, "l");
          $server['p'][$player_key]['time']  = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));

          $player_key ++;
        }
				$this->set_requested('p');
      }

      elseif ($response_type == "E") { // SOURCE AND HALF-LIFE 1 RULES
        $buffer->skip(2);

        while ($buffer->length() > 0) {
          $item_key   = strtolower($buffer->cutString());
          $item_value = $buffer->cutString();

          $server['e'][$item_key] = $item_value;
        }
				$this->set_requested('e');
      }

      //---------------------------------------------------------+

			$this->_server->from_array($server);
      if ($this->_lgsl_need['s'] || $this->_lgsl_need['e'] || $this->_lgsl_need['p']) {
				return call_user_func([$this, "lgsl_query_05"]);
			}

      //---------------------------------------------------------+
      return TRUE;
    }
    public function lgsl_query_06() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  GET A CHALLENGE CODE IF NEEDED

      $challenge_code = "";

      if ($server['b']['type'] != "bf2" && $server['b']['type'] != "graw") {
        $this->_fp_write("\xFE\xFD\x09\x21\x21\x21\x21\xFF\xFF\xFF\x01");

        $challenge_packet = $this->_fp_read_raw();

        if (!$challenge_packet) { return FALSE; }

        $challenge_code = substr($challenge_packet, 5, -1); // REMOVE HEADER AND TRAILING NULL

        // IF CODE IS RETURNED ( SOME STALKER SERVERS RETURN BLANK WHERE THE CODE IS NOT NEEDED )
        // CONVERT DECIMAL |TO| HEX AS 8 CHARACTER STRING |TO| 4 PAIRS OF HEX |TO| 4 PAIRS OF DECIMAL |TO| 4 PAIRS OF ASCII

        $challenge_code = $challenge_code ? chr($challenge_code >> 24).chr($challenge_code >> 16).chr($challenge_code >> 8).chr($challenge_code >> 0) : "";
      }

      $this->_fp_write("\xFE\xFD\x00\x21\x21\x21\x21{$challenge_code}\xFF\xFF\xFF\x01");

      //---------------------------------------------------------+
      //  GET RAW PACKET DATA

      $buffer = [];
      $packet_count = 0;
      $packet_total = 4;

      do {
        $packet_count ++;
        $packet = $this->_fp_read(8192);

        if (!$packet) { return FALSE; }

        $packet->skip(14); // REMOVE SPLITNUM HEADER
        $packet_order = $packet->cutByteOrd();

        if ($packet_order >= 128) { // LAST PACKET - SO ITS ORDER NUMBER IS ALSO THE TOTAL
          $packet_order -= 128;
          $packet_total = $packet_order + 1;
        }

        $buffer[$packet_order] = $packet;
        if ($server['b']['type'] == "minecraft" || $server['b']['type'] == "jc2mp") { $packet_total = 1; }

      }
      while ($packet_count < $packet_total);

      //---------------------------------------------------------+
      //  PROCESS AND SORT PACKETS
			
			if ($packet_total > 1) {
				foreach ($buffer as $key => $packet) {
					$packet = substr($packet, 0, -1); // REMOVE END NULL FOR JOINING

					if (substr($packet, -1) != "\x00") { // LAST VALUE HAS BEEN SPLIT
						$part = explode("\x00", $packet); // REMOVE SPLIT VALUE AS COMPLETE VALUE IS IN NEXT PACKET
						array_pop($part);
						$packet = implode("\x00", $part)."\x00";
					}

					if ($packet[0] != "\x00") { // PLAYER OR TEAM DATA THAT MAY BE A CONTINUATION
						$pos = strpos($packet, "\x00") + 1; // WHEN DATA IS SPLIT THE NEXT PACKET STARTS WITH A REPEAT OF THE FIELD NAME

						if (isset($packet[$pos]) && $packet[$pos] != "\x00") { // REPEATED FIELD NAMES END WITH \x00\x?? INSTEAD OF \x00\x00
							$packet = substr($packet, $pos + 1); // REMOVE REPEATED FIELD NAME
						} else {
							$packet = "\x00".$packet; // RE-ADD NULL AS PACKET STARTS WITH A NEW FIELD
						}
					}

					$buffer[$key] = $packet;
				}

				ksort($buffer);
			}

      $buffer = Buffer::join($buffer);

      //---------------------------------------------------------+
      //  SERVER SETTINGS

      $buffer->skip(1); // REMOVE HEADER \x00

      while ($key = strtolower($buffer->cutString())) {
        $server['e'][$key] = $buffer->cutString();
      }

      $lgsl_conversion = ["hostname"=>"name", "gamename"=>"game", "mapname"=>"map", "map"=>"map", "numplayers"=>"players", "maxplayers"=>"playersmax", "password"=>"password"];
      foreach ($lgsl_conversion as $e => $s) { if (isset($server['e'][$e])) { $server['s'][$s] = $server['e'][$e]; unset($server['e'][$e]); } }

      if ($server['b']['type'] == "bf2" || $server['b']['type'] == "bf2142") {
        $server['s']['map'] = ucwords(str_replace("_", " ", $server['s']['map']));
      } // MAP NAME CONSISTENCY
      elseif ($server['b']['type'] == "jc2mp") {
        $server['s']['map'] = 'Panau';
      }
      elseif ($server['b']['type'] == "minecraft") {
        if (isset($server['e']['gametype'])) {
          $server['s']['game'] = strtolower($server['e']['game_id']);
        }
        $server['s']['name'] = Helper::lgslParseColor($server['s']['name'], "minecraft");
        foreach ($server['e'] as $key => $val) {
          if (($key != 'version') && ($key != 'plugins') && ($key != 'whitelist')) {
            unset($server['e'][$key]);
          }
        }

        $plugins = explode(": ", $server['e']['plugins'], 2);
        if ($plugins[0]) {
          $server['e']['plugins'] = $plugins[0];
        } else {
          $server['e']['plugins'] = 'none (Vanilla)';
        }
        if (count($plugins) == 2) {
          while ($key = $this->lgsl_cut_string($plugins[1], 0, " ")) {
            $server['e'][$key] = $this->lgsl_cut_string($plugins[1], 0, "; ");
          }
        }
        $buffer->add("\x00"); // Needed to correctly terminate the players list
      }
      $this->_server->from_array($server);
      if ($server['s']['players'] == "0") { return TRUE; } // IF SERVER IS EMPTY SKIP THE PLAYER CODE

      //---------------------------------------------------------+
      //  PLAYER DETAILS

      $buffer->skip(1); // REMOVE HEADER \x01

      while ($buffer->length() > 0) {
        if ($buffer->char(0) == "\x02") { break; }
        if ($buffer->char(0) == "\x00") { $buffer->skip(1); break; }

        $field = $buffer->cutString(0, "\x00\x00");
        $field = strtolower(substr($field, 0, -1));

        if     ($field == "player") { $field = "name"; }
        elseif ($field == "aibot")  { $field = "bot";  }

        if ($buffer->char(0) == "\x00") { $buffer->skip(1); continue; }

        $value_list = $buffer->cutString(0, "\x00\x00");
        $value_list = explode("\x00", $value_list);

        foreach ($value_list as $key => $value) {
          $server['p'][$key][$field] = $value;
        }
      }

      //---------------------------------------------------------+
      //  TEAM DATA

      $buffer->skip(1); // REMOVE HEADER \x02

      while ($buffer->length() > 0) {
        if ($buffer[0] == "\x00") { break; }

        $field = $buffer->cutString(0, "\x00\x00");
        $field = strtolower($field);

        if     ($field == "team_t")  { $field = "name";  }
        elseif ($field == "score_t") { $field = "score"; }

        $value_list = $buffer->cutString(0, "\x00\x00");
        $value_list = explode("\x00", $value_list);

        foreach ($value_list as $key => $value) {
          $server['t'][$key][$field] = $value;
        }
      }

      //---------------------------------------------------------+
      //  TEAM NAME CONVERSION

      if ($server['p'] && isset($server['t'][0]['name']) && $server['t'][0]['name'] != "Team") {
        foreach ($server['p'] as $key => $value) {
          if (empty($server['p'][$key]['team'])) { continue; }

          $team_key = $server['p'][$key]['team'] - 1;

          if (!isset($server['t'][$team_key]['name'])) { continue; }

          $server['p'][$key]['team'] = $server['t'][$team_key]['name'];
        }
      }

      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_07() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      $this->_fp_write("\xFF\xFF\xFF\xFFstatus\x00");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 6, -2); // REMOVE HEADER AND FOOTER
      $part   = explode("\n", $buffer); // SPLIT INTO SETTINGS/PLAYER/PLAYER/PLAYER
  
      //---------------------------------------------------------+
  
      $item = explode("\\", $part[0]);
  
      foreach ($item as $item_key => $data_key) {
        if ($item_key % 2) { continue; } // SKIP ODD KEYS
  
        $data_key               = strtolower($data_key);
        $server['e'][$data_key] = $item[$item_key+1];
      }
  
      //---------------------------------------------------------+
  
      array_shift($part); // REMOVE SETTINGS
  
      foreach ($part as $key => $data) {
        preg_match("/(.*) (.*) (.*) (.*) \"(.*)\" \"(.*)\" (.*) (.*)/s", $data, $match); // GREEDY MATCH FOR SKINS
  
        $server['p'][$key]['pid']         = $match[1];
        $server['p'][$key]['score']       = $match[2];
        $server['p'][$key]['time']        = $match[3];
        $server['p'][$key]['ping']        = $match[4];
        $server['p'][$key]['name']        = Helper::lgslParseColor($match[5], $server['b']['type']);
        $server['p'][$key]['skin']        = $match[6];
        $server['p'][$key]['skin_top']    = $match[7];
        $server['p'][$key]['skin_bottom'] = $match[8];
      }
  
      //---------------------------------------------------------+
  
      $server['s']['game']       = $server['e']['*gamedir'];
      $server['s']['name']       = $server['e']['hostname'];
      $server['s']['map']        = $server['e']['map'];
      $server['s']['players']    = $server['p'] ? count($server['p']) : 0;
      $server['s']['playersmax'] = $server['e']['maxclients'];
      $server['s']['password']   = isset($server['e']['needpass']) && $server['e']['needpass'] > 0 && $server['e']['needpass'] < 4 ? 1 : 0;
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    ///
    public function lgsl_query_08() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      $this->_fp_write("s"); // ASE ( ALL SEEING EYE ) PROTOCOL
      $buffer = $this->_fp_read();
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer->skip(4); // REMOVE HEADER
  
      $server['e']['gamename']   = $buffer->cutPascal(1, -1);
      $server['e']['hostport']   = $buffer->cutPascal(1, -1);
      $server['s']['name']       = Helper::lgslParseColor($buffer->cutPascal(1, -1), $server['b']['type']);
      $server['e']['gamemode']   = $buffer->cutPascal(1, -1);
      $server['s']['map']        = $buffer->cutPascal(1, -1);
      $server['e']['version']    = $buffer->cutPascal(1, -1);
      $server['s']['password']   = $buffer->cutPascal(1, -1);
      $server['s']['players']    = $buffer->cutPascal(1, -1);
      $server['s']['playersmax'] = $buffer->cutPascal(1, -1);

      while ($buffer->length() > 0 && $buffer->char(0) != "\x01") {
        $item_key   = strtolower($buffer->cutPascal(1, -1));
        $item_value = $buffer->cutPascal(1, -1);
  
        $server['e'][$item_key] = $item_value;
      }
  
      $buffer->skip(1); // REMOVE END MARKER
  
      //---------------------------------------------------------+
  
      $player_key = 0;
  
      while ($buffer->length() > 0) {
        $bit_flags = $buffer->cutByte(); // FIELDS HARD CODED BELOW BECAUSE GAMES DO NOT USE THEM PROPERLY
  
        if     ($bit_flags == "\x3D")                 { $field_list = ["name",                  "score", "",     "time"]; } // FARCRY PLAYERS CONNECTING
        elseif ($server['b']['type'] == "farcry")     { $field_list = ["name", "team", "",      "score", "ping", "time"]; } // FARCRY PLAYERS JOINED
        elseif ($server['b']['type'] == "mta")        { $field_list = ["name", "",      "",     "score", "ping", ""    ]; }
        elseif ($server['b']['type'] == "painkiller") { $field_list = ["name", "",     "skin",  "score", "ping", ""    ]; }
        elseif ($server['b']['type'] == "soldat")     { $field_list = ["name", "team", "",      "score", "ping", "time"]; }
  
        foreach ($field_list as $item_key) {
          $item_value = $buffer->cutPascal(1, -1);
  
          if (!$item_key) { continue; }
  
          if ($item_key == "name") { Helper::lgslParseColor($item_value, $server['b']['type']); }
  
          $server['p'][$player_key][$item_key] = $item_value;
        }
  
        $player_key ++;
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_09() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      // SERIOUS SAM 2 RETURNS ALL PLAYER NAMES AS "Unknown Player" SO SKIP OR CONVERT ANY PLAYER REQUESTS
      if ($server['b']['type'] == "serioussam2") { $this->_lgsl_need['p'] = FALSE; if (!$this->_lgsl_need['s'] && !$this->_lgsl_need['e']) { $this->_lgsl_need['s'] = TRUE; } }
  
      //---------------------------------------------------------+
  
      if ($this->_lgsl_need['s'] || $this->_lgsl_need['e']) {
        $this->_lgsl_need['s'] = FALSE; $this->_lgsl_need['e'] = FALSE;
  
        $this->_fp_write("\xFE\xFD\x00\x21\x21\x21\x21\xFF\x00\x00\x00");
  
        $buffer = $this->_fp_read(4096);
  
        $buffer = substr($buffer, 5, -2); // REMOVE HEADER AND FOOTER
  
        if (!$buffer) { return FALSE; }
  
        $item = explode("\x00", $buffer);
  
        foreach ($item as $item_key => $data_key) {
          if ($item_key % 2) { continue; } // SKIP EVEN KEYS
  
          $data_key = strtolower($data_key);
          $server['e'][$data_key] = $item[$item_key+1];
        }
  
        if (isset($server['e']['hostname']))   { $server['s']['name']       = $server['e']['hostname']; }
        if (isset($server['e']['mapname']))    { $server['s']['map']        = $server['e']['mapname']; }
        if (isset($server['e']['numplayers'])) { $server['s']['players']    = $server['e']['numplayers']; }
        if (isset($server['e']['maxplayers'])) { $server['s']['playersmax'] = $server['e']['maxplayers']; }
        if (isset($server['e']['password']))   { $server['s']['password']   = $server['e']['password']; }
  
        if (!empty($server['e']['gamename']))   { $server['s']['game'] = $server['e']['gamename']; }   // AARMY
        if (!empty($server['e']['gsgamename'])) { $server['s']['game'] = $server['e']['gsgamename']; } // FEAR
        if (!empty($server['e']['game_id']))    { $server['s']['game'] = $server['e']['game_id']; }    // BFVIETNAM
  
        if ($server['b']['type'] == "arma" || $server['b']['type'] == "arma2") {
          $server['s']['map'] = $server['e']['mission'];
        } elseif ($server['b']['type'] == "vietcong2") {
          $server['e']['extinfo_autobalance'] = ord($server['e']['extinfo'][18]) == 2 ? "off" : "on";
          // [ 13 = Vietnam and RPG Mode 19 1b 99 9b ] [ 22 23 = Mounted MG Limit ]
          // [ 27 = Idle Limit ] [ 18 = Auto Balance ] [ 55 = Chat and Blind Spectator 5a 5c da dc ]
        }
      }
  
      //---------------------------------------------------------+
  
      elseif ($this->_lgsl_need['p']) {
        $this->_lgsl_need['p'] = FALSE;
  
        $this->_fp_write("\xFE\xFD\x00\x21\x21\x21\x21\x00\xFF\x00\x00");
  
        $buffer = $this->_fp_read(4096);
  
        $buffer = substr($buffer, 7, -1); // REMOVE HEADER / PLAYER TOTAL / FOOTER
  
        if (!$buffer) { return FALSE; }
  
        if (strpos($buffer, "\x00\x00") === FALSE) { return TRUE; } // NO PLAYERS
  
        $buffer     = explode("\x00\x00",$buffer, 2);            // SPLIT FIELDS FROM ITEMS
        $buffer[0]  = str_replace("_",      "",     $buffer[0]); // REMOVE UNDERSCORES FROM FIELDS
        $buffer[0]  = str_replace("player", "name", $buffer[0]); // LGSL STANDARD
        $field_list = explode("\x00",$buffer[0]);                // SPLIT UP FIELDS
        $item       = explode("\x00",$buffer[1]);                // SPLIT UP ITEMS
  
        $item_position = 0;
        $item_total    = count($item);
        $player_key    = 0;
  
        do {
          foreach ($field_list as $field) {
            $server['p'][$player_key][$field] = $item[$item_position];
  
            $item_position ++;
          }
  
          $player_key ++;
        }
        while ($item_position < $item_total);
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_10() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      if ($server['b']['type'] == "quakewars") { $this->_fp_write("\xFF\xFFgetInfoEX\xFF"); }
      else                                     { $this->_fp_write("\xFF\xFFgetInfo\xFF");   }
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      if     ($server['b']['type'] == "wolf2009")  { $buffer = substr($buffer, 31); }  // REMOVE HEADERS
      elseif ($server['b']['type'] == "quakewars") { $buffer = substr($buffer, 33); }
      else                                         { $buffer = substr($buffer, 23); }
  
      $buffer = Helper::lgslParseColor($buffer, "2");
  
      //---------------------------------------------------------+
  
      while ($buffer && $buffer[0] != "\x00") {
        $item_key   = strtolower(lgsl_cut_string($buffer));
        $item_value = lgsl_cut_string($buffer);
  
        $server['e'][$item_key] = $item_value;
      }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 2);
  
      $player_key = 0;
  
      //---------------------------------------------------------+
  
      if ($server['b']['type'] == "wolf2009") { // WOLFENSTEIN: (PID)(PING)(NAME)(TAGPOSITION)(TAG)(BOT)
        while ($buffer && $buffer[0] != "\x10") { // STOPS AT PID 16
          $server['p'][$player_key]['pid']     = ord(lgsl_cut_byte($buffer, 1));
          $server['p'][$player_key]['ping']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $server['p'][$player_key]['rate']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $server['p'][$player_key]['unknown'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $player_name                         = lgsl_cut_string($buffer);
          $player_tag_position                 = ord(lgsl_cut_byte($buffer, 1));
          $player_tag                          = lgsl_cut_string($buffer);
          $server['p'][$player_key]['bot']     = ord(lgsl_cut_byte($buffer, 1));
  
          if     ($player_tag == "")           { $server['p'][$player_key]['name'] = $player_name; }
          elseif ($player_tag_position == "0") { $server['p'][$player_key]['name'] = $player_tag." ".$player_name; }
          else                                 { $server['p'][$player_key]['name'] = $player_name." ".$player_tag; }
  
          $player_key ++;
        }
      }
  
      //---------------------------------------------------------+
  
      elseif ($server['b']['type'] == "quakewars") { // QUAKEWARS: (PID)(PING)(NAME)(TAGPOSITION)(TAG)(BOT)
        while ($buffer && $buffer[0] != "\x20") { // STOPS AT PID 32
          $server['p'][$player_key]['pid']  = ord(lgsl_cut_byte($buffer, 1));
          $server['p'][$player_key]['ping'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $player_name                      = lgsl_cut_string($buffer);
          $player_tag_position              = ord(lgsl_cut_byte($buffer, 1));
          $player_tag                       = lgsl_cut_string($buffer);
          $server['p'][$player_key]['bot']  = ord(lgsl_cut_byte($buffer, 1));
  
              if ($player_tag_position == "")  { $server['p'][$player_key]['name'] = $player_name; }
          elseif ($player_tag_position == "1") { $server['p'][$player_key]['name'] = $player_name." ".$player_tag; }
          else                                 { $server['p'][$player_key]['name'] = $player_tag." ".$player_name; }
  
          $player_key ++;
        }
  
        $buffer                      = substr($buffer, 1);
        $server['e']['si_osmask']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "I");
        $server['e']['si_ranked']    = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['si_timeleft']  = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "I") / 1000);
        $server['e']['si_gamestate'] = ord(lgsl_cut_byte($buffer, 1));
        $buffer                      = substr($buffer, 2);
  
        $player_key = 0;
  
        while ($buffer && $buffer[0] != "\x20") { // QUAKEWARS EXTENDED: (PID)(XP)(TEAM)(KILLS)(DEATHS)
          $server['p'][$player_key]['pid']    = ord(lgsl_cut_byte($buffer, 1));
          $server['p'][$player_key]['xp']     = intval(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
          $server['p'][$player_key]['team']   = lgsl_cut_string($buffer);
          $server['p'][$player_key]['score']  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "i");
          $server['p'][$player_key]['deaths'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "i");
          $player_key ++;
        }
      }
  
      //---------------------------------------------------------+
  
      elseif ($server['b']['type'] == "quake4") { // QUAKE4: (PID)(PING)(RATE)(NULLNULL)(NAME)(TAG)
        while ($buffer && $buffer[0] != "\x20") { // STOPS AT PID 32
          $server['p'][$player_key]['pid']  = ord(lgsl_cut_byte($buffer, 1));
          $server['p'][$player_key]['ping'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $server['p'][$player_key]['rate'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $buffer                           = substr($buffer, 2);
          $player_name                      = lgsl_cut_string($buffer);
          $player_tag                       = lgsl_cut_string($buffer);
          $server['p'][$player_key]['name'] = $player_tag ? $player_tag." ".$player_name : $player_name;
  
          $player_key ++;
        }
      }
  
      //---------------------------------------------------------+
  
      else { // DOOM3 AND PREY: (PID)(PING)(RATE)(NULLNULL)(NAME)
        while ($buffer && $buffer[0] != "\x20") { // STOPS AT PID 32
          $server['p'][$player_key]['pid']  = ord(lgsl_cut_byte($buffer, 1));
          $server['p'][$player_key]['ping'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $server['p'][$player_key]['rate'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $buffer                           = substr($buffer, 2);
          $server['p'][$player_key]['name'] = lgsl_cut_string($buffer);
  
          $player_key ++;
        }
      }
  
      //---------------------------------------------------------+
  
      $server['s']['game']       = $server['e']['gamename'];
      $server['s']['name']       = $server['e']['si_name'];
      $server['s']['map']        = $server['e']['si_map'];
      $server['s']['players']    = $server['p'] ? count($server['p']) : 0;
      $server['s']['playersmax'] = $server['e']['si_maxplayers'];
  
      if ($server['b']['type'] == "wolf2009" || $server['b']['type'] == "quakewars") {
        $server['s']['map']      = str_replace(".entities", "", $server['s']['map']);
        $server['s']['password'] = $server['e']['si_needpass'];
      } else {
        $server['s']['password'] = $server['e']['si_usepass'];
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_11() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://wiki.unrealadmin.org/UT3_query_protocol
      //  UT3 RESPONSE IS REALLY MESSY SO THIS CLEANS IT UP
  
      $status = $this->lgsl_query_06();
  
      if (!$status) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $server['s']['map'] = $server['e']['p1073741825'];
                      unset($server['e']['p1073741825']);
  
      //---------------------------------------------------------+
  
      $lgsl_ut3_key = [
      "s0"          => "bots_skill",
      "s6"          => "pure",
      "s7"          => "password",
      "s8"          => "bots_vs",
      "s10"         => "forcerespawn",
      "p268435703"  => "bots",
      "p268435704"  => "goalscore",
      "p268435705"  => "timelimit",
      "p268435717"  => "mutators_default",
      "p1073741826" => "gamemode",
      "p1073741827" => "description",
      "p1073741828" => "mutators_custom"];
  
      foreach ($lgsl_ut3_key as $old => $new) {
        if (!isset($server['e'][$old])) { continue; }
        $server['e'][$new] = $server['e'][$old];
        unset($server['e'][$old]);
      }
  
      //---------------------------------------------------------+
  
      $part = explode(".", $server['e']['gamemode']);
  
      if ($part[0] && (stristr($part[0], "UT") === FALSE)) {
        $server['s']['game'] = $part[0];
      }
  
      //---------------------------------------------------------+
  
      $tmp = $server['e']['mutators_default'];
             $server['e']['mutators_default'] = "";
  
      if ($tmp & 1)     { $server['e']['mutators_default'] .= " BigHead";           }
      if ($tmp & 2)     { $server['e']['mutators_default'] .= " FriendlyFire";      }
      if ($tmp & 4)     { $server['e']['mutators_default'] .= " Handicap";          }
      if ($tmp & 8)     { $server['e']['mutators_default'] .= " Instagib";          }
      if ($tmp & 16)    { $server['e']['mutators_default'] .= " LowGrav";           }
      if ($tmp & 64)    { $server['e']['mutators_default'] .= " NoPowerups";        }
      if ($tmp & 128)   { $server['e']['mutators_default'] .= " NoTranslocator";    }
      if ($tmp & 256)   { $server['e']['mutators_default'] .= " Slomo";             }
      if ($tmp & 1024)  { $server['e']['mutators_default'] .= " SpeedFreak";        }
      if ($tmp & 2048)  { $server['e']['mutators_default'] .= " SuperBerserk";      }
      if ($tmp & 8192)  { $server['e']['mutators_default'] .= " WeaponReplacement"; }
      if ($tmp & 16384) { $server['e']['mutators_default'] .= " WeaponsRespawn";    }
  
      $server['e']['mutators_default'] = str_replace(" ",    " / ", trim($server['e']['mutators_default']));
      $server['e']['mutators_custom']  = str_replace("\x1c", " / ",      $server['e']['mutators_custom']);
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_12() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      $ip = explode('.', $this->_server->get_ip(true));
      $sPacket = chr($ip[0]).chr($ip[1]).chr($ip[2]).chr($ip[3]).chr($this->_server->get_q_port() & 0xFF).chr($this->_server->get_q_port() >> 8 & 0xFF);
      if     ($server['b']['type'] == "samp") { $challenge_packet = "SAMP{$sPacket}"; }
      elseif ($server['b']['type'] == "vcmp") { $challenge_packet = "VCMP{$sPacket}"; $this->_lgsl_need['e'] = FALSE; }
  
      if     ($this->_lgsl_need['s']) { $challenge_packet .= "i"; }
      elseif ($this->_lgsl_need['e']) { $challenge_packet .= "r"; }
      elseif ($this->_lgsl_need['p'] && $server['b']['type'] == "samp") { $challenge_packet .= "d"; }
      elseif ($this->_lgsl_need['p'] && $server['b']['type'] == "vcmp") { $challenge_packet .= "c"; }
  
      $this->_fp_write($challenge_packet);
      $buffer = $this->_fp_read();
  
      if (!$buffer) { // IN CASE OF PACKET LOSS
        $this->_fp_write($challenge_packet);
        $buffer = $this->_fp_read();
      }
      if (!$buffer) {
        if ($this->_lgsl_need['s'] || $this->_server->get_status() === Server::OFFLINE) return FALSE;
        return true;
      }
  
      //---------------------------------------------------------+
  
      $buffer->skip(10); // REMOVE HEADER
  
      $response_type = $buffer->cutByte();
  
      //---------------------------------------------------------+
  
      if ($response_type == "i") {
        $this->_lgsl_need['s'] = FALSE;
  
        if ($server['b']['type'] == "vcmp") { $buffer->skip(12); }
  
        $server['s']['password']   = $buffer->cutByteOrd();
        $server['s']['players']    = $buffer->cutByteUnpack(2, "S");
        $server['s']['playersmax'] = $buffer->cutByteUnpack(2, "S");
        $server['s']['name']       = $buffer->cutPascal(4);
        $server['s']['mode']       = $buffer->cutPascal(4);
        $server['s']['map']        = $buffer->cutPascal(4);
				$this->set_requested('s');
      }
  
      //---------------------------------------------------------+
  
      elseif ($response_type == "r") {
        $item_total = $buffer->cutByteUnpack(2, "S");
  
        for ($i=0; $i < $item_total; $i++) {
          if ($buffer->length() == 0) { return FALSE; }  
          $data_key   = strtolower($buffer->cutPascal());
          $data_value = $buffer->cutPascal();
  
          $server['e'][$data_key] = $data_value;
        }
				$this->set_requested('e');
      }
  
      //---------------------------------------------------------+
  
      elseif ($response_type == "d") {
        $player_total = $buffer->cutByteUnpack(2, "S");
  
        for ($i=0; $i < $player_total; $i++) {
          if ($buffer->length() == 0) { return FALSE; }  
  
          $server['p'][$i]['pid']   = $buffer->cutByteOrd();
          $server['p'][$i]['name']  = $buffer->cutPascal();
          $server['p'][$i]['score'] = $buffer->cutByteUnpack(4, "S");
          $server['p'][$i]['ping']  = $buffer->cutByteUnpack(4, "S");
        }
				$this->set_requested('p');
      }
      
      //---------------------------------------------------------+
  
      elseif ($response_type == "c") {  
        $player_total = $buffer->cutByteUnpack(2, "S");
  
        for ($i=0; $i<$player_total; $i++) {
          if ($buffer->length() == 0) { return FALSE; }  
  
          $server['p'][$i]['name']  = $buffer->cutPascal();
        }
				$this->set_requested('p');
      }
			
			$this->_server->from_array($server);
      if ($this->_lgsl_need['s'] || $this->_lgsl_need['e'] || $this->_lgsl_need['p']) {
				return call_user_func([$this, "lgsl_query_12"]);
			}
  
      //---------------------------------------------------------+
      return TRUE;
    }
    public function lgsl_query_13() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      $buffer_s = ""; $this->_fp_write("\x21\x21\x21\x21\x00"); // REQUEST [s]
      $buffer_e = ""; $this->_fp_write("\x21\x21\x21\x21\x01"); // REQUEST [e]
      $buffer_p = ""; $this->_fp_write("\x21\x21\x21\x21\x02"); // REQUEST [p]
  
      //---------------------------------------------------------+
  
      while ($packet = $this->_fp_read(4096)) {
        if     ($packet[4] == "\x00") { $buffer_s .= substr($packet, 5); }
        elseif ($packet[4] == "\x01") { $buffer_e .= substr($packet, 5); }
        elseif ($packet[4] == "\x02") { $buffer_p .= substr($packet, 5); }
      }
  
      if (!$buffer_s) { return FALSE; }
  
      //---------------------------------------------------------+
      //  SOME VALUES START WITH A PASCAL LENGTH AND END WITH A NULL BUT THERE IS AN ISSUE WHERE
      //  CERTAIN CHARACTERS CAUSE A WRONG PASCAL LENGTH AND NULLS TO APPEAR WITHIN NAMES
  
      $buffer_s = str_replace("\xa0", "\x20", $buffer_s); // REPLACE SPECIAL SPACE WITH NORMAL SPACE
      $buffer_s = substr($buffer_s, 5);
      $server['e']['hostport']   = Helper::lgslUnpack(lgsl_cut_byte($buffer_s, 4), "S");
      $buffer_s = substr($buffer_s, 4);
      $server['s']['name']       = lgsl_cut_string($buffer_s, 1);
      $server['s']['map']        = lgsl_cut_string($buffer_s, 1);
      $server['e']['gamemode']   = lgsl_cut_string($buffer_s, 1);
      $server['s']['players']    = Helper::lgslUnpack(lgsl_cut_byte($buffer_s, 4), "S");
      $server['s']['playersmax'] = Helper::lgslUnpack(lgsl_cut_byte($buffer_s, 4), "S");
  
      //---------------------------------------------------------+
  
      while ($buffer_e && $buffer_e[0] != "\x00") {
        $item_key   = strtolower(lgsl_cut_string($buffer_e, 1));
        $item_value = lgsl_cut_string($buffer_e, 1);
  
        $item_key   = str_replace("\x1B\xFF\xFF\x01", "", $item_key);   // REMOVE MOD
        $item_value = str_replace("\x1B\xFF\xFF\x01", "", $item_value); // GARBAGE
  
        $server['e'][$item_key] = $item_value;
      }
  
      //---------------------------------------------------------+
      //  THIS PROTOCOL RETURNS MORE INFO THAN THE ALTERNATIVE BUT IT DOES NOT
      //  RETURN THE GAME NAME ! SO WE HAVE MANUALLY DETECT IT USING THE GAME TYPE
  
      $tmp = strtolower(substr($server['e']['gamemode'], 0, 2));
  
          if ($tmp == "ro") { $server['s']['game'] = "Red Orchestra"; }
      elseif ($tmp == "kf") { $server['s']['game'] = "Killing Floor"; }
  
      $server['s']['password'] = empty($server['e']['password']) && empty($server['e']['gamepassword']) ? "0" : "1";
  
      //---------------------------------------------------------+
  
      $player_key = 0;
  
      while ($buffer_p && $buffer_p[0] != "\x00") {
        $server['p'][$player_key]['pid']   = Helper::lgslUnpack(lgsl_cut_byte($buffer_p, 4), "S");
  
        $end_marker = ord($buffer_p[0]) > 64 ? "\x00\x00" : "\x00"; // DIRTY WORK-AROUND FOR NAMES WITH PROBLEM CHARACTERS
  
        $server['p'][$player_key]['name']  = lgsl_cut_string($buffer_p, 1, $end_marker);
        $server['p'][$player_key]['ping']  = Helper::lgslUnpack(lgsl_cut_byte($buffer_p, 4), "S");
        $server['p'][$player_key]['score'] = Helper::lgslUnpack(lgsl_cut_byte($buffer_p, 4), "s");
        $tmp                               = lgsl_cut_byte($buffer_p, 4);
  
            if ($tmp[3] == "\x20") { $server['p'][$player_key]['team'] = 1; }
        elseif ($tmp[3] == "\x40") { $server['p'][$player_key]['team'] = 2; }
  
        $player_key ++;
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_14() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://flstat.cryosphere.co.uk/global-list.php
  
      $this->_fp_write("\x00\x02\xf1\x26\x01\x26\xf0\x90\xa6\xf0\x26\x57\x4e\xac\xa0\xec\xf8\x68\xe4\x8d\x21");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 4); // HEADER   ( 00 03 F1 26 )
      $buffer = substr($buffer, 4); // NOT USED ( 87 + NAME LENGTH )
      $buffer = substr($buffer, 4); // NOT USED ( NAME END TO BUFFER END LENGTH )
      $buffer = substr($buffer, 4); // UNKNOWN  ( 80 )
  
      $server['s']['map']        = "freelancer";
      $server['s']['password']   = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l") - 1 ? 1 : 0;
      $server['s']['playersmax'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l") - 1;
      $server['s']['players']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l") - 1;
      $buffer                    = substr($buffer, 4);  // UNKNOWN ( 88 )
      $name_length               = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
      $buffer                    = substr($buffer, 56); // UNKNOWN
      $server['s']['name']       = lgsl_cut_byte($buffer, $name_length);
  
      lgsl_cut_string($buffer, 0, ":");
      lgsl_cut_string($buffer, 0, ":");
      lgsl_cut_string($buffer, 0, ":");
      lgsl_cut_string($buffer, 0, ":");
      lgsl_cut_string($buffer, 0, ":");
  
      // WHATS LEFT IS THE MOTD
      $server['e']['motd'] = substr($buffer, 0, -1);
  
      // REMOVE UTF-8 ENCODING NULLS
      $server['s']['name'] = str_replace("\x00", "", $server['s']['name']);
      $server['e']['motd'] = str_replace("\x00", "", $server['e']['motd']);
  
      // DOES NOT RETURN PLAYER INFORMATION
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_15() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      $this->_fp_write("GTR2_Direct_IP_Search\x00");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer = str_replace("\xFE", "\xFF", $buffer);
      $buffer = explode("\xFF", $buffer);
  
      $server['s']['name']       = $buffer[3];
      $server['s']['game']       = $buffer[7];
      $server['e']['version']    = $buffer[11];
      $server['e']['hostport']   = $buffer[15];
      $server['s']['map']        = $buffer[19];
      $server['s']['players']    = $buffer[25];
      $server['s']['playersmax'] = $buffer[27];
      $server['e']['gamemode']   = $buffer[31];
  
      // DOES NOT RETURN PLAYER INFORMATION
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_16() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE:
      //  http://www.planetpointy.co.uk/software/rfactorsspy.shtml
      //  http://users.pandora.be/viperius/mUtil/
      //  USES FIXED DATA POSITIONS WITH RANDOM CHARACTERS FILLING THE GAPS
  
      $this->_fp_write("rF_S");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      //  $server['e']['gamename']         = lgsl_get_string($buffer);
      $buffer = substr($buffer, 8);
      //  $server['e']['fullupdate']       = Helper::lgslUnpack($buffer[0], "C");
      $server['e']['region']           = Helper::lgslUnpack($buffer[1] .$buffer[2],  "S");
      //  $server['e']['ip']               = ($buffer[3] .$buffer[4].$buffer[5].$buffer[6]); // UNSIGNED LONG
      //  $server['e']['size']             = Helper::lgslUnpack($buffer[7] .$buffer[8],  "S");
      $server['e']['version']          = Helper::lgslUnpack($buffer[9] .$buffer[10], "S");
      //  $server['e']['version_racecast'] = Helper::lgslUnpack($buffer[11].$buffer[12], "S");
      $server['e']['hostport']         = Helper::lgslUnpack($buffer[13].$buffer[14], "S");
      //  $server['e']['queryport']        = Helper::lgslUnpack($buffer[15].$buffer[16], "S");
      $buffer = substr($buffer, 17);
      $server['s']['game']             = lgsl_get_string($buffer);
      $buffer = substr($buffer, 20);
      $server['s']['name']             = lgsl_get_string($buffer);
      $buffer = substr($buffer, 28);
      $server['s']['map']              = lgsl_get_string($buffer);
      $buffer = substr($buffer, 32);
      $server['e']['motd']             = lgsl_get_string($buffer);
      $buffer = substr($buffer, 96);
      $server['e']['packed_aids']      = Helper::lgslUnpack($buffer[0].$buffer[1], "S");
      //  $server['e']['ping']             = Helper::lgslUnpack($buffer[2].$buffer[3], "S");
      $server['e']['packed_flags']     = Helper::lgslUnpack($buffer[4],  "C");
      $server['e']['rate']             = Helper::lgslUnpack($buffer[5],  "C");
      $server['s']['players']          = Helper::lgslUnpack($buffer[6],  "C");
      $server['s']['playersmax']       = Helper::lgslUnpack($buffer[7],  "C");
      $server['e']['bots']             = Helper::lgslUnpack($buffer[8],  "C");
      $server['e']['packed_special']   = Helper::lgslUnpack($buffer[9],  "C");
      $server['e']['damage']           = Helper::lgslUnpack($buffer[10], "C");
      $server['e']['packed_rules']     = Helper::lgslUnpack($buffer[11].$buffer[12], "S");
      $server['e']['credits1']         = Helper::lgslUnpack($buffer[13], "C");
      $server['e']['credits2']         = Helper::lgslUnpack($buffer[14].$buffer[15], "S");
      $server['e']['time']             = Helper::lgslTime(Helper::lgslUnpack($buffer[16].$buffer[17], "S"));
      $server['e']['laps']             = Helper::lgslUnpack($buffer[18].$buffer[19], "s") / 16;
      $buffer = substr($buffer, 23);
      $server['e']['vehicles']         = lgsl_get_string($buffer);
  
      // DOES NOT RETURN PLAYER INFORMATION
  
      //---------------------------------------------------------+
  
      $server['s']['password']    = ($server['e']['packed_special'] & 2)  ? 1 : 0;
      $server['e']['racecast']    = ($server['e']['packed_special'] & 4)  ? 1 : 0;
      $server['e']['fixedsetups'] = ($server['e']['packed_special'] & 16) ? 1 : 0;
  
                                                $server['e']['aids']  = "";
      if ($server['e']['packed_aids'] & 1)    { $server['e']['aids'] .= " TractionControl"; }
      if ($server['e']['packed_aids'] & 2)    { $server['e']['aids'] .= " AntiLockBraking"; }
      if ($server['e']['packed_aids'] & 4)    { $server['e']['aids'] .= " StabilityControl"; }
      if ($server['e']['packed_aids'] & 8)    { $server['e']['aids'] .= " AutoShifting"; }
      if ($server['e']['packed_aids'] & 16)   { $server['e']['aids'] .= " AutoClutch"; }
      if ($server['e']['packed_aids'] & 32)   { $server['e']['aids'] .= " Invulnerability"; }
      if ($server['e']['packed_aids'] & 64)   { $server['e']['aids'] .= " OppositeLock"; }
      if ($server['e']['packed_aids'] & 128)  { $server['e']['aids'] .= " SteeringHelp"; }
      if ($server['e']['packed_aids'] & 256)  { $server['e']['aids'] .= " BrakingHelp"; }
      if ($server['e']['packed_aids'] & 512)  { $server['e']['aids'] .= " SpinRecovery"; }
      if ($server['e']['packed_aids'] & 1024) { $server['e']['aids'] .= " AutoPitstop"; }
  
      $server['e']['aids']     = str_replace(" ", " / ", trim($server['e']['aids']));
      $server['e']['vehicles'] = str_replace("|", " / ", trim($server['e']['vehicles']));
  
      unset($server['e']['packed_aids']);
      unset($server['e']['packed_flags']);
      unset($server['e']['packed_special']);
      unset($server['e']['packed_rules']);
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_17() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://masterserver.savage.s2games.com
  
      $this->_fp_write("\x9e\x4c\x23\x00\x00\xce\x21\x21\x21\x21");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 12); // REMOVE HEADER
  
      while ($key = strtolower(lgsl_cut_string($buffer, 0, "\xFE"))) {
        if ($key == "players") { break; }
  
        $value = lgsl_cut_string($buffer, 0, "\xFF");
        $value = str_replace("\x00", "", $value);
        $value = Helper::lgslParseColor($value, $server['b']['type']);
  
        $server['e'][$key] = $value;
      }
  
      $server['s']['name']       = $server['e']['name'];  unset($server['e']['name']);
      $server['s']['map']        = $server['e']['world']; unset($server['e']['world']);
      $server['s']['players']    = $server['e']['cnum'];  unset($server['e']['cnum']);
      $server['s']['playersmax'] = $server['e']['cmax'];  unset($server['e']['cnum']);
      $server['s']['password']   = $server['e']['pass'];  unset($server['e']['cnum']);
  
      //---------------------------------------------------------+
  
      $server['t'][0]['name'] = $server['e']['race1'];
      $server['t'][1]['name'] = $server['e']['race2'];
      $server['t'][2]['name'] = "spectator";
  
      $team_key   = -1;
      $player_key = 0;
  
      while ($value = lgsl_cut_string($buffer, 0, "\x0a")) {
        if ($value[0] == "\x00") { break; }
        if ($value[0] != "\x20") { $team_key++; continue; }
  
        $server['p'][$player_key]['name'] = Helper::lgslParseColor(substr($value, 1), $server['b']['type']);
        $server['p'][$player_key]['team'] = $server['t'][$team_key]['name'];
  
        $player_key++;
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_18() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://masterserver.savage2.s2games.com
  
      $this->_fp_write("\x01");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 12); // REMOVE HEADER
  
      $server['s']['name']            = lgsl_cut_string($buffer);
      $server['s']['players']         = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax']      = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['time']            = lgsl_cut_string($buffer);
      $server['s']['map']             = lgsl_cut_string($buffer);
      $server['e']['nextmap']         = lgsl_cut_string($buffer);
      $server['e']['location']        = lgsl_cut_string($buffer);
      $server['e']['minimum_players'] = ord(lgsl_cut_string($buffer));
      $server['e']['gamemode']        = lgsl_cut_string($buffer);
      $server['e']['version']         = lgsl_cut_string($buffer);
      $server['e']['minimum_level']   = ord(lgsl_cut_byte($buffer, 1));
  
      // DOES NOT RETURN PLAYER INFORMATION
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_19() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      $this->_fp_write("\xC0\xDE\xF1\x11\x42\x06\x00\xF5\x03\x21\x21\x21\x21");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 25); // REMOVE HEADER
  
      $server['s']['name']       = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
      $server['s']['map']        = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
      $server['e']['nextmap']    = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
      $server['e']['gametype']   = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
  
      $buffer = substr($buffer, 1);
  
      $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 4));
      $server['s']['players']    = ord(lgsl_cut_byte($buffer, 4));
  
      //---------------------------------------------------------+
  
      for ($player_key=0; $player_key<$server['s']['players']; $player_key++) {
       $server['p'][$player_key]['name'] = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
      }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 17);
  
      $server['e']['version']    = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
      $server['e']['mods']       = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
      $server['e']['dedicated']  = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['time']       = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['status']     = ord(lgsl_cut_byte($buffer, 4));
      $server['e']['gamemode']   = ord(lgsl_cut_byte($buffer, 4));
      $server['e']['motd']       = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
      $server['e']['respawns']   = ord(lgsl_cut_byte($buffer, 4));
      $server['e']['time_limit'] = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['voting']     = ord(lgsl_cut_byte($buffer, 4));
  
      $buffer = substr($buffer, 2);
  
      //---------------------------------------------------------+
  
      for ($player_key=0; $player_key<$server['s']['players']; $player_key++) {
       $server['p'][$player_key]['team'] = ord(lgsl_cut_byte($buffer, 4));
  
       $unknown = ord(lgsl_cut_byte($buffer, 1));
      }
  
      //---------------------------------------------------------+
  
      $buffer = substr($buffer, 7);
  
      $server['e']['platoon_1_color']   = ord(lgsl_cut_byte($buffer, 8));
      $server['e']['platoon_2_color']   = ord(lgsl_cut_byte($buffer, 8));
      $server['e']['platoon_3_color']   = ord(lgsl_cut_byte($buffer, 8));
      $server['e']['platoon_4_color']   = ord(lgsl_cut_byte($buffer, 8));
      $server['e']['timer_on']          = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['timer_time']        = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['time_debriefing']   = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['time_respawn_min']  = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['time_respawn_max']  = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['time_respawn_safe'] = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['difficulty']        = ord(lgsl_cut_byte($buffer, 4));
      $server['e']['respawn_total']     = ord(lgsl_cut_byte($buffer, 4));
      $server['e']['random_insertions'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['spectators']        = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['arcademode']        = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['ai_backup']         = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['random_teams']      = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['time_starting']     = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"));
      $server['e']['identify_friends']  = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['identify_threats']  = ord(lgsl_cut_byte($buffer, 1));
  
      $buffer = substr($buffer, 5);
  
      $server['e']['restrictions']      = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
  
      //---------------------------------------------------------+
  
      switch ($server['e']['status']) {
        case 3: $server['e']['status'] = "Joining"; break;
        case 4: $server['e']['status'] = "Joining"; break;
        case 5: $server['e']['status'] = "Joining"; break;
      }
  
      switch ($server['e']['gamemode']) {
        case 2: $server['e']['gamemode'] = "Co-Op"; break;
        case 3: $server['e']['gamemode'] = "Solo";  break;
        case 4: $server['e']['gamemode'] = "Team";  break;
      }
  
      switch ($server['e']['respawns']) {
        case 0: $server['e']['respawns'] = "None";       break;
        case 1: $server['e']['respawns'] = "Individual"; break;
        case 2: $server['e']['respawns'] = "Team";       break;
        case 3: $server['e']['respawns'] = "Infinite";   break;
      }
  
      switch ($server['e']['difficulty']) {
        case 0: $server['e']['difficulty'] = "Recruit"; break;
        case 1: $server['e']['difficulty'] = "Veteran"; break;
        case 2: $server['e']['difficulty'] = "Elite";   break;
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_20() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      if ($this->_lgsl_need['s']) {
        $this->_fp_write("\xFF\xFF\xFF\xFFFLSQ");
      } else {
        $this->_fp_write("\xFF\xFF\xFF\xFF\x57");
  
        $challenge_packet = $this->_fp_read(4096);
  
        if (!$challenge_packet) { return FALSE; }
  
        $challenge_code = substr($challenge_packet, 5, 4);
  
        if     ($this->_lgsl_need['e']) { $this->_fp_write("\xFF\xFF\xFF\xFF\x56{$challenge_code}"); }
        elseif ($this->_lgsl_need['p']) { $this->_fp_write("\xFF\xFF\xFF\xFF\x55{$challenge_code}"); }
      }
  
      $buffer = $this->_fp_read(4096);
      $buffer = substr($buffer, 4); // REMOVE HEADER
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $response_type = lgsl_cut_byte($buffer, 1);
  
      if ($response_type == "I") {
        $server['e']['netcode']     = ord(lgsl_cut_byte($buffer, 1));
        $server['s']['name']        = lgsl_cut_string($buffer);
        $server['s']['map']         = lgsl_cut_string($buffer);
        $server['s']['game']        = lgsl_cut_string($buffer);
        $server['e']['gamemode']    = lgsl_cut_string($buffer);
        $server['e']['description'] = lgsl_cut_string($buffer);
        $server['e']['version']     = lgsl_cut_string($buffer);
        $server['e']['hostport']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "n");
        $server['s']['players']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
        $server['s']['playersmax']  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
        $server['e']['dedicated']   = lgsl_cut_byte($buffer, 1);
        $server['e']['os']          = lgsl_cut_byte($buffer, 1);
        $server['s']['password']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
        $server['e']['anticheat']   = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
        $server['e']['cpu_load']    = round(3.03 * Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C"))."%";
        $server['e']['round']       = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
        $server['e']['roundsmax']   = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
        $server['e']['timeleft']    = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S") / 250);
      } elseif ($response_type == "E") {
        $returned = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
  
        while ($buffer) {
          $item_key   = strtolower(lgsl_cut_string($buffer));
          $item_value = lgsl_cut_string($buffer);
  
          $server['e'][$item_key] = $item_value;
        }
      } elseif ($response_type == "D") {
        $returned = ord(lgsl_cut_byte($buffer, 1));
  
        $player_key = 0;
  
        while ($buffer) {
          $server['p'][$player_key]['pid']   = ord(lgsl_cut_byte($buffer, 1));
          $server['p'][$player_key]['name']  = lgsl_cut_string($buffer);
          $server['p'][$player_key]['score'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "N");
          $server['p'][$player_key]['time']  = Helper::lgslTime(Helper::lgslUnpack(strrev(lgsl_cut_byte($buffer, 4)), "f"));
          $server['p'][$player_key]['ping']  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "n");
          $server['p'][$player_key]['uid']   = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "N");
          $server['p'][$player_key]['team']  = ord(lgsl_cut_byte($buffer, 1));
  
          $player_key ++;
        }
      }
  
      //---------------------------------------------------------+
  
      if     ($this->_lgsl_need['s']) { $this->_lgsl_need['s'] = FALSE; }
      elseif ($this->_lgsl_need['e']) { $this->_lgsl_need['e'] = FALSE; }
      elseif ($this->_lgsl_need['p']) { $this->_lgsl_need['p'] = FALSE; }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_21() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      fwrite($this->_lgsl_fp,"\xff\xff\xff\xff\xff\xff\xff\xff\xff\xffgief");
  
      $buffer = $this->_fp_read(4096);
      $buffer = substr($buffer, 20); // REMOVE HEADER
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $server['s']['name']       = lgsl_cut_string($buffer);
      $server['s']['map']        = lgsl_cut_string($buffer);
      $server['e']['gamemode']   = lgsl_cut_string($buffer);
      $server['s']['password']   = lgsl_cut_string($buffer);
      $server['e']['progress']   = lgsl_cut_string($buffer)."%";
      $server['s']['players']    = lgsl_cut_string($buffer);
      $server['s']['playersmax'] = lgsl_cut_string($buffer);
  
      switch ($server['e']['gamemode']) {
        case 0: $server['e']['gamemode'] = "Deathmatch"; break;
        case 1: $server['e']['gamemode'] = "Team Deathmatch"; break;
        case 2: $server['e']['gamemode'] = "Capture The Flag"; break;
      }
  
      //---------------------------------------------------------+
  
      $player_key = 0;
  
      while ($buffer) {
        $server['p'][$player_key]['name']  = lgsl_cut_string($buffer);
        $server['p'][$player_key]['score'] = lgsl_cut_string($buffer);
  
        $player_key ++;
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_22() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
  
      fwrite($this->_lgsl_fp,"\x03\x00\x00");
  
      $buffer = $this->_fp_read(4096);
      $buffer = substr($buffer, 3); // REMOVE HEADER
  
      if (!$buffer) { return FALSE; }
  
      $response_type = ord(lgsl_cut_byte($buffer, 1)); // TYPE SHOULD BE 4
  
      //---------------------------------------------------------+
  
      $grf_count = ord(lgsl_cut_byte($buffer, 1));
  
      for ($a=0; $a<$grf_count; $a++) {
        $server['e']['grf_'.$a.'_id'] = strtoupper(dechex(Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "N")));
  
        for ($b=0; $b<16; $b++) {
          $server['e']['grf_'.$a.'_md5'] .= strtoupper(dechex(ord(lgsl_cut_byte($buffer, 1))));
        }
      }
  
      //---------------------------------------------------------+
  
      $server['e']['date_current']   = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "L");
      $server['e']['date_start']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "L");
      $server['e']['companies_max']  = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['companies']      = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['spectators_max'] = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['name']           = lgsl_cut_string($buffer);
      $server['e']['version']        = lgsl_cut_string($buffer);
      $server['e']['language']       = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['password']       = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax']     = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['players']        = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['spectators']     = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['map']            = lgsl_cut_string($buffer);
      $server['e']['map_width']      = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
      $server['e']['map_height']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
      $server['e']['map_set']        = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['dedicated']      = ord(lgsl_cut_byte($buffer, 1));
  
      // DOES NOT RETURN PLAYER INFORMATION
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_23() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE:
      //  http://siteinthe.us
      //  http://www.tribesmasterserver.com
  
      $this->_fp_write("b++");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      $buffer = substr($buffer, 4); // REMOVE HEADER
  
      //---------------------------------------------------------+
  
      $server['s']['game']       = lgsl_cut_pascal($buffer);
      $server['e']['version']    = lgsl_cut_pascal($buffer);
      $server['s']['name']       = lgsl_cut_pascal($buffer);
      $server['e']['dedicated']  = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['players']    = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['cpu']        = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
      $server['e']['mod']        = lgsl_cut_pascal($buffer);
      $server['e']['type']       = lgsl_cut_pascal($buffer);
      $server['s']['map']        = lgsl_cut_pascal($buffer);
      $server['e']['motd']       = lgsl_cut_pascal($buffer);
      $server['e']['teams']      = ord(lgsl_cut_byte($buffer, 1));
  
      //---------------------------------------------------------+
  
      $team_field = "?".lgsl_cut_pascal($buffer);
      $team_field = split("\t", $team_field);
  
      foreach ($team_field as $key => $value) {
        $value = substr($value, 1);
        $value = strtolower($value);
        $team_field[$key] = $value;
      }
  
      //---------------------------------------------------------+
  
      $player_field = "?".lgsl_cut_pascal($buffer);
      $player_field = split("\t", $player_field);
  
      foreach ($player_field as $key => $value) {
        $value = substr($value, 1);
        $value = strtolower($value);
  
        if ($value == "player name") { $value = "name"; }
  
        $player_field[$key] = $value;
      }
  
      $player_field[] = "unknown_1";
      $player_field[] = "unknown_2";
  
      //---------------------------------------------------------+
  
      for ($i=0; $i<$server['e']['teams']; $i++) {
        $team_name = lgsl_cut_pascal($buffer);
        $team_info = lgsl_cut_pascal($buffer);
  
        if (!$team_info) { continue; }
  
        $team_info = str_replace("%t", $team_name, $team_info);
        $team_info = split("\t", $team_info);
  
        foreach ($team_info as $key => $value) {
          $field = $team_field[$key];
          $value = trim($value);
  
          if ($field == "team name") { $field = "name"; }
  
          $server['t'][$i][$field] = $value;
        }
      }
  
      //---------------------------------------------------------+
  
      for ($i=0; $i<$server['s']['players']; $i++) {
        $player_bits   = [];
        $player_bits[] = ord(lgsl_cut_byte($buffer, 1)) * 4; // %p = PING
        $player_bits[] = ord(lgsl_cut_byte($buffer, 1));     // %l = PACKET LOSS
        $player_bits[] = ord(lgsl_cut_byte($buffer, 1));     // %t = TEAM
        $player_bits[] = lgsl_cut_pascal($buffer);           // %n = PLAYER NAME
        $player_info   = lgsl_cut_pascal($buffer);
  
        if (!$player_info) { continue; }
  
        $player_info = str_replace(["%p","%l","%t","%n"], $player_bits, $player_info);
        $player_info = split("\t", $player_info);
  
        foreach ($player_info as $key => $value) {
          $field = $player_field[$key];
          $value = trim($value);
  
          if ($field == "team") { $value = $server['t'][$value]['name']; }
  
          $server['p'][$i][$field] = $value;
        }
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_24() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://cubelister.sourceforge.net
  
      $this->_fp_write("\x21\x21");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      $buffer = substr($buffer, 2); // REMOVE HEADER
  
      //---------------------------------------------------------+
  
      if ($buffer[0] == "\x1b") { // CUBE 1
        // RESPONSE IS XOR ENCODED FOR SOME STRANGE REASON
        for ($i=0; $i<strlen($buffer); $i++) { $buffer[$i] = chr(ord($buffer[$i]) ^ 0x61); }
  
        $server['s']['game']       = "Cube";
        $server['e']['netcode']    = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['gamemode']   = ord(lgsl_cut_byte($buffer, 1));
        $server['s']['players']    = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['timeleft']   = Helper::lgslTime(ord(lgsl_cut_byte($buffer, 1)) * 60);
        $server['s']['map']        = lgsl_cut_string($buffer);
        $server['s']['name']       = lgsl_cut_string($buffer);
        $server['s']['playersmax'] = "0"; // NOT PROVIDED
  
        // DOES NOT RETURN PLAYER INFORMATION
  
        return TRUE;
      } elseif ($buffer[0] == "\x80") { // ASSAULT CUBE
        $server['s']['game']       = "AssaultCube";
        $server['e']['netcode']    = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['version']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
        $server['e']['gamemode']   = ord(lgsl_cut_byte($buffer, 1));
        $server['s']['players']    = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['timeleft']   = Helper::lgslTime(ord(lgsl_cut_byte($buffer, 1)) * 60);
        $server['s']['map']        = lgsl_cut_string($buffer);
        $server['s']['name']       = lgsl_cut_string($buffer);
        $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 1));
      } elseif ($buffer[1] == "\x05") { // CUBE 2 - SAUERBRATEN
        $server['s']['game']       = "Sauerbraten";
        $server['s']['players']    = ord(lgsl_cut_byte($buffer, 1));
        $info_returned             = ord(lgsl_cut_byte($buffer, 1)); // CODED FOR 5
        $server['e']['netcode']    = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['version']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
        $server['e']['gamemode']   = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['timeleft']   = Helper::lgslTime(ord(lgsl_cut_byte($buffer, 1)) * 60);
        $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 1));
        $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1)); // BIT FIELD
        $server['s']['password']   = $server['s']['password'] & 4 ? "1" : "0";
        $server['s']['map']        = lgsl_cut_string($buffer);
        $server['s']['name']       = lgsl_cut_string($buffer);
      } elseif ($buffer[1] == "\x06") { // BLOODFRONTIER
        $server['s']['game']       = "Blood Frontier";
        $server['s']['players']    = ord(lgsl_cut_byte($buffer, 1));
        $info_returned             = ord(lgsl_cut_byte($buffer, 1)); // CODED FOR 6
        $server['e']['netcode']    = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['version']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
        $server['e']['gamemode']   = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['mutators']   = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['timeleft']   = Helper::lgslTime(ord(lgsl_cut_byte($buffer, 1)) * 60);
        $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 1));
        $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1)); // BIT FIELD
        $server['s']['password']   = $server['s']['password'] & 4 ? "1" : "0";
        $server['s']['map']        = lgsl_cut_string($buffer);
        $server['s']['name']       = lgsl_cut_string($buffer);
      } else { // UNKNOWN
        return FALSE;
      }
  
      //---------------------------------------------------------+
      //  CRAZY PROTOCOL - REQUESTS MUST BE MADE FOR EACH PLAYER
      //  BOTS ARE RETURNED BUT NOT INCLUDED IN THE PLAYER TOTAL
      //  AND THERE CAN BE ID GAPS BETWEEN THE PLAYERS RETURNED
  
      if ($this->_lgsl_need['p'] && $server['s']['players']) {
        $player_key = 0;
  
        for ($player_id=0; $player_id<32; $player_id++) {
          $this->_fp_write("\x00\x01".chr($player_id));
  
          // READ PACKET
          $buffer = $this->_fp_read(4096);
          if (!$buffer) { break; }
  
          // CHECK IF PLAYER ID IS ACTIVE
          if ($buffer[5] != "\x00") {
            if ($player_key < $server['s']['players']) { continue; }
            break;
          }
  
          // IF PREVIEW PACKET GET THE FULL PACKET THAT FOLLOWS
          if (strlen($buffer) < 15) {
            $buffer = $this->_fp_read(4096);
            if (!$buffer) { break; }
          }
  
          // REMOVE HEADER
          $buffer = substr($buffer, 7);
  
          // WE CAN NOW GET THE PLAYER DETAILS
          if ($server['s']['game'] == "Blood Frontier") {
            $server['p'][$player_key]['pid']       = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['ping']      = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['ping']      = $server['p'][$player_key]['ping'] == 128 ? Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S") : $server['p'][$player_key]['ping'];
            $server['p'][$player_key]['name']      = lgsl_cut_string($buffer);
            $server['p'][$player_key]['team']      = lgsl_cut_string($buffer);
            $server['p'][$player_key]['score']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "c");
            $server['p'][$player_key]['damage']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['deaths']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['teamkills'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['accuracy']  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C")."%";
            $server['p'][$player_key]['health']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "c");
            $server['p'][$player_key]['spree']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['weapon']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
          } else {
            $server['p'][$player_key]['pid']       = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['name']      = lgsl_cut_string($buffer);
            $server['p'][$player_key]['team']      = lgsl_cut_string($buffer);
            $server['p'][$player_key]['score']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "c");
            $server['p'][$player_key]['deaths']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['teamkills'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['accuracy']  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C")."%";
            $server['p'][$player_key]['health']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "c");
            $server['p'][$player_key]['armour']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
            $server['p'][$player_key]['weapon']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 1), "C");
          }
  
          $player_key++;
        }
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_25() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://www.tribesnext.com
  
      fwrite($this->_lgsl_fp,"\x12\x02\x21\x21\x21\x21");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      $buffer = substr($buffer, 6); // REMOVE HEADER
  
      //---------------------------------------------------------+
      $server['s']['game']       = lgsl_cut_pascal($buffer);
      $server['e']['gamemode']   = lgsl_cut_pascal($buffer);
      $server['s']['map']        = lgsl_cut_pascal($buffer);
      $server['e']['bit_flags']  = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['players']    = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['bots']       = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['cpu']        = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
      $server['e']['motd']       = lgsl_cut_pascal($buffer);
      $server['e']['unknown']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
  
      $server['e']['dedicated']  = ($server['e']['bit_flags'] & 1)  ? "1" : "0";
      $server['s']['password']   = ($server['e']['bit_flags'] & 2)  ? "1" : "0";
      $server['e']['os']         = ($server['e']['bit_flags'] & 4)  ? "L" : "W";
      $server['e']['tournament'] = ($server['e']['bit_flags'] & 8)  ? "1" : "0";
      $server['e']['no_alias']   = ($server['e']['bit_flags'] & 16) ? "1" : "0";
  
      unset($server['e']['bit_flags']);
  
      //---------------------------------------------------------+
  
      $team_total = lgsl_cut_string($buffer, 0, "\x0A");
  
      for ($i=0; $i<$team_total; $i++) {
        $server['t'][$i]['name']  = lgsl_cut_string($buffer, 0, "\x09");
        $server['t'][$i]['score'] = lgsl_cut_string($buffer, 0, "\x0A");
      }
  
      $player_total = lgsl_cut_string($buffer, 0, "\x0A");
  
      for ($i=0; $i<$player_total; $i++) {
        lgsl_cut_byte($buffer, 1); // ? 16
        lgsl_cut_byte($buffer, 1); // ? 8 or 14 = BOT / 12 = ALIAS / 11 = NORMAL
        if (ord($buffer[0]) < 32) { lgsl_cut_byte($buffer, 1); } // ? 8 PREFIXES SOME NAMES
  
        $server['p'][$i]['name']  = lgsl_cut_string($buffer, 0, "\x11");
                                    lgsl_cut_string($buffer, 0, "\x09"); // ALWAYS BLANK
        $server['p'][$i]['team']  = lgsl_cut_string($buffer, 0, "\x09");
        $server['p'][$i]['score'] = lgsl_cut_string($buffer, 0, "\x0A");
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_26() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE:
      //  http://hazardaaclan.com/wiki/doku.php?id=aa3_server_query
      //  http://aluigi.altervista.org/papers.htm#aa3authdec
  
      if (!function_exists('gzuncompress')) { return FALSE; } // REQUIRES http://www.php.net/zlib
  
      $packet = "\x0A\x00playerName\x06\x06\x00query\x00";
      lgsl_gs_crypt($server['b']['type'], $packet, TRUE);
      $this->_fp_write("\x4A\x35\xFF\xFF\x02\x00\x02\x00\x01\x00{$packet}");
  
      $buffer = [];
      $packet_count = 0;
      $packet_total = 4;
  
      do {
        $packet_count ++;
        $packet = $this->_fp_read(4096);
  
        if (!isset($packet[5])) { return FALSE; }
  
        if ($packet[5] == "\x03") { // MULTI PACKET
          $packet_order = ord($packet[10]);
          $packet_total = ord($packet[12]);
          $packet = substr($packet, 14);
          $buffer[$packet_order] = $packet;
        } elseif ($packet[5] == "\x02") { // SINGLE PACKET
          $buffer[0] = substr($packet, 10);
          break;
        } else {
          return FALSE;
        }
      }
      while ($packet_count < $packet_total);
  
      //---------------------------------------------------------+
  
      ksort($buffer);
  
      $buffer = implode("", $buffer);
  
      lgsl_gs_crypt($server['b']['type'], $buffer, FALSE);
  
      $buffer = @gzuncompress($buffer);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $raw = [];
  
      do {
        $raw_name = lgsl_cut_pascal($buffer, 2);
        $raw_type = lgsl_cut_byte($buffer, 1);
  
        switch ($raw_type) {
          // SINGLE INTEGER
          case "\x02":
          $raw[$raw_name] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "i");
          break;
  
          // ARRAY OF STRINGS
          case "\x07":
          $raw_total = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
  
          for ($i=0; $i<$raw_total; $i++) {
            $raw_value = lgsl_cut_pascal($buffer, 2);
            if (substr($raw_value, -1) == "\x00") { $raw_value = substr($raw_value, 0, -1); } // SOME STRINGS HAVE NULLS
            $raw[$raw_name][] = $raw_value;
          }
          break;
  
          // 01=BOOLEAN|03=SHORT INTEGER|04=DOUBLE
          // 05=CHAR|06=STRING|09=ARRAY OF INTEGERS
          default:
          break 2;
        }
      }
      while ($buffer);
  
      if (!isset($raw['attributeNames'])  || !is_array($raw['attributeNames']))  { return FALSE; }
      if (!isset($raw['attributeValues']) || !is_array($raw['attributeValues'])) { return FALSE; }
  
      //---------------------------------------------------------+
  
      foreach ($raw['attributeNames'] as $key => $field) {
        $field = strtolower($field);
  
        preg_match("/^player(.*)(\d+)$/U", $field, $match);
  
        if (isset($match[1])) {
          // IGNORE POINTLESS PLAYER FIELDS
          if ($match[1] == "mapname")         { continue; }
          if ($match[1] == "version")         { continue; }
          if ($match[1] == "servermapname")   { continue; }
          if ($match[1] == "serveripaddress") { continue; }
  
          // LGSL STANDARD ( SWAP NAME AS ITS ACTUALLY THE ACCOUNT NAME )
          if ($match[1] == "name")        { $match[1] = "username"; }
          if ($match[1] == "soldiername") { $match[1] = "name"; }
  
          $server['p'][$match[2]][$match[1]] = $raw['attributeValues'][$key];
        } else {
          if (substr($field, 0, 6) == "server") { $field = substr($field, 6); }
          $server['e'][$field] = $raw['attributeValues'][$key];
        }
      }
  
      $lgsl_conversion = ["gamename"=>"name","mapname"=>"map","playercount"=>"players","maxplayers"=>"playersmax","flagpassword"=>"password"];
      foreach ($lgsl_conversion as $e => $s) { $server['s'][$s] = $server['e'][$e]; unset($server['ea'][$e]); } // LGSL STANDARD
      $server['s']['playersmax'] += intval($server['e']['maxspectators']); // ADD SPECTATOR SLOTS TO MAX PLAYERS
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_27() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE:
      //  http://skulltag.com/wiki/Launcher_protocol
      //  http://en.wikipedia.org/wiki/Huffman_coding
      //  http://www.greycube.com/help/lgsl_other/skulltag_huffman.txt
  
      $huffman_table = [
      "010","110111","101110010","00100","10011011","00101","100110101","100001100","100101100","001110100","011001001","11001000","101100001","100100111","001111111","101110000","101110001","001111011",
      "11011011","101111100","100001110","110011111","101100000","001111100","0011000","001111000","10001100","100101011","100010000","101111011","100100110","100110010","0111","1111000","00010001",
      "00011010","00011000","00010101","00010000","00110111","00110110","00011100","01100101","1101001","00110100","10110011","10110100","1111011","10111100","10111010","11001001","11010101","11111110",
      "11111100","10001110","11110011","001101011","10000000","000101101","11010000","001110111","100000010","11100111","001100101","11100110","00111001","10001010","00010011","001110110","10001111",
      "000111110","11000111","11010111","11100011","000101000","001100111","11010100","000111010","10010111","100000111","000100100","001110001","11111010","100100011","11110100","000110111","001111010",
      "100010011","100110001","11101","110001011","101110110","101111110","100100010","100101001","01101","100100100","101100101","110100011","100111100","110110001","100010010","101101101","011001110",
      "011001101","11111101","100010001","100110000","110001000","110110000","0001001010","110001010","101101010","000110110","10110001","110001101","110101101","110001100","000111111","110010101",
      "111000100","11011001","110010110","110011110","000101100","001110101","101111101","1001110","0000","1000010","0001110111","0001100101","1010","11001110","0110011000","0110011001","1000011011",
      "1001100110","0011110011","0011001100","11111001","0110010001","0001010011","1000011010","0001001011","1001101001","101110111","1000001101","1000011111","1100000101","0110000000","1011011101",
      "11110101","0001111011","1101000101","1101000100","1001000010","0110000001","1011001000","100101010","1100110","111100101","1100101111","0001100111","1110000","0011111100","11111011","1100101110",
      "101110011","1001100111","1001111111","1011011100","111110001","101111010","1011010110","1001010000","1001000011","1001111110","0011111011","1000011110","1000101100","01100001","00010111",
      "1000000110","110000101","0001111010","0011001101","0110011110","110010100","111000101","0011001001","0011110010","110000001","101101111","0011111101","110110100","11100100","1011001001",
      "0011001000","0001110110","111111111","110101100","111111110","1000001011","1001011010","110000000","000111100","111110000","011000001","1001111010","111001011","011000111","1001000001",
      "1001111100","1000110111","1001101000","0110001100","1001111011","0011010101","1000101101","0011111010","0001100100","01100010","110000100","101101100","0110011111","1001011011","1000101110",
      "111100100","1000110110","0110001101","1001000000","110110101","1000001000","1000001001","1100000100","110001001","1000000111","1001111101","111001010","0011010100","1000101111","101111111",
      "0001010010","0011100000","0001100110","1000001010","0011100001","11000011","1011010111","1000001100","100011010","0110010000","100100101","1001010001","110000011"];
  
      //---------------------------------------------------------+
  
      $this->_fp_write("\x02\xB8\x49\x1A\x9C\x8B\xB5\x3F\x1E\x8F\x07");
  
      $packet = $this->_fp_read(4096);
  
      if (!$packet) { return FALSE; }
  
      $packet = substr($packet, 1); // REMOVE HEADER
  
      //---------------------------------------------------------+
  
      $packet_binary = "";
  
      for ($i=0; $i<strlen($packet); $i++) {
        $packet_binary .= strrev(sprintf("%08b", ord($packet[$i])));
      }
  
      $buffer = "";
  
      while ($packet_binary) {
        foreach ($huffman_table as $ascii => $huffman_binary) {
          $huffman_length = strlen($huffman_binary);
  
          if (substr($packet_binary, 0, $huffman_length) === $huffman_binary) {
            $packet_binary = substr($packet_binary, $huffman_length);
            $buffer .= chr($ascii);
            continue 2;
          }
        }
        break;
      }
  
      //---------------------------------------------------------+
  
      $response_status        = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l"); if ($response_status != "5660023") { return FALSE; }
      $response_time          = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
      $server['e']['version'] = lgsl_cut_string($buffer);
      $response_flag          = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
  
      //---------------------------------------------------------+
  
      if ($response_flag & 0x00000001) { $server['s']['name']       = lgsl_cut_string($buffer); }
      if ($response_flag & 0x00000002) { $server['e']['wadurl']     = lgsl_cut_string($buffer); }
      if ($response_flag & 0x00000004) { $server['e']['email']      = lgsl_cut_string($buffer); }
      if ($response_flag & 0x00000008) { $server['s']['map']        = lgsl_cut_string($buffer); }
      if ($response_flag & 0x00000010) { $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 1)); }
      if ($response_flag & 0x00000020) { $server['e']['playersmax'] = ord(lgsl_cut_byte($buffer, 1)); }
      if ($response_flag & 0x00000040) {
        $pwad_total = ord(lgsl_cut_byte($buffer, 1));
  
        $server['e']['pwads'] = "";
  
        for ($i=0; $i<$pwad_total; $i++) {
          $server['e']['pwads'] .= lgsl_cut_string($buffer)." ";
        }
      }
      if ($response_flag & 0x00000080) {
        $server['e']['gametype'] = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['instagib'] = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['buckshot'] = ord(lgsl_cut_byte($buffer, 1));
      }
      if ($response_flag & 0x00000100) { $server['s']['game']         = lgsl_cut_string($buffer); }
      if ($response_flag & 0x00000200) { $server['e']['iwad']         = lgsl_cut_string($buffer); }
      if ($response_flag & 0x00000400) { $server['s']['password']     = ord(lgsl_cut_byte($buffer, 1)); }
      if ($response_flag & 0x00000800) { $server['e']['playpassword'] = ord(lgsl_cut_byte($buffer, 1)); }
      if ($response_flag & 0x00001000) { $server['e']['skill']        = ord(lgsl_cut_byte($buffer, 1)) + 1; }
      if ($response_flag & 0x00002000) { $server['e']['botskill']     = ord(lgsl_cut_byte($buffer, 1)) + 1; }
      if ($response_flag & 0x00004000) {
        $server['e']['dmflags']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
        $server['e']['dmflags2']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
        $server['e']['compatflags'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
      }
      if ($response_flag & 0x00010000) {
        $server['e']['fraglimit'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
        $timelimit                = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
  
        if ($timelimit) { // FUTURE VERSION MAY ALWAYS RETURN THIS
          $server['e']['timeleft'] = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S") * 60);
        }
  
        $server['e']['timelimit']  = Helper::lgslTime($timelimit * 60);
        $server['e']['duellimit']  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
        $server['e']['pointlimit'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
        $server['e']['winlimit']   = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
      }
      if ($response_flag & 0x00020000) { $server['e']['teamdamage'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f"); }
      if ($response_flag & 0x00040000) { // DEPRECIATED
        $server['t'][0]['score'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
        $server['t'][1]['score'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
      }
      if ($response_flag & 0x00080000) { $server['s']['players'] = ord(lgsl_cut_byte($buffer, 1)); }
      if ($response_flag & 0x00100000) {
        for ($i=0; $i<$server['s']['players']; $i++) {
          $server['p'][$i]['name']      = Helper::lgslParseColor(lgsl_cut_string($buffer), $server['b']['type']);
          $server['p'][$i]['score']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
          $server['p'][$i]['ping']      = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
          $server['p'][$i]['spectator'] = ord(lgsl_cut_byte($buffer, 1));
          $server['p'][$i]['bot']       = ord(lgsl_cut_byte($buffer, 1));
  
          if (($response_flag & 0x00200000) && ($response_flag & 0x00400000)) {
            $server['p'][$i]['team'] = ord(lgsl_cut_byte($buffer, 1));
          }
  
          $server['p'][$i]['time'] = Helper::lgslTime(ord(lgsl_cut_byte($buffer, 1)) * 60);
        }
      }
      if ($response_flag & 0x00200000) {
        $team_total = ord(lgsl_cut_byte($buffer, 1));
  
        if ($response_flag & 0x00400000) {
          for ($i=0; $i<$team_total; $i++) { $server['t'][$i]['name'] = lgsl_cut_string($buffer); }
        }
        if ($response_flag & 0x00800000) {
          for ($i=0; $i<$team_total; $i++) { $server['t'][$i]['color'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l"); }
        }
        if ($response_flag & 0x01000000) {
          for ($i=0; $i<$team_total; $i++) { $server['t'][$i]['score'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s"); }
        }
  
        for ($i=0; $i<$server['s']['players']; $i++) {
          if ($server['t'][$i]['name']) { $server['p'][$i]['team'] = $server['t'][$i]['name']; }
        }
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_28() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://doomutils.ucoz.com
  
      $this->_fp_write("\xA3\xDB\x0B\x00"."\xFC\xFD\xFE\xFF"."\x01\x00\x00\x00"."\x21\x21\x21\x21");
  
      $buffer = $this->_fp_read(4096);
  
      if (!$buffer) { return FALSE; }
  
      //---------------------------------------------------------+
  
      $response_status  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l"); if ($response_status != "5560022") { return FALSE; }
      $response_version = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
      $response_time    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
  
      $server['e']['invited']    = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['version']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
      $server['s']['name']       = lgsl_cut_string($buffer);
      $server['s']['players']    = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['map']        = lgsl_cut_string($buffer);
  
      $pwad_total = ord(lgsl_cut_byte($buffer, 1));
  
      for ($i=0; $i<$pwad_total; $i++) {
        $server['e']['pwads'] .= lgsl_cut_string($buffer)." ";
        $pwad_optional         = ord(lgsl_cut_byte($buffer, 1));
        $pwad_alternative      = lgsl_cut_string($buffer);
      }
  
      $server['e']['gametype']   = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['game']       = lgsl_cut_string($buffer);
      $server['e']['iwad']       = lgsl_cut_string($buffer);
      $iwad_altenative           = lgsl_cut_string($buffer);
      $server['e']['skill']      = ord(lgsl_cut_byte($buffer, 1)) + 1;
      $server['e']['wadurl']     = lgsl_cut_string($buffer);
      $server['e']['email']      = lgsl_cut_string($buffer);
      $server['e']['dmflags']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
      $server['e']['dmflags2']   = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
      $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['inviteonly'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['players']    = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['playersmax'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['timelimit']  = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S") * 60);
      $server['e']['timeleft']   = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S") * 60);
      $server['e']['fraglimit']  = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
      $server['e']['gravity']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f");
      $server['e']['aircontrol'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f");
      $server['e']['playersmin'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['removebots'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['voting']     = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['serverinfo'] = lgsl_cut_string($buffer);
      $server['e']['startup']    = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
  
      for ($i=0; $i<$server['s']['players']; $i++) {
        $server['p'][$i]['name']      = lgsl_cut_string($buffer);
        $server['p'][$i]['score']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
        $server['p'][$i]['death']     = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
        $server['p'][$i]['ping']      = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S");
        $server['p'][$i]['time']      = Helper::lgslTime(Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "S") * 60);
        $server['p'][$i]['bot']       = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$i]['spectator'] = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$i]['team']      = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$i]['country']   = lgsl_cut_byte($buffer, 2);
      }
  
      $team_total                = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['pointlimit'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
      $server['e']['teamdamage'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "f");
  
      for ($i=0; $i<$team_total; $i++) { // RETURNS 4 TEAMS BUT IGNORE THOSE NOT IN USE
        $server['t']['team'][$i]['name']  = lgsl_cut_string($buffer);
        $server['t']['team'][$i]['color'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 4), "l");
        $server['t']['team'][$i]['score'] = Helper::lgslUnpack(lgsl_cut_byte($buffer, 2), "s");
      }
  
      for ($i=0; $i<$server['s']['players']; $i++) {
        if ($server['t'][$i]['name']) { $server['p'][$i]['team'] = $server['t'][$i]['name']; }
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_29() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://www.cs2d.com/servers.php
  
      if ($this->_lgsl_need['s'] || $this->_lgsl_need['e']) {
        $this->_lgsl_need['s'] = FALSE;
        $this->_lgsl_need['e'] = FALSE;
  
				$getPacket = function() {
					$this->_fp_write("\x01\x00\x03\x10\x21\xFB\x01\x75\x00");
					$buffer = $this->_fp_read();
					return $buffer;
				};
        $buffer = $getPacket();
				if (!$buffer) { 
					$buffer = $getPacket();
				}
				if (!$buffer) { return FALSE; }
  
        $buffer->skip(4); // REMOVE HEADER
  
        $server['e']['bit_flags']  = $buffer->cutByteOrd() - 48;
        $server['s']['name']       = $buffer->cutPascal();
        $server['s']['map']        = $buffer->cutPascal();
        $server['s']['players']    = $buffer->cutByteOrd();
        $server['s']['playersmax'] = $buffer->cutByteOrd();
        $server['e']['gamemode']   = $buffer->cutByteOrd();
        $server['e']['bots']       = $buffer->cutByteOrd();
  
        $server['s']['password']        = (int)($server['e']['bit_flags'] & 1);
        $server['e']['registered_only'] = (int)($server['e']['bit_flags'] & 2);
        $server['e']['fog_of_war']      = (int)($server['e']['bit_flags'] & 4);
        $server['e']['friendlyfire']    = (int)($server['e']['bit_flags'] & 8);
				unset($server['e']['bit_flags']);
      }
  
      if ($this->_lgsl_need['p']) {
        $this->_lgsl_need['p'] = FALSE;
  
        $this->_fp_write("\x01\x00\xFB\x05");
        $buffer = $this->_fp_read();
  
        if ($buffer) {
					$buffer->skip(4); // REMOVE HEADER
		
					$player_total = $buffer->cutByteOrd();
		
					for ($i=0; $i < $player_total; $i++) {
						$server['p'][$i]['pid']    = $buffer->cutByteOrd();
						$server['p'][$i]['name']   = $buffer->cutPascal();
						$server['p'][$i]['team']   = $buffer->cutByteOrd();
						$server['p'][$i]['score']  = $buffer->cutByteUnpack(4, "l");
						$server['p'][$i]['deaths'] = $buffer->cutByteUnpack(4, "l");
					}
				}
      }
  
      //---------------------------------------------------------+
      $this->_server->from_array($server);
      return TRUE;
    }
    public function lgsl_query_30() {
      $server = $this->_server->to_array();
      //---------------------------------------------------------+
      //  REFERENCE: http://blogs.battlefield.ea.com/battlefield_bad_company/archive/2010/02/05/remote-administration-interface-for-bfbc2-pc.aspx
      //  THIS USES TCP COMMUNICATION
  
      if ($this->_lgsl_need['s'] || $this->_lgsl_need['e']) {
        $this->_fp_write("\x00\x00\x00\x00\x1B\x00\x00\x00\x01\x00\x00\x00\x0A\x00\x00\x00serverInfo\x00");
      } elseif ($this->_lgsl_need['p']) {
        $this->_fp_write("\x00\x00\x00\x00\x24\x00\x00\x00\x02\x00\x00\x00\x0B\x00\x00\x00listPlayers\x00\x03\x00\x00\x00all\x00");
      }
  
      //---------------------------------------------------------+
  
      $buffer = $this->_fp_read();
      if (!$buffer) { return FALSE; }
  
			$buffer->skip(4);
      $length = $buffer->cutByteUnpack(4, "L");
  
      while ($buffer->length() < $length) {
        $packet = $this->_fp_read();
        if ($packet) { $buffer->add($packet); } else { break; }
      }
  
      //---------------------------------------------------------+
  
      $buffer->skip(4); // REMOVE HEADER
  
      $response_type = $buffer->cutPascal(4, 0, 1);
  
      if ($response_type != "OK") { return FALSE; }
  
      //---------------------------------------------------------+
  
      if ($this->_lgsl_need['s'] || $this->_lgsl_need['e']) {
        $server['s']['name']            = $buffer->cutPascal(4, 0, 1);
        $server['s']['players']         = $buffer->cutPascal(4, 0, 1);
        $server['s']['playersmax']      = $buffer->cutPascal(4, 0, 1);
        $server['e']['gamemode']        = $buffer->cutPascal(4, 0, 1);
        $server['s']['map']             = $buffer->cutPascal(4, 0, 1);
        $server['e']['score_attackers'] = $buffer->cutPascal(4, 0, 1);
        $server['e']['score_defenders'] = $buffer->cutPascal(4, 0, 1);
  
        // CONVERT MAP NUMBER TO DESCRIPTIVE NAME
  
        $server['e']['level'] = $server['s']['map'];
        $map_check = strtolower($server['s']['map']);
				$names = [
					"mp_001" => "Panama Canal",
					"mp_002" => "Valparaiso",
					"mp_003" => "Laguna Alta",
					"mp_004" => "Isla Inocentes",
					"mp_005" => "Atacama Desert",
					"mp_006" => "Arica Harbor",
					"mp_007" => "White Pass",
					"mp_008" => "Nelson Bay",
					"mp_009" => "Laguna Presa",
					"mp_012" => "Port Valdez"
				];
				
				foreach ($names as $key => $value) {
					if (strpos($map_check, $key) !== FALSE) {
						$server['s']['map'] = $value;
						break;
					}
				}
				$this->set_requested('se');
      }
  
      //---------------------------------------------------------+
  
      elseif ($this->_lgsl_need['p']) {
        $field_total = $buffer->cutPascal(4, 0, 1);
        $field_list  = [];
  
        for ($i=0; $i<$field_total; $i++) {
          $field_list[] = strtolower($buffer->cutPascal(4, 0, 1));
        }
  
        $player_squad = ["","Alpha","Bravo","Charlie","Delta","Echo","Foxtrot","Golf","Hotel"];
        $player_team  = ["","Attackers","Defenders"];
        $player_total = $buffer->cutPascal(4, 0, 1);
  
        for ($i=0; $i<$player_total; $i++) {
          foreach ($field_list as $field) {
            $value = $buffer->cutPascal(4, 0, 1);
  
            switch ($field) {
              case "clantag": $server['p'][$i]['name']  = $value;                                                                             break;
              case "name":    $server['p'][$i]['name']  = empty($server['p'][$i]['name']) ? $value : "[{$server['p'][$i]['name']}] {$value}"; break;
              case "teamid":  $server['p'][$i]['team']  = isset($player_team[$value]) ? $player_team[$value] : $value;                        break;
              case "squadid": $server['p'][$i]['squad'] = isset($player_squad[$value]) ? $player_squad[$value] : $value;                      break;
              default:        $server['p'][$i][$field]  = $value;                                                                             break;
            }
          }
        }
				$this->set_requested('p');
      }
  
      //---------------------------------------------------------+
			$this->_server->from_array($server);
      if ($this->_lgsl_need['s'] || $this->_lgsl_need['e'] || $this->_lgsl_need['p']) {
				return call_user_func([$this, "lgsl_query_30"]);
			}
			
      return TRUE;
    }
    public function lgsl_query_40() { // Farming Simulator 2019
			$server = $this->_server->to_array();
			$this->_fp_write("http://{$server['b']['ip']}:{$server['b']['q_port']}/index.html");
			$buffer = $this->_fp_read_raw();
			if (!$buffer) return FALSE;
			$this->set_requested();
      preg_match('/<h2>Login to [\w\d\s\/\\:()&@"\'-]+<\/h2>/', $buffer, $name);
      $server['s']['name']        = substr($name[0], 12, strlen($name[0])-17);
      $this->_server->from_array($server);
      return strpos($buffer, 'status-indicator online') !== FALSE;
    }
    //---------------------------------------------------------+

    public function lgsl_cut_byte(&$buffer, $length) {
      $string = substr($buffer, 0, $length);
      $buffer = substr($buffer, $length);
      return $string;
    }
    public function lgsl_cut_string(&$buffer, $start_byte = 0, $end_marker = "\x00") {
      $buffer = substr($buffer, $start_byte);
      $length = strpos($buffer, $end_marker);
      if ($length === FALSE) { $length = strlen($buffer); }
      $string = substr($buffer, 0, $length);
      $buffer = substr($buffer, $length + strlen($end_marker));
      return $string;
    }
  }

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
	abstract class Query {
    protected const NO_RESPOND = 0;
    protected const SUCCESS = 1;
    protected const WITH_ERROR = 2;
    protected $_server, $_fp, $_need;
    protected $_data = [];
		public function __construct(&$server, &$fp, &$need) {
      $this->_server = $server;
      $this->_fp = $fp;
      $this->_need = $need;
      return $this;
    }
    public function need($key): bool {
      if ($this->_need[$key]) {
        $this->_need[$key] = false;
        return true;
      }
      return false;
    }
    public function process() {return 0;}
    public function execute(): int {
      $time = microtime();
      $status = $this->process();
      $this->_data['o']['time_execution'] = $time - microtime();
      if ($status !== $this::NO_RESPOND) {
        if ($status === $this::SUCCESS) {
          // clear error
        }
        if ($status === $this::WITH_ERROR) {
          $this->_data['e']['_error'] = $this->_data['e']['_error'] ?? "Probably protocol mistake";
        }
        $this->_server->updateValues($this->_data);
      }
      return $status;
    }
	}
  abstract class QuerySocket extends Query {
    protected $packets = [];
    public function fetch($line = 0, $length = 4096) {
      $this->_fp->write($this->packets[$line]);
      return $this->_fp->read($length);
    }
  }
  abstract class QueryJson extends Query {
    public function fetch(string $url): array {
      $this->_fp->write($url);
      return $this->_fp->readJson();
    }
  }
  class QueryStatus extends QuerySocket { // Only status
    public function process(): int {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;		
      $this->_data['s']['name'] = Protocol::lgslList($this->_server->get_type())[1] . " Server";
      $this->postProcess($buffer);
      return $this::SUCCESS;
    }
    public function postProcess(&$buffer) {}
  }
	
  class Query32 extends QuerySocket { // Plain Sight
    protected $packets = ["\x05\x00\x00\x01\x0A"];
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      $buffer->skip(5); // REMOVE HEADER
      $this->_data['s']['name']    = $buffer->cutPascal();
      $this->_data['s']['map']     = $buffer->cutPascal();
      $this->_data['s']['players'] = $buffer->cutByteOrd();
      return $this::SUCCESS;
    }
  }
  class Query33 extends Query { // TeamSpeak 1 / 3 / TeaSpeak
    public function read($length = 4096) {
      return $this->_fp->read($length);
    }
    public function fetch($packet = "", $length = 4096) {
      $this->_fp->write($packet);
      return $this->read($length);
    }
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      if ($this->_server->get_type() === 'teaspeak') {
        if ($buffer->has('TeaSpeak') && $this->_fp->read()->has('TeaSpeak')) {
          return $this::WITH_ERROR;
        }
      } else {
        if (!$buffer->has('TS')) {
          return $this::WITH_ERROR;
        }
      }
      $ver = $this->_server->get_type() === Protocol::TS ? 0 : 1;
      $param = [
        ['sel ', 'si', "\r\n", 'pl'],
        ['use port=', 'serverinfo', ' ', 'clientlist -country', 'channellist -topic']
      ];
      if ($ver) { $this->fetch(); }
      $buffer = $this->fetch("{$param[$ver][0]}{$this->_server->get_c_port()}\n"); // select virtualserver
      if (!$buffer) return $this::WITH_ERROR;		
      if (strtoupper($buffer->get(-4, -2)) != 'OK') { return $this::WITH_ERROR; }
      
      $getPackets = function($message) {
        $buffer = $this->fetch($message);
        if (!$buffer || $buffer->get(0, 5) === 'error') { return $this::WITH_ERROR; }
        while (strtoupper($buffer->get(-4, -2)) != 'OK') {
          $part = $this->read();
          if ($part && $part->get(0, 5) != 'error') { $buffer->add($part); } else { break; }
        }
        return $buffer;
      };

      $buffer = $getPackets("{$param[$ver][1]}\n"); // request serverinfo
      while ($val = $buffer->cutString(7 + 7 * $ver, $param[$ver][2])) {
        $key = Helper::lgslCutString($val, 0, '='); $items[$key] = $val;
      }
      if (!isset($items['name'])) return $this::WITH_ERROR;
      $this->_data['s']['name']         = $ver ? Helper::lgslUnescape($items['name']) : $items['name'];
      $this->_data['s']['map']          = $this->_data['b']['type'];
      $this->_data['s']['players']      = (int) ($items[$ver ? 'clientsonline' : 'currentusers']);
      $this->_data['s']['playersmax']   = (int) ($items[$ver ? 'maxclients' : 'maxusers']);
      $this->_data['s']['password']     = (int) ($items[$ver ? 'flag_password' : 'password']);
      $this->_data['e']['platform']     = $items['platform'];
      $this->_data['e']['motd']         = Helper::lgslParseColor($ver ? Helper::lgslUnescape($items['welcomemessage']) : $items['welcomemessage'], 'bbcode');
      $this->_data['e']['uptime']       = Helper::lgslTime($items['uptime']);
      $this->_data['e']['banner']       = Helper::lgslUnescape($items['hostbanner_url']);
      $this->_data['e']['channelscount']= $items[$ver ? 'channelsonline' : 'currentchannels'];
      if ($ver) { $this->_data['e']['version'] = Helper::lgslUnescape($items['version']); }

      if ($this->need('p') && $this->_data['s']['players'] > 0) {
        $buffer = $getPackets("{$param[$ver][3]}\n"); // request playerlist

        $i = 0;
        if ($ver) {
          while ($items = $buffer->cutString(0, '|')) {
            Helper::lgslCutString($items, 0, 'e='); $name = Helper::lgslCutString($items, 0, ' ');
            if (substr($name, 0, 15) === 'Unknown\sfrom\s') { continue; }
            $this->_data['p'][$i]['name'] = Helper::lgslUnescape($name); Helper::lgslCutString($items, 0, 'ry');
            $this->_data['p'][$i]['country'] = substr($items, 0, 1) === '=' ? substr($items, 1, 2) : ''; $i++;
          }
        } else {
          $buffer->skip(89, 4);
          while ($items = $buffer->cutString(0, "\r\n")) {
            $items = explode("\t", $items);
            $this->_data['p'][$i]['name'] = substr($items[14], 1, -1);
            $this->_data['p'][$i]['ping'] = $items[7];
            $this->_data['p'][$i]['time'] = Helper::lgslTime($items[8]); $i++;
          }
        }
      }

      if ($this->need('e') && $ver) {
        $buffer = $getPackets("{$param[$ver][4]}\n"); // request channellist
        $lvl = [];
        $channels = "<style>.gray{color:gray;}</style><div style='text-align: left !important;'>";
        while ($items = $buffer->cutString(0, '|')) {
          $cid = str_pad(Helper::lgslCutString($items, 4, ' '), 5, '0', STR_PAD_LEFT);
          $pid = str_pad(Helper::lgslCutString($items, 4, ' '), 5, '0', STR_PAD_LEFT);
          Helper::lgslCutString($items, 0, 'e=');
          $name = Helper::lgslCutString($items, 0, ' ');
          $chars = "";
          if ((int) $pid == 0) {
            $lvl = [$cid];
          } else {
            $i = count($lvl)-1;
            while ($i > -1) {
              if ($lvl[$i] == $pid) {
                $lvl = array_slice($lvl, 0, $i+1);
                $lvl[] = $cid;
                $chars = str_repeat("|--", $i+1);
                break;
              }
              $i--;
            }
            if ($i == -1)
              $lvl = [$cid];
          }
          $channels .= "<span class='gray'>{$chars}</span> " . preg_replace("/(\[\*?[clr]? ?spacer\d{0,10}\])/", "", Helper::lgslUnescape($name)) . "\n";
        }
        $this->_data['e']['channels'] = "{$channels}</div>";
      }
      return $this::SUCCESS;
    }
  }
  class Query34 extends QueryJson { // Rage:MP
    public function process() {
      $buffer = $this->fetch("https://cdn.rage.mp/master/");
      if (!$buffer) return $this::NO_RESPOND;
      if ($value = $buffer["{$this->_server->get_ip()}:{$this->_server->get_c_port()}"]) {
        $this->_data['s']['name']       = $value['name'];
        $this->_data['s']['map']        = "RageMP";
        $this->_data['s']['players']    = $value['players'];
        $this->_data['s']['playersmax'] = $value['maxplayers'];
        $this->_data['e']['url']        = $value['url'];
        $this->_data['e']['peak']       = $value['peak'];
        $this->_data['s']['mode']       = $value['gamemode'];
        $this->_data['e']['lang']       = $value['lang'];
        return $this::SUCCESS;
      }
      return $this::NO_RESPOND;
    }
  }
  class Query35 extends QueryJson { // FiveM / RedM
    public function process() {
      $buffer = $this->fetch("http://{$this->_server->get_ip()}:{$this->_server->get_q_port()}/dynamic.json");
      if (!$buffer) return $this::NO_RESPOND;
      $this->_data['s']['name'] = Helper::lgslParseColor($buffer['hostname'], 'fivem');
      $this->_data['s']['players'] = $buffer['clients'];
      $this->_data['s']['playersmax'] = $buffer['sv_maxclients'];
      $this->_data['s']['map'] = $buffer['mapname'];
      if ($this->_data['s']['map'] == 'redm-map-one') {
        $this->_data['s']['game'] = 'redm';
      }
      $this->_data['s']['mode'] = $buffer['gametype'];
      $this->_data['e']['version'] = $buffer['iv'];

      if ($this->need('p')) {
        //$this->set_requested('p');
        $buffer = $this->fetch("http://{$this->_server->get_ip()}:{$this->_server->get_q_port()}/players.json");

        foreach($buffer as $key => $value) {
          $this->_data['p'][$key]['name'] = $value['name'];
          $this->_data['p'][$key]['ping'] = $value['ping'];
        }
      }
      return $this::SUCCESS;
    }
  }
  class Query36 extends QueryJson { // Discord
    public function process() {
      $buffer = $this->fetch("https://discord.com/api/v9/invites/{$this->_server->get_ip()}?with_counts=true");
      if (!$buffer) return $this::NO_RESPOND;
      if (isset($buffer['message'])) {
        $this->_data['e']['_error_fetching_info'] = $buffer['message'];
        return $this::NO_RESPOND;
      }
      //$this->set_requested('se');
      $this->_data['s']['map'] = 'discord';
      $this->_data['s']['name'] = $buffer['guild']['name'];
      $this->_data['s']['players'] = $buffer['approximate_presence_count'];
      $this->_data['s']['playersmax'] = $buffer['approximate_member_count'];
      $this->_data['e']['id'] = $buffer['guild']['id'];
      $this->_data['e']['expires_at'] = $buffer['expires_at'] ?? LGSL::NONE;
      $this->_data['e']['members'] = $buffer['approximate_member_count'];
      $this->_data['e']['premium_subscriptions'] = $buffer['guild']['premium_subscription_count'];
      if($buffer['guild']['description']) {
        $this->_data['e']['description'] = $buffer['guild']['description'];
      }
      if (isset($buffer['guild']['welcome_screen'])) {
        if ($buffer['guild']['welcome_screen']['description']) $this->_data['e']['description'] = $buffer['guild']['welcome_screen']['description'];
        if ($buffer['guild']['welcome_screen']['welcome_channels'])
        $this->_data['e']['welcome_channels'] = array_reduce($buffer['guild']['welcome_screen']['welcome_channels'], function($a, $c) {
          return "{$a}\n{$c['emoji_name']} {$c['description']}";
        }, "");
      }
      $this->_data['e']['features'] = implode(', ', $buffer['guild']['features'] ?? []);
      $this->_data['e']['nsfw'] = (int) $buffer['guild']['nsfw'];
      if (isset($buffer['inviter'])) {
        $this->_data['e']['inviter'] = "{$buffer['inviter']['username']}#{$buffer['inviter']['discriminator']}";
      }

      if ($this->need('p')) {
        //$this->set_requested('p');
        $buffer = $this->fetch("https://discordapp.com/api/guilds/{$this->_server->getE('id')}/widget.json");

        if (isset($buffer['code']) and $buffer['code'] == 0) {
          $this->_data['e']['_error_fetching_users'] = $buffer['message'];
        }

        if (isset($buffer['channels'])) {
          foreach ($buffer['channels'] as $key => $value) {
            $this->_data['e']["channel{$key}"] = $value['name'];
          }
        }

        if (isset($buffer['members'])) {
          foreach ($buffer['members'] as $key => $value) {
            $this->_data['p'][$key]['name'] = $value['username'];
            $this->_data['p'][$key]['status'] = $value['status'];
            $this->_data['p'][$key]['game'] = isset($value['game']) ? $value['game']['name'] : LGSL::NONE;
          }
        }
      }
      return $this::SUCCESS;
    }
  }
  class Query37 extends QueryJson { // SCUM
    public function process() {
      $buffer = $this->fetch("https://api.hellbz.de/scum/api.php?address={$this->_server->get_ip()}&port={$this->_server->get_c_port()}");
      if (!$buffer || !$buffer['success'] || $buffer['servers'] == 0) return $this::NO_RESPOND;
      $this->_data['s']['name']        = $buffer['data'][0]['name'];
      $this->_data['s']['map']         = "SCUM";
      $this->_data['s']['players']     = $buffer['data'][0]['players'];
      $this->_data['s']['playersmax']  = $buffer['data'][0]['players_max'];
      $this->_data['e']['time']        = $buffer['data'][0]['time'];
      $this->_data['e']['version']     = $buffer['data'][0]['version'];
      return $this::SUCCESS;
    }
  }
  class Query38 extends QueryJson { // Terraria
    public function process() {
      $buffer = $this->fetch("http://{$this->_server->get_ip()}:{$this->_server->get_q_port()}/v2/server/status?players=true");
      if (!$buffer) return $this::NO_RESPOND;
      if ($buffer['status'] != '200') {
        $this->_data['e']['_error2']    = $buffer['error'];
        return $this::WITH_ERROR;
      }
      $this->_data['s']['name']        = $buffer['name'];
      $this->_data['s']['map']         = $buffer['world'];
      $this->_data['s']['players']     = $buffer['playercount'];
      $this->_data['s']['playersmax']  = $buffer['maxplayers'];
      $this->_data['s']['password']    = $buffer['serverpassword'];
      $this->_data['e']['uptime']      = $buffer['uptime'];
      $this->_data['e']['version']     = $buffer['serverversion'];
      $this->_data['e']['world']       = $buffer['world'];
      return $this::SUCCESS;
    }
  }
  class Query39 extends QuerySocket {  // Mafia 2 MP
    protected $packets = ["M2MPi"];
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      $buffer->skip(4);
      $this->_data['s']['name']        = $buffer->cutPascal(1, -1);
      $this->_data['s']['map']         = "Empire Bay";
      $this->_data['s']['players']     = $buffer->cutPascal(1, -1);
      $this->_data['s']['playersmax']  = $buffer->cutPascal(1, -1);
      $this->_data['e']['gamemode']    = $buffer->cutPascal(1, -1);
      return $this::SUCCESS;
    }
  }
  class Query40 extends QueryJson { // ECO
    public function process() {
      $buffer = $this->fetch("http://{$this->_server->get_ip()}:{$this->_server->get_q_port()}/info");
      if (!$buffer) return $this::NO_RESPOND;
      $this->_data['s']['name']        = strip_tags($buffer['Description']);
      $this->_data['s']['players']     = $buffer['OnlinePlayers'];
      $this->_data['s']['playersmax']  = $buffer['TotalPlayers'];
      $this->_data['s']['password']    = (int) $buffer['HasPassword'];
      
      if ($this->_data['s']['players']) {
        foreach ($buffer['OnlinePlayersNames'] as $key => $value) {
          $this->_data['p'][$key]['name'] = $value;
        }
      }
      unset($buffer['Description'], $buffer['OnlinePlayers'], $buffer['OnlinePlayersNames']);
      $this->_data['e'] = $buffer;
      $this->_data['e']['TimeSinceStart']    = Helper::lgslTime($buffer['TimeSinceStart'] + 3600);
      $this->_data['e']['HasMeteor']    =  Helper::bool($buffer['HasMeteor']);
      if ($buffer['HasMeteor']) $this->_data['e']['TimeLeft'] = Helper::lgslTime($buffer['TimeLeft']);
      return $this::SUCCESS;
    }
  }
  /* Query 41-49 */
  class Query41 extends QueryStatus {  // Satisfactory
    protected $packets = ["\x00\x00\xd6\x9c\x28\x25\x00\x00\x00\x00"];
    public function postProcess(&$buffer) {
      $buffer->skip(11);
      $version = $buffer->cutByteUnpack(1, "H*");
      $version = $buffer->cutByteUnpack(1, "H*") . $version;
      $version = $buffer->cutByteUnpack(1, "H*") . $version;
      $this->_data['e']['version'] = hexdec($version);
    }
  }
  class Query42 extends QuerySocket {  // Factorio
    protected $packets = ["\x30"];
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      $packetLength = $buffer->length();
      while ($packetLength >= 504) {
        $packet = substr($this->_fp->_read_raw(512), 4);
        $packetLength = strlen($packet);
        if (!$packet) break;
        $buffer->add($packet);
      }
      if ($buffer->length() > 508) $buffer->skip(3);
      $buffer->skip(13);
      $this->_data['s']['name']        = Helper::lgslParseColor($buffer->cutPascal(), "factorio");
      $this->_data['e']['version']     = "{$buffer->cutByteOrd()}.{$buffer->cutByteOrd()}.{$buffer->cutByteOrd()}";
      $this->_data['e']['build']       = $buffer->cutByteUnpack(2, "S");
      $desc = $buffer->cutByteOrd();
      $desc = $desc === 255 ? $buffer->cutByteUnpack(2, "S") + 2 : $desc;
      $this->_data['e']['description'] = Helper::lgslParseColor($buffer->cutByte($desc), "factorio");
      $maxplayers = $buffer->cutByteUnpack(2, "S");
      $this->_data['s']['playersmax']  = $maxplayers ? $maxplayers : 9999;
      $this->_data['e']['time']        = Helper::lgslTime($buffer->cutByteUnpack(2, "S") * 60);
      $buffer->skip(2);
      $this->_data['s']['password']    = $buffer->cutByteOrd();
      $buffer->skip(1);
      $buffer->skip($buffer->cutByteOrd());
      $this->_data['e']['public']      = Helper::bool($buffer->cutByteOrd());
      $buffer->skip(1);
      $this->_data['e']['lan']         = Helper::bool($buffer->cutByteOrd());

      $this->_data['e']['mods']        = "";
      $gamemodes = $buffer->cutByteOrd();
      for ($i = 0; $i < $gamemodes; $i++) {
        $this->_data['e']['mods']      .= "{$buffer->cutPascal()} ({$buffer->cutByteOrd()}.{$buffer->cutByteOrd()}.{$buffer->cutByteOrd()})\n";
        $buffer->skip(4);
      }

      $this->_data['e']['tags']        = "";
      $tags = $buffer->cutByteOrd();
      for ($i = 0; $i < $tags; $i++) {
        $tag = $buffer->cutByteOrd();
        $tag = $tag === 255 ? $buffer->cutByteUnpack(2, "S") + 2 : $tag;
        $this->_data['e']['tags'] .= Helper::lgslParseColor($buffer->cutByte($tag), "factorio")."\n";
      }

      $players = $buffer->cutByteOrd();
      for ($i = 0; $i < $players; $i++) {
        $this->_data['p'][$i]['name']  = $buffer->cutPascal();
        if (strlen($this->_data['p'][$i]['name']) == 0) $this->_data['p'][$i]['name'] = '*unknown*';
      }
      $this->_data['s']['players']     = count($this->_data['p']);
      return $this::SUCCESS;
    }
  }
  class Query43 extends QuerySocket {  // Mumble
    protected $packets = ["\x00\x00\x00\x00\x01\x02\x03\x04LGSL"];
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      $this->_data['s']['name']    = "Mumble Server";
      $this->_data['s']['map']     = "Mumble";
      $buffer->skip(1);
      $this->_data['e']['version'] = "{$buffer->cutByteOrd()}.{$buffer->cutByteOrd()}.{$buffer->cutByteOrd()}";
      $buffer->skip(8); // challenge
      $this->_data['s']['players'] = $buffer->cutByteUnpack(4, "N");
      $this->_data['s']['playersmax'] = $buffer->cutByteUnpack(4, "N");
      return $this::SUCCESS;
    }
  }
  class Query44 extends QuerySocket {  // Cryofall (by tltneon)
    protected $packets = [
      "\x05\x0b\x00\x00\x00\x86\x76\x41\x31\xa0\x87\xdb\x08\x10\x02\x00\x55\xf0\x86\xff\xde\x58\x00\x00\x00\x00\x00\x00\x00\x00\x08\x00\x00\x00\x43\x72\x79\x6f\x46\x61\x6c\x6c",
      "\x0c\x0a\x00\x01\x00\x00\x02\x00\x05\x60\x02\xe8\x03\x07\x00\x00\x06\x5f\x02\x20\x4e\x01",
      "\x01\x00\x00\x02\x00\x05\x60\x02\xe8\x03",
      "\x00\x06\x61\x02\x20\x4e\x02"
    ];
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      $buffer = $this->fetch(1);
      $buffer = $this->fetch(2);
      if ($buffer->length() < 12) {
        $buffer = $this->fetch(3);
      }
      $this->_data['s']['map'] = "World";
      if ($buffer->length() < 12) {
        $this->_data['s']['name'] = $this->_data['s']['name'] ?? "Cryofall server";
        $this->_data['e']['_error'] = "Server working but not sends data";
        return $this::WITH_ERROR;
      }
      $buffer->skip(30);
      $this->_data['s']['name'] = $buffer->cutByte($buffer->cutByteUnpack(2, "S"));
      $buffer->skip(2);
      $this->_data['e']['version'] = $buffer->cutByte($buffer->cutByteUnpack(2, "S"));
      $this->_data['s']['players'] = $buffer->cutByteUnpack(2, "S");
      $this->_data['s']['playersmax'] = $buffer->cutByteUnpack(2, "S");
      $buffer->skip(3);
      $this->_data['e']['description'] = Helper::lgslParseColor($buffer->cutByte($buffer->cutByteUnpack(2, "S")), 'factorio');
      $buffer->skip($buffer->cutByteUnpack(2, "S") - 8);
      $this->_data['e']['GUID'] = '';
      for ($i = 0; $i < 16; $i++) {
        $this->_data['e']['GUID'] = bin2hex($buffer->cutByte()) . $this->_data['e']['GUID'];
      }
      $this->_data['e']['GUID'] = strtoupper($this->_data['e']['GUID']);
      $buffer->skip(9);
      /*$mods = $buffer->cutByteOrd();
      for ($i = 0; $i < $mods; $i++) {
        $this->_data['e']["mod{$i}"] = "{$buffer->cutByte((int) $buffer->cutByteUnpack(2, "S"))} v{$buffer->cutByte((int) $buffer->cutByteUnpack(2, "S"))} - {$buffer->cutByte((int) $buffer->cutByteUnpack(2, "S"))}";
        $buffer->skip(2);
      }*/
      $mods = $buffer->cutByteOrd();
      for ($i = 0; $i < $mods; $i++) {
        $this->_data['e']["option{$i}"] = $buffer->cutByte($buffer->cutByteUnpack(2, "S"));
      }
      $this->_data['e']["community_server"] = $buffer->cutByteOrd();
      $this->_data['e']["no_client_mods"] = $buffer->cutByteOrd();
      return $this::SUCCESS;
    }
  }
	class Query45 extends QuerySocket {  // GTA / Mafia Connected
    protected $packets = ["\xFF\xFFUGP\x00\x01\x00", "\xFF\xFFUGP\x00\x01\x01\x09\x6c\x07"];
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      $buffer = $this->fetch(1);
      $buffer->skip(8);
			$games = [1 => 'iii', 2 => 'vc', 3 => 'sa', 5 => 'iv', 6 => 'iv_eflc', 10 => 'mafia'];
      $this->_data['s']["game"] = $games[$buffer->cutByteOrd()];
      $buffer->skip(2);
      $this->_data['s']["name"] = $buffer->cutPascal();
      $this->_data['s']["mode"] = $buffer->cutPascal();
      $this->_data['s']["map"] = 'Default';
      $this->_data['s']['players'] = $buffer->cutByteOrd();
      $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
			$count = $buffer->cutByteOrd();
      for ($i = 0; $i < $count; $i++) {
        $this->_data['e'][$buffer->cutPascal()] = $buffer->cutPascal();
      }
      return $this::SUCCESS;
    }
  }
  class Query46 extends Query { // SRB2
    private function checksum($buf) {
      $n = strlen($buf);
      $c = 0x1234567;
      for ($i = 0; $i < $n; ++$i)
        $c += ord($buf[$i]) * ($i + 1);
      return $c;
    }
    public function process() {
      $buf = pack('xxCx', 12) . pack('x5');
      $this->_fp->write(pack('V', $this->checksum($buf)) . $buf);
      $buffer = $this->_fp->read();
      if (!$buffer) return $this::NO_RESPOND;
      $buffer->skip(10);
      $this->_data['e']["application"] = $buffer->cutByte(16);
      $this->_data['e']["version"] = $buffer->cutByteOrd();
      $this->_data['e']["subversion"] = $buffer->cutByteOrd();
      $this->_data['s']['players'] = $buffer->cutByteOrd();
      $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
      $buffer->skip(1);
      $this->_data['s']["mode"] = $buffer->cutByte(24);
      $this->_data['e']['modifiedgame'] = $buffer->cutByteOrd();
      $this->_data['e']['cheatsenabled'] = $buffer->cutByteOrd();
      $this->_data['e']['dedicated'] = $buffer->cutByteOrd();
      $this->_data['e']['lotsofaddons'] = $this->_data['e']['dedicated'] & 0x20;
      $this->_data['e']['dedicated'] = $this->_data['e']['dedicated'] & 0x40;
      $this->_data['e']['fileneedednum'] = $buffer->cutByteOrd();
      $buffer->skip(8);
      $this->_data['s']["name"] = $buffer->cutByte(32);
      $this->_data['e']["mapname"] = $buffer->cutByte(8);
      $this->_data['s']["map"] = $buffer->cutByte(33);
      
      $buffer = $this->_fp->read();
      $buffer->skip(44);
      for ($i = 0; $i < $this->_data['s']['players']; $i++) {
        $buffer->skip(1);
        $this->_data['p'][$i]['name'] = $buffer->cutByte(26);
        $buffer->skip(9);
      }
      return $this::SUCCESS;
    }
  }
  class Query47 extends QuerySocket { // Necesse (by tltneon)
    protected $packets = ["\x00\x00\x01\x00\x00\x17\x7f\xd3\x96"];
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      $this->_data['s']["name"] = "Necesse server";
      $this->_data['s']["map"] = "World";
      $buffer->skip(15);
      $this->_data['s']['players'] = $buffer->cutByteOrd();
      $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
      $settings = $buffer->cutByteOrd();
      $this->_data['e']["allowOutsideCharacters"] = Helper::bool($settings & 64);
      $this->_data['e']["forcedPvP"] = Helper::bool($settings & 32);
      $this->_data['e']["disableMobSpawns"] = Helper::bool($settings & 16);
      $this->_data['e']["playerHunger"] = Helper::bool($settings & 8);
      $this->_data['e']["survivalMode"] = Helper::bool($settings & 4);
      $this->_data['e']["allowCheats"] = Helper::bool($settings & 2);
      $buffer->skip(5);
      $this->_data['e']["version"] = $buffer->cutPascal(1, 6);
      $difficulty = ["Casual", "Easy", "Normal", "Hard", "Brutal"];
      $this->_data['e']['difficulty'] = $difficulty[$buffer->cutByteOrd()];
      $deathPenalty = ["No penalty", "Drop materials", "Drop main inventory", "Drop full inventory", "Hardcore"];
      $this->_data['e']['deathPenalty'] = $deathPenalty[$buffer->cutByteOrd()];
      $raidFrequency = ["Often", "Occasionally", "Rarely", "Hard"];
      $this->_data['e']['raidFrequency'] = $raidFrequency[$buffer->cutByteOrd()];
      $this->_data['e']["daytime"] = $buffer->cutByteUnpack(4, "G");
      $this->_data['e']["nighttime"] = $buffer->cutByteUnpack(4, "G");
      return $this::SUCCESS;
    }
  }
  class Query48 extends QueryJson { // BeamMP
    public function process() {
      $buffer = $this->fetch("https://backend.beammp.com/servers-info");
      if (!$buffer) return $this::NO_RESPOND;
      $find = array_filter($buffer, function($k) {
        return $k['ip'] == $this->_server->get_ip() && ((int) $k['port']) == $this->_server->get_q_port();
      });
      if (!$find) return $this::NO_RESPOND;
      $find = reset($find);

      $this->_data['s']['name'] = Helper::lgslParseColor($find['sname'], '2');
      $this->_data['s']['players'] = $find['players'];
      $this->_data['s']['playersmax'] = $find['maxplayers'];
      $this->_data['s']['password'] = $find['password'];
      $this->_data['s']['map'] = $find['map'];
      $this->_data['e']['description'] = $find['sdesc'];
      $this->_data['e']['version'] = $find['version'];
      if ($this->_data['s']['players'] > 0) {
        $this->_data['p'] = array_map(function ($k) {
          return ['name' => $k];
        }, explode(';', $find['playerslist']));
      }
      return $this::SUCCESS;
    }
  }
  class Query49 extends QueryStatus {  // Windward
    protected $packets = ["\x0b\x00\x00\x00\x03\x0c\x00\x00\x00\x04LGSL\x00"];
  }

  class QueryTest extends Query {
    public function process() {
        $this->_data = [
            's' => [
                "game"       => "test_game",
                "name"       => "test_ServerNameThatsOften'Really'LongAndCanHaveSymbols<hr />ThatWill\"Screw\"UpHtmlUnlessEntitied",
                "map"        => "test_map",
                "players"    => rand(0,  16),
                "playersmax" => rand(16, 32),
                "password"   => rand(0,  1)],
            'e' => [
                "testextra1" => "normal",
                "testextra2" => 123,
                "testextra3" => time(),
                "testextra4" => "",
                "testextra5" => "<b>Setting<hr />WithHtml</b>",
                "testextra6" => "ReallyLongSettingLikeSomeMapCyclesThatHaveNoSpacesAndCauseThePageToGoReallyWideIfNotBrokenUp"],
            'p' => [
                ["name" => "Normal", "score" => "12", "ping" => "34"],
                ["name" => "\xc3\xa9\x63\x68\x6f\x20\xd0\xb8-d0\xb3\xd1\x80\xd0\xbe\xd0\xba", "score" => "56", "ping" => "78"],
                ["name" => "One&<Two>&Three&\"Four\"&'Five'", "score" => "90", "ping" => "12"],
                ["name" => "ReallyLongPlayerNameBecauseTheyAreUberCoolAndAreInFiveClans", "score" => "90", "ping" => "12"],
            ]
        ];    
        if (rand(0, 10) == 5) { $this->_data['p'] = []; } // RANDOM NO PLAYERS
        if (rand(0, 10) == 5) { return $this::NO_RESPOND; }
        return $this::SUCCESS;
    }
  }
//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
	class Buffer {
		private $_string = "";
		public function __construct(string $string) {
			$this->set($string);
		}
		public function set(string $string = ""): void {
			$this->_string = $string;
		}
		public function get(int $start = 0, int $length = 1): string {
			return substr($this->_string, $start, $length);
		}
		public function getAll(): string {
			return $this->_string;
		}
		public function add($string = ""): void {
			if (gettype($string) === "string") {
				$this->_string .= $string;
			} else {
				$this->_string .= $string->getAll();
			}
		}
		public function has(string $string): bool {
			return strpos($this->_string, $string) !== FALSE;
		}
		public function length(): int {
			return strlen($this->_string);
		}
		public function skip(int $left, int $right = null): void {
      if ($right) {
        $this->set(substr($this->_string, $left, -$right));
      } else {
        $this->set(substr($this->_string, $left));
      }
		}
		public function char(int $position): string {
			return $this->_string[$position];
		}
		public function show(): void {
			Helper::lgslShowDebugString($this->_string);
		}
		public function cutByte(int $length = 1): string {
			$string = substr($this->_string, 0, $length);
			$this->set(substr($this->_string, $length));
			return $string;
		}
		public function cutByteOrd(int $length = 1): int {
			return ord($this->cutByte($length));
		}
		public function cutByteUnpack(int $length, string $format) {
			return Helper::lgslUnpack($this->cutByte($length), $format);
		}
		public function getString(int $start = 0, string $end = "\x00"): string {
			$buffer = substr($this->_string, $start);
			$length = strpos($buffer, $end);
			if ($length === FALSE) { $length = strlen($buffer); }
			$string = substr($buffer, 0, $length);
			return $string;
		}
		public function cutString(int $start = 0, string $end = "\x00"): string {
			$this->set(substr($this->_string, $start));
			$length = strpos($this->_string, $end);
			if ($length === FALSE) { $length = $this->length(); }
			$string = substr($this->_string, 0, $length);
			$this->_string = substr($this->_string, $length + strlen($end));
			return $string;
		}
		public function cutPascal(int $start = 1, int $length_adjust = 0, int $end = 0): string {
			$length = ord(substr($this->_string, 0, $start)) + $length_adjust;
			$string = substr($this->_string, $start, $length);
			$this->_string = substr($this->_string, $start + $length + $end);
			return $string;
		}
		public static function &join(array &$array): Buffer {
			if (count($array) == 1) {
				return $array[0];
			}
			$buffer = $array[0];
			for ($i = 1; $i < count($array); $i++) {
				$buffer->add($array[$i]);
				unset($array[$i]);
			}
			return $buffer;
		}
	}
//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
	class Stream {
		private $_protocol;
		private $_stream;
		private $_server;
		public function __construct($protocol) {
			$this->_protocol = $protocol;
		}
		private function _isHttp() {
			return $this->_protocol === Protocol::HTTP;
		}
		public function open(&$server) {
      global $lgsl_config;
			if ($this->_isHttp()) {
        if (!LGSL::isEnabled("curl")) return false;
        $this->_stream = curl_init('');
        curl_setopt($this->_stream, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_stream, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->_stream, CURLOPT_CONNECTTIMEOUT, $lgsl_config['timeout']);
        curl_setopt($this->_stream, CURLOPT_TIMEOUT, 1);
        curl_setopt($this->_stream, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($this->_stream, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.9.1.4) Gecko/20091028");
				$this->_server = $server;
      } else {
        $this->_stream = @fsockopen("{$this->_protocol}://{$server->get_ip()}", $server->get_q_port(), $errno, $errstr, 1);
        if (!$this->_stream) {
          $server->set_extra_value('_error', $errstr);
          $server->set_status(false);
          return false;
        }
        stream_set_timeout($this->_stream, $lgsl_config['timeout'], $lgsl_config['timeout'] ? 0 : 500000);
        stream_set_blocking($this->_stream, true);
      }
			return true;
		}
		public function readRaw($length = 4096) {
      if ($this->_isHttp()) {
				$result = curl_exec($this->_stream);
				if (curl_errno($this->_stream)) {
					$this->_server->set_extra_value('_error', 'Couldn\'t send request: ' . curl_error($this->_stream));
          $this->_server->set_status(false);
          return false;
				} else {
					$resultStatus = curl_getinfo($this->_stream, CURLINFO_HTTP_CODE);
					if ($resultStatus != 200) {
						$this->_server->set_extra_value('_error', "Request failed: HTTP status code: {$resultStatus}");
					}
				}
        return $result;
      } else {
        return fread($this->_stream, $length);
      }
		}
		public function read($length = 4096) {
			$result = $this->readRaw($length);
			if (!$result) return false;
      return new Buffer($result);
		}
		public function readJson($length = 4096) {
			$result = $this->readRaw($length);
			try {
				return json_decode($result, true);
      } catch (\Exception $e) {
				return $result;
			}
		}
		public function write($data) {
      if ($this->_isHttp()) {
				curl_setopt($this->_stream, CURLOPT_URL, $data);
      } else {
        fwrite($this->_stream, $data);
      }
		}
		public function &getStream() {
			return $this->_stream;
		}
		public function close() {
			if (!$this->_stream) return;
      if ($this->_isHttp()) {
        curl_close($this->_stream);
      } else {
        @fclose($this->_stream);
      }
		}
	}
//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
  class Helper {
    static function lgslParseColor($string, $type) {
      switch ($type) {
        case "2": return preg_replace("/\^[\x20-\x7E]/", "", $string);
        case "doomskulltag": return preg_replace("/\\x1c./", "", $string);
        case "farcry": return preg_replace("/\\$\d/", "", $string);
        case "fivem": return preg_replace("/\^\d/", "", $string);
        case "painkiller": return preg_replace("/#./", "", $string);
        case "swat4": return preg_replace("/\[c=......\]/Usi", "", $string);
        case "minecraft": return preg_replace("/[�§]\w/S", "", $string);
        case "factorio": return preg_replace("/\[[-a-z=0-9\#\/\.,\s?]*\]/S", "", $string);				
				case "bbcode": return preg_replace('/\[[^\]]+\]/', '', $string);
				
        case "1":
          $string = preg_replace("/\^x.../", "", $string);
          $string = preg_replace("/\^./",    "", $string);

          $string_length = strlen($string);
          for ($i=0; $i<$string_length; $i++) {
            $char = ord($string[$i]);
            if ($char > 160) { $char = $char - 128; }
            if ($char > 126) { $char = 46; }
            if ($char == 16) { $char = 91; }
            if ($char == 17) { $char = 93; }
            if ($char  < 32) { $char = 46; }
            $string[$i] = chr($char);
          }
        break;

        case "quakeworld":
          $string_length = strlen($string);
          for ($i=0; $i<$string_length; $i++) {
            $char = ord($string[$i]);
            if ($char > 141) { $char = $char - 128; }
            if ($char < 32)  { $char = $char + 30;  }
            $string[$i] = chr($char);
          }
        break;

        case "savage":
          $string = preg_replace("/\^[a-z]/",   "", $string);
          $string = preg_replace("/\^[0-9]+/",  "", $string);
          $string = preg_replace("/lan .*\^/U", "", $string);
          $string = preg_replace("/con .*\^/U", "", $string);
        break;
      }
      return $string;
    }
    static function lgslUnpack($string, $format) {
      list(,$string) = @unpack($format, $string);
      return $string;
    }
    static function lgslTime($seconds) {
      if (!$seconds || $seconds === "") { return ""; }

      $n = $seconds < 0 ? "-" : "";

      $seconds = abs($seconds);
      $d = (int) ($seconds / 86400);
      $h = (int) ($seconds / 3600 ) % 24;
      $m = (int) ($seconds / 60   ) % 60;
      $s = (int) ($seconds        ) % 60;

      $h = str_pad($h, "2", "0", STR_PAD_LEFT);
      $m = str_pad($m, "2", "0", STR_PAD_LEFT);
      $s = str_pad($s, "2", "0", STR_PAD_LEFT);

      return $d > 0 ? "{$d}d {$n}{$h}:{$m}:{$s}" : "{$n}{$h}:{$m}:{$s}";
    }
    static function lgslShowDebugString(&$buffer = "") {
      $raw = $raw2 = '';
      $symbols = unpack('C*', $buffer);
  
      foreach ($symbols as $key => $value) {
        $cd = chr($value);
        if ($value == 0) {
          $raw .= "<span style='color:gray;'>[0]</span>";
          $raw2 .= "<div class='char-element'><div class='char-cell'>{$cd}</div><div class='char-cell'><span style='color:gray;'>{$value}</span></div></div>";
        } else {
          $raw .= $cd;
          $raw2 .= "<div class='char-element'><div class='char-cell'>{$cd}</div><div class='char-cell'>{$value}</div></div>";
        }
      }
  
      echo("
        <style>.char-element {display: inline-block;max-width: 24px;border: 1px solid black;text-align: center;} .char-cell {width: 24px;height: 18px;display: inline-block;}</style>
        <span style='color:red;'>". count($symbols) ."</span> symbols <span style='color:yellow;'>>></span>{$raw}<br />
        <details style='width: 260px;'>{$raw2}</details>
      ");
    }
    static function lgslUnescape($text) {
      return str_replace(['\t', '\v', '\r', '\n', '\f', '\s', '\p', '\/'], [' ', ' ', ' ', ' ', ' ', ' ', '|', '/'], $text);
    }
    static function lgslCutString(&$buffer, $start_byte = 0, $end_marker = "\x00") {
      $buffer = substr($buffer, $start_byte);
      $length = strpos($buffer, $end_marker);
      if ($length === FALSE) { $length = strlen($buffer); }
      $string = substr($buffer, 0, $length);
      $buffer = substr($buffer, $length + strlen($end_marker));
      return $string;
    }
    static function bool($condition) {
      if ($condition) return 'true';
      return 'false';
    }
  }
//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  function lgsl_query_live($type, $ip, $c_port, $q_port, $s_port, $request)
  {
//---------------------------------------------------------+

    if (preg_match("/[^0-9a-zA-Z\.\-\[\]\:]/i", $ip))
    {
      exit("LGSL PROBLEM: INVALID IP OR HOSTNAME");
    }

    $lgsl_protocol_list = Protocol::lgsl_protocol_list();

    if (!isset($lgsl_protocol_list[$type]))
    {
      exit("LGSL PROBLEM: ".($type ? "INVALID TYPE '{$type}'" : "MISSING TYPE")." FOR {$ip}, {$c_port}, {$q_port}, {$s_port}");
    }

    $lgsl_function = "tltneon\LGSL\lgsl_query_{$lgsl_protocol_list[$type]}";

    if (!function_exists($lgsl_function))
    {
      exit("LGSL PROBLEM: FUNCTION DOES NOT EXIST FOR: {$type}");
    }

    if (!intval($q_port))
    {
      exit("LGSL PROBLEM: INVALID QUERY PORT");
    }

//---------------------------------------------------------+
//  ARRAYS ARE SETUP IN ADVANCE

  $server = [
  "b" => ["type" => $type, "ip" => $ip, "c_port" => $c_port, "q_port" => $q_port, "s_port" => $s_port, "status" => 1],
  "s" => ["game" => "", "mode" => "", "name" => "", "map" => "", "players" => 0, "playersmax" => 0, "password" => ""],
  "e" => [],
  "p" => [],
  "t" => []];

//---------------------------------------------------------+
//  GET DATA

    if ($lgsl_function == "lgsl_query_01") // TEST RETURNS DIRECT
    {
      $lgsl_need = ""; $lgsl_fp = "";
      $response = call_user_func_array($lgsl_function, [&$server, &$lgsl_need, &$lgsl_fp]);
      return $server;
    }

    global $lgsl_config; // FEED ENABLED BY EXTERNAL CONFIG SETTING

    if (!empty($lgsl_config['feed']['method']) && !empty($lgsl_config['feed']['url']))
    {
      $response = lgsl_query_feed($server, $request, $lgsl_config['feed']['method'], $lgsl_config['feed']['url']);
    }
    else
    {
      $response = lgsl_query_direct($server, $request, $lgsl_function, lgsl_gametype_scheme($type));
    }

//---------------------------------------------------------+
//  FORMAT RESPONSE

    if (!$response) // SERVER OFFLINE
    {
      $server['b']['status'] = 0;
    }
    else
    {
      // FILL IN EMPTY VALUES
      if (empty($server['s']['game'])) { $server['s']['game'] = $type; }
      if (empty($server['s']['map']))  { $server['s']['map']  = "-"; }

      // REMOVE FOLDERS FROM MAP NAMES
      if (($pos = strrpos($server['s']['map'], "/"))  !== FALSE) { $server['s']['map'] = substr($server['s']['map'], $pos + 1); }
      if (($pos = strrpos($server['s']['map'], "\\")) !== FALSE) { $server['s']['map'] = substr($server['s']['map'], $pos + 1); }

      // PLAYER COUNT AND PASSWORD STATUS SHOULD BE NUMERIC
      $server['s']['players']    = intval($server['s']['players']);
      $server['s']['playersmax'] = intval($server['s']['playersmax']);

      if (isset($server['s']['password'][0])) { $server['s']['password'] = (strtolower($server['s']['password'][0]) == "t") ? 1 : 0; }
      else                                    { $server['s']['password'] = intval($server['s']['password']); }

      // REMOVE EMPTY AND UN-REQUESTED ARRAYS

      if (strpos($request, "p") === FALSE && empty($server['p']) && $server['s']['players'] != 0) { unset($server['p']); }
      if (strpos($request, "p") === FALSE && empty($server['t']))                                 { unset($server['t']); }
      if (strpos($request, "e") === FALSE && empty($server['e']))                                 { unset($server['e']); }
      if (strpos($request, "s") === FALSE && empty($server['s']['name']))                         { unset($server['s']); }
    }

    $server['s']['cache_time'] = time();

//---------------------------------------------------------+

    return $server;
  }

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  function lgsl_query_direct(&$server, $request, $lgsl_function, $scheme)
  {
//---------------------------------------------------------+

    global $lgsl_config;

    $lgsl_config['timeout'] = intval($lgsl_config['timeout']);

    if ($scheme == 'http') {
      
      if(!LGSL::isEnabled("curl")) return FALSE;

      $lgsl_fp =  curl_init('');
      curl_setopt($lgsl_fp, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($lgsl_fp, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($lgsl_fp, CURLOPT_CONNECTTIMEOUT, $lgsl_config['timeout']);
      curl_setopt($lgsl_fp, CURLOPT_TIMEOUT, 3);
      curl_setopt($lgsl_fp, CURLOPT_HTTPHEADER, ['Accept: application/json']);

    }
    else {

      $lgsl_fp = @fsockopen("{$scheme}://{$server['b']['ip']}", $server['b']['q_port'], $errno, $errstr, 1);

      if (!$lgsl_fp) { $server['e']['_error'] = $errstr; return FALSE; }

      stream_set_timeout($lgsl_fp, $lgsl_config['timeout'], $lgsl_config['timeout'] ? 0 : 500000);
      stream_set_blocking($lgsl_fp, TRUE);

    }

//---------------------------------------------------------+
//  CHECK WHAT IS NEEDED

    $lgsl_need      = [];
    $lgsl_need['s'] = strpos($request, "s") !== FALSE;
    $lgsl_need['e'] = strpos($request, "e") !== FALSE;
    $lgsl_need['p'] = strpos($request, "p") !== FALSE;

    // ChANGE [e] TO [s][e] AS BASIC QUERIES OFTEN RETURN EXTRA INFO
    if ($lgsl_need['e'] && !$lgsl_need['s']) { $lgsl_need['s'] = TRUE; }

//---------------------------------------------------------+
//  QUERY FUNCTION IS REPEATED TO REDUCE DUPLICATE CODE

    do
    {
      $lgsl_need_check = $lgsl_need;

      // CALL FUNCTION REQUIRES '&$variable' TO PASS 'BY REFERENCE'
      $response = call_user_func_array($lgsl_function, [&$server, &$lgsl_need, &$lgsl_fp]);

      // CHECK IF SERVER IS OFFLINE
      if (!$response) { break; }

      // CHECK IF NEED HAS NOT CHANGED - THIS SERVES TWO PURPOSES - TO PREVENT INFINITE LOOPS - AND TO
      // AVOID WRITING $lgsl_need = FALSE FALSE FALSE FOR GAMES THAT RETURN ALL DATA IN ONE RESPONSE
      if ($lgsl_need_check == $lgsl_need) { break; }

      // OPTIMIZATION THAT SKIPS REQUEST FOR PLAYER DETAILS WHEN THE SERVER IS KNOWN TO BE EMPTY
      if ($lgsl_need['p'] && $server['s']['players'] == "0") { $lgsl_need['p'] = FALSE; }
    }
    while ($lgsl_need['s'] == TRUE || $lgsl_need['e'] == TRUE || $lgsl_need['p'] == TRUE);

//---------------------------------------------------------+

    if ($scheme == 'http') {
      curl_close($lgsl_fp);
    } else {
      @fclose($lgsl_fp);
    }

    return $response;
}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  function lgsl_query_feed(&$server, $request, $lgsl_feed_method, $lgsl_feed_url)
  {
//---------------------------------------------------------+

    $lgsl_feed_error = 0;

    $host = parse_url($lgsl_feed_url);

    if (empty($host['host']) || empty($host['path'])) { exit("LGSL FEED PROBLEM: INVALID URL"); }

    $host_query = "?type={$server['b']['type']}&ip={$server['b']['ip']}&c_port={$server['b']['c_port']}&q_port={$server['b']['q_port']}&s_port={$server['b']['s_port']}&request={$request}&version=7.0.0";

    if (function_exists("json_decode")) { $host_query .= function_exists("gzuncompress") ? "&format=4" : "&format=3"; }
    else                                { $host_query .= function_exists("gzuncompress") ? "&format=2" : "&format=1"; }

    $referrer = preg_replace("/(.*):\/\//i", "", $_SERVER['HTTP_HOST'])."/{$_SERVER['SCRIPT_NAME']}";
    $referrer = "http://".str_replace("//", "/", $referrer);
    $referrer = empty($_SERVER['QUERY_STRING']) ? $referrer : "{$referrer}?{$_SERVER['QUERY_STRING']}";

//---------------------------------------------------------+

    if (LGSL::isEnabled("curl") && $lgsl_feed_method == 1)
    {
      $lgsl_curl = curl_init();

      curl_setopt($lgsl_curl, CURLOPT_HEADER, 0);
      curl_setopt($lgsl_curl, CURLOPT_HTTPGET, 1);
      curl_setopt($lgsl_curl, CURLOPT_TIMEOUT, 6);
      curl_setopt($lgsl_curl, CURLOPT_ENCODING, "");
      curl_setopt($lgsl_curl, CURLOPT_FORBID_REUSE, 1);
      curl_setopt($lgsl_curl, CURLOPT_FRESH_CONNECT, 1);
      curl_setopt($lgsl_curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($lgsl_curl, CURLOPT_CONNECTTIMEOUT, 6);
      curl_setopt($lgsl_curl, CURLOPT_REFERER, $referrer);
      curl_setopt($lgsl_curl, CURLOPT_URL, "http://{$host['host']}{$host['path']}{$host_query}");

      $http_reply = curl_exec($lgsl_curl);

      if (curl_error($lgsl_curl))
      {
        $lgsl_feed_error = 1;
      }

      curl_close($lgsl_curl);
    }

//---------------------------------------------------------+

    elseif (function_exists('fsockopen'))
    {
      $lgsl_fp = @fsockopen($host['host'], "80", $errno, $errstr, 6);

      if (!$lgsl_fp)
      {
        $lgsl_feed_error = 1;
      }
      else
      {
        stream_set_timeout($lgsl_fp, 6, 0);
        stream_set_blocking($lgsl_fp, TRUE);

        $http_send  = "GET {$host['path']}{$host_query} HTTP/1.0\r\n";
        $http_send .= "Host: {$host['host']}\r\n";
        $http_send .= "Referer: {$referrer}\r\n";
        $http_send .= "Pragma: no-cache\r\n";
        $http_send .= "Cache-Control: max-age=0\r\n";
        $http_send .= "Accept-Encoding: \r\n";
        $http_send .= "Accept-Language: en-us,en;q=0.5\r\n";
        $http_send .= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n";
        $http_send .= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n";
        $http_send .= "User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.9.1.4) Gecko/20091028\r\n";
        $http_send .= "Connection: Close\r\n\r\n";

        fwrite($lgsl_fp, $http_send);

        $http_reply = "";

        while (!feof($lgsl_fp))
        {
          $http_chunk = fread($lgsl_fp, 4096);
          if ($http_chunk === "") { break; }
          $http_reply .= $http_chunk;
        }

        @fclose($lgsl_fp);
      }
    }

//---------------------------------------------------------+

    else
    {
      exit("LGSL FEED PROBLEM: NO CURL OR FSOCKOPEN SUPPORT");
    }

//---------------------------------------------------------+

    if (!$lgsl_feed_error)
    {
      if (preg_match("/_F([1-4])_(.*)_F([1-4])_/U", $http_reply, $match))
      {
        if     ($match[1] == 4 && $match[3] == 4) { $server = json_decode(gzuncompress(base64_decode($match[2])), TRUE); }
        elseif ($match[1] == 3 && $match[3] == 3) { $server = json_decode(            (base64_decode($match[2])), TRUE); }
        elseif ($match[1] == 2 && $match[3] == 2) { $server = unserialize(gzuncompress(base64_decode($match[2]))); }
        elseif ($match[1] == 1 && $match[3] == 1) { $server = unserialize(            (base64_decode($match[2]))); }
      }
      elseif (preg_match("/_SLGSLF_(.*)_SLGSLF_/U", $http_reply, $match))
      {
        $server = unserialize($match[1]);
      }
      else
      {
        $lgsl_feed_error = 2;
      }

      if (!$lgsl_feed_error && empty($server))
      {
        $lgsl_feed_error = 3;
      }
    }

//---------------------------------------------------------+

    switch($lgsl_feed_error)
    {
      case 1: // CONNECTION PROBLEM - FEED MAYBE TEMPORARY OFFLINE
        $server['s']['name'] = "---";
        $server['s']['map']  = "---";
        $server['e'] = ["feed" => "Failed To Connect"];
        $server['p'] = [];
      break;

      case 2: // NO FEED DATA - MAYBE WRONG FEED URL
        exit("<div style='width:100%;overflow:auto'>FEED MISSING FROM: {$host['host']}{$host['path']} RETURNED: ".htmlspecialchars($http_reply, ENT_QUOTES)." :END</div>");
      break;

      case 3: // UNABLE TO UNPACK FEED DATA - MAYBE ERRORS ON FEED
        exit("<div style='width:100%;overflow:auto'>FEED CORRUPTION FROM: {$host['host']}{$host['path']} RETURNED: ".htmlspecialchars($http_reply, ENT_QUOTES)." :END</div>");
      break;
    }

//---------------------------------------------------------+

    // FALSE IS SO LOCAL OFFLINE CODE TAKES OVER
    return $server['b']['status'] ? TRUE : FALSE;
  }

//---------------------------------------------------------+

  function lgsl_cut_byte(&$buffer, $length) {
    $string = substr($buffer, 0, $length);
    $buffer = substr($buffer, $length);

    return $string;
  }

//---------------------------------------------------------+

  function lgsl_cut_string(&$buffer, $start_byte = 0, $end_marker = "\x00") {
    $buffer = substr($buffer, $start_byte);
    $length = strpos($buffer, $end_marker);

    if ($length === FALSE) { $length = strlen($buffer); }

    $string = substr($buffer, 0, $length);
    $buffer = substr($buffer, $length + strlen($end_marker));

    return $string;
  }

//---------------------------------------------------------+

  function lgsl_cut_pascal(&$buffer, $start_byte = 1, $length_adjust = 0, $end_byte = 0) {
    $length = ord(substr($buffer, 0, $start_byte)) + $length_adjust;
    $string = substr($buffer, $start_byte, $length);
    $buffer = substr($buffer, $start_byte + $length + $end_byte);

    return $string;
  }

//---------------------------------------------------------+

  function lgsl_get_string($buffer, $start_byte = 0, $end_marker = "\x00") {
    $buffer = substr($buffer, $start_byte);
    $length = strpos($buffer, $end_marker);

    if ($length === FALSE) { $length = strlen($buffer); }

    $string = substr($buffer, 0, $length);

    return $string;
  }

//---------------------------------------------------------+

  function lgsl_gs_crypt($type, &$buffer, $encrypt = FALSE) {
    $master_key = pack("H*",
    "f5c5914b27235dc0dc274200ddd187c32fe02aed5fc5c079518f49208e4c5548aaef313c5d2e7c91dc580d3cd9e1aec577595325d3c5c84b44a020802becb17e".
    "7d6b6b87e8a4ebc8e4cafbaf5720f9600818b334ad2695ba0f19e1fbd48d0139f05e9059e98a15c79ebabb4f3aa8039d8720aef2bf1b4693a67a20a114b8505b".
    "693cf5b24a236503582ecdb8109a7d89a8d90d660b96435b4656ecec3fff2086e94c54988843d2aa55adefb2d47fc804c0024a7897e993b2326e8990e425f7c8".
    "38aef55f2002f22d84479f43849de260a8a2de6a7de09225c275a172729e65be687182bde68cb17b3fd77bf513c8045f0b6696d3a501b255db0632e36c0e7806".
    "c5c193b5b9a9c621f0ac9a0ee72196edbb336e7431b75eba95d02191048ab7c3874578218d79a2623e308184fdac98a1568c09b8907d8411e29c53823a3a68bc".
    "c785547ebb29401822da7fa59c6fc412cf2a9201f31336bcdffe78501058b1d7814e920ceee7aca8fa798f10f0a8ba19a1deae864e1c77f974880e5571a4380b".
    "52d3357ec8cbf8ff6ff7e8f3fa6223f923e4a7bb1918054bcd2a115e466307f39d964c051983f8b2e5db0b39332ec08c94d9b36a4594ab5e868bc888e4586687".
    "b6e62b2bb06ad0903544e379d744896f95346a0238b2b72c6d38ed1bf011185bad1910812cfe2c5b38db10433088f2e5a3746e7302467d35e8f07722fad1f7d4".
    "283fbea23fa6f50f710491b1f0a8dd3a187939e7f344de57c256ffb063791fc556d3791570a873537c3f05f8ca08aa1eb2e3f641e0fb46fde7394f8fb4c216d7".
    "55c020b405a21b8e4340136fc9583800afd87a677d3d9b6b95585ba502d6db2dec504f25b612340e29be64700682f4f012908e2672916ba83d35deb58d826d83".
    "d75a61f726876747d78df10a31f6acb36cb64dec47b7da11c7e7177dcc097965a50065e8e5f91732e20647604c00c0fa451f7ee140d93515b7b5e6f9e0c92ad0".
    "29648ab1e0ea363c5a19d12832c54c0ae67baa7e029217ede5f97cd07ebf3aaf14c020f4646e3792e2472409299868b9ee1ce7a69a30203218289523d848a2ee".
    "42b96edf05f24182491dfb048c17f815aa8983d9ab72723defbe9750cd694bc1318c92862ed7b7ab1e37472b986a7f4745224fd723e4e6ef53ff6d5f51f1b8cd".
    "34b32b9ac92968e5ec8b631aa750e7cec51e7fddca5da1cdc836c0243ab2a2f86d072479c117738fafba4d72db6fee13274d652a7c76ff962c1389b32f95f3c0".
    "04d178b71646fe084507e7dd4b4db98405cb72399f78f989c188fb2ed6e18e5aa417adae504d33ad8414f9e3a6e466837062e8ea91664f63134539679b119d6b".
    "3918f833ceddc249933b0ae83e0965b38fb86d3da02622d02f57c7282e5f0cdb18f71e7450c538ddca55588575f80754dd0c89840bcf7e246e8f041309069f15".
    "a49c27fa0a5913c72be881ae27ff6b0332701d96dc295576d2a9bc0fd266f5604da647f78d1c2ced95c4cf8a929c55bf524198898b444c67040d7c7debcc3cc9".
    "7cab1a8fe190f4db097beaccea9a34e38380b43bd2b2bf98f471c02894aaaf3944680988497aa74d293238d503a4df19d90af204fdcbb1875170a96b7f3e288c".
    "0f24e1c8b9ce4f77f2b03944c2abbacba69331a244923c38f731f368d10eca82dd503bdece016064c68cb38a4e3408712959cb5216dc42bf5365eb789c484bcc".
    "5813a1f1680fc5606e8da06bd5a68a73bd593fcd4aeb9aca06bb258f84a38dd0d4c6c0c355c4d5e0e1a97abaa11869f26285a99db4dfb8eab0b0f53e80d2486b".
    "9a6cc63affac0b830b12434ddbc1c4ef3ee46af67fcc711b88a352d2b324c0acfb35bfbe74865afd7f3293a944cd9f69230a206c5112ed9858497ddc118c0338".
    "63f1a974b033a225c74e83c9d1bec1a3e6a7b2b7ddab58aec40fe4bed9e2fd1beaded608c695dafaf4d683fdf3b9175d1283d7d99b47c40209a555c317e29bad".
    "574ac49e78ae91896b527d27f04d89b10d5f754b953d1218bf01fc06086c031ff334eab692e9c6fb221ac0f3027283ac5350d860f2d6125d31edf4b7ac806f21".
    "abeb04f84230e8c17455e54a27d6862cfb3279370eae1cdb1f84c10209e89241182c307b45a6b97520a62bc263c66f78d27b52ad9728f5d78c1626297b1d1cdd".
    "e47fd67d9f1f4846a3643810359f2cc6b22a662683836eb48f6e1605be3a830fe29f0c54412e7d82aefff9748a2fddb368dd0103161e2a17da69216e22adf6b5".
    "7ce255e400279188655820eedd5a1935aa3d8cf621fa312bab89cbb3071bfbe7e0635126de8217bd5c342f35824511769ac6b72de09b87012cd85f2cbef53e11".
    "9aba484771b15bddda183501230ae6a16fcde55a161df16f178e04478a3711437dc91eeabe92e14b44d2f49036532be42c425346df9d91288aa409a63272e061".
    "baaaca491cc04c44b2ac739290baa76d9fdc7b66733548af6411a6ba790c4962ddf033e63fab462bc0ccbfa45d45ce377d32f4c7e905cab5fbbb524f8c2907d0".
    "41b304d1f38f348efd34a7d51c118445d05353b5f0449f368450782df457ca55169bdfa817a94e1082faf4115cf3d6d890481affb2feb95145691f152485465d".
    "0f8dba4cde2079784574fadbe805222e3a132934f1a419cda032b310fd7dfa2830d3f3385d646ba0c373cba4d624a6267300014cdd2dd5e87999aa5b0e5df0a8".
    "de50f3473918474ccf82f9c8ab9f31379a9d8d00bead3bc8b9d00f4ebba9c7b0ea882454e3a785e096d7887b3a507f089dba88925df12c633241ed2f9f68905b".
    "66775d1d0ca3cc312f7be8641856be8de24248e55dd737df8410e23e9457024f534261f09ab278821b1c89da824f7f546a4163f4d53ccf07ee9bd59adb673822".
    "87092b94a7847141a796a6abf90f7bfa5d8967bfba2275283863bfc3f8283f0e5b223748a55dff04f3c6bf228bb1e0bfd2c80289abf5819e165268b4e687bcf4".
    "a33f1c42c47a6236ca14c26778ad2cbe013c20807e45276d49a4e0df7df7c42d2c73f298f61fc8e778ba953a71c6b7d1779624552df0f3896a790671a3a981fa".
    "17914d856321d0997ff4b2d05944335ceac60b63b1d827eab5ef7483990e9bd1b5453a473e1efd476ba1e093466cb21dc72e35dc12bb8c8d3bb29db420251590".
    "32441b8a7e9458cad9cdc1551ce52312bb27d858a8ae319e525b38f20242a60933b2a21bd858e147cc6ee702983c84bf535d1575a54dc46c03cdb42a39d1a64e".
    "433d9bea41f9915f7d9d462d4308baccb19bb1adc3e0125715950f7c7f8b54312826204fd512386da587bad7bf81069dc554fd8fd77153832225e56a7fa4046b".
    "d588ed258dc7e54ccf1c021f9800376376bdcfc62116555ab0e06b3161b3b7a6a7a87de2371215207c43fce54c82feddc5d444b08f6a30c0095007d526da1b02".
    "41563a9360f86ef3b824294bd174679f4dee74912acdeb00ac96a713ad86dc212a544b7420fa6c83d5dec48400e1f11f8163e20c932bc893820a8261939e0f85".
    "fdb416c6a0a18cc0182d675702a8362694f23ce686962150f862357fe84a0b572068c7e0578909d7f82c87cd17e7ef50e5566eab694ac76edb4b6d8a85cd2910".
    "0b93272b0a524a24db8db7d4622fae63d982e4090fb519e30736d5b5152d58a234919d216d0294628841cba91ed72d985ba92f7cc548378e7ddf812816ad99dd".
    "27adffdf5b6d762a79a942d8af9a8f0ac81afc98869dcdcc06835478947ced5ccbb22d02624e207c774042fa8c133221c362bef69582c52ca9c014db1ec2d351".
    "a1d72bb01c06e32ca0a4ecfe923737f0f7145b27c943a9be1f174dd46d3af58e7a2f612177affd11ae7e1b9231aadb46bcb732ee79de7e62f467721f06d8e9e5".
    "59b526bb702ddbc0f0b46a2162458c15c0154cbb1b1edad3fa198a0781279ecc5e5391269c335bc94b2f21da781cf943cd0e700206128fe1f1e3af4e70bfbaec".
    "1c7ae4884c7e7544050036b001f87fc2f10762888701c160010e7691ea2b53b646d22178ebf1a56eb9cba86ffa2b570d846e231037d403298103c61732b04113".
    "ff7ec74e0a671332f7df9da231f995c1fb53523c17c23105312b7d8ab63e5f6a0e7b9d106f3ce575d14befb3a5803aabcc9edb5f1ddf9dcabff4efbd785b169d".
    "f7fb1b991faf63f064b5fc8f2c7fcac4b35a61f19c92dec36a6aadf02dc3942dde51d7225aefeaf6b7527183c2adc832c6bc8735bc7be2c18ad3d70653f91581".
    "ce42a275ef6715932ae7513d0ecb726be54c167cc89445a08cb8e12fc583aee815b3947bd1ac781fcbfbdda25fe3e931a21c47058197ceffbe9bd2ac6394b2d5".
    "95c3e10076c3aceba33b1556029edfbc04849e0d66713f7beeb1517dcd43279a5073ec9fa221bfaceef0f639e771a44156778cbb696af28e2437eea3fc025d27".
    "70b1409d978e4ec808c58288d525ac977db0ace80d9554925bf8767b8e91a9bf1ed25deabdbb93315ca08f711ae3f768a911eeacd93bfa6db3957da83c0fd945".
    "a7e596b66530aa7347e04590fd31db6b49485a9ea8208c0aab4068f482b185aaed6ee69e32f9ff7b882763da34f6e3bce94c79353ef6849d47e6345d8727e076".
    "f1aa0133c2399e4d777525fe9aa29e75d23df6e829f9058580413d5c24f85568beb1343430f393adee28ab54e220b4c884fa6ebc2825705f863ba7d82977f653".
    "edb2088abd84ad52a1810a52abc6e7c3b5687f3bf4744941ce48c876205f2497b641e6e4bb565ab816425c348e1f034104efda9a21723b00cdadc6ed2af6b225".
    "524ae512afba6bc19c471e14bbba042dba641424005a816f25aee44ee84cf2f729b79b1b9d58218f0274d92168c9bb1cd1c141b5f8341a3a4dc78c0ddf08dfd4".
    "110b4eb0b71b265fe70aa5a4b2186cafad5ff94dafd5b4b4560bac45cb47c4c863274ac2d84af46b75bfde496d39984ff0af8ab7d98bc12c02ce782b23268d03".
    "864826b0201d8d1e0c09c9ab229a2f7fe1504795bafa8b8ae13fb046a2f35233a49b772b57862ada835951742439693ed9f3a080aea7a1309de4ae04b1ce3d78".
    "72cdd85a3544906afaf55aff8255bdb2367c7ecf184c91c8f4c60a1301b80f8bb9f0ff6d80ac6e1c9d6c9fafbc65199790e0a9c323e68b105f5c56eed2f60294".
    "5ab59d79698829ba092cc97f37dd023595d3fa014e718cda23d6bdbbfd70c2c6cc1b9121d22eae0bde7b94277dc8e5e096d60351f2740ddb986c7e10e0af8a40".
    "e9bd526f863cde028dd253e18013d3c76c2006a9ab9ec3e7b6b1aca865b2ace8c8debb50ae1efbc0e49dd69f128c28bd02d79f22717e2679d5142540733cb278".
    "0969944106122d5f2baf97f7e09ef67b894cd191411126ad962e4b9c5a0bbe83215563662ce5f063ce2a76c2e09613539fbb094d389e739ca0a3fc34bd1692ba".
    "f0601e2122a70fdf68ede6c431090896622362c59801000727718f4b551f32340fc5f740e15fc0a023791aa57a6cc97af3077f5d71d33cbc864049b30cb11ea5".
    "23c15141ea5ac620aec5f81e6661bf8f01a3c817ac1ab592570b63764402e4934d776df03cadae448c5d9082c30c00737e4bbe5c184a1167507d9b99bdd05592".
    "456ac25dadb5beafe282028611db969c44db7bfb2cad349c0ecbebc281a00ad4f70cfd889b3533833ab845f86403e6a1970da6b5c8b8e82e9f42a82c7c14e535".
    "16b3d9efbaae6ca6b9c93977f17f58ec29a1a8bb188fb15f377bf50d37e84781ca1716052f657a361cbe44eb227002a57390873e54b8695f76fe0f84f873e021".
    "c92945f3d7b54861be3c237701c140c3a4e1b84fa4bab910cd265393e0172293d6fc40fa1872e175d7d3f06153a9eca3f8db85c2166f68415eda3bf4aee35adc".
    "0231cd6cfe5d3a23b51fb0105176b9cdadc28304d27fef698cf4155235d07ecfaf5a2c5f8610a63ee809b0e0260251c33873dceebdda1ec3725d1376031e45cc".
    "731a870b39edc97b549b96624c891984acf7a422584bc56f2104256f15da552d0a8376a546b6966153728ca1f38514df0d458375e99bc01fa498b07abb33803f".
    "da07c4149e6e5773f9ec65ac3c87ca7c515f263de3cda2d53edbc20c47486ee33f9810c8226bbc9c52fcadb1f01fe28bf099b8afb9f1798e0b9815210c559187".
    "c562b5e45350a5d0708c2fb96bad405ef4b8b535066ed02da198e4a3a4eaf075450c87f6d9840c8e00b8e316bcc7a5c6113fefbd72b0c7f6860fcecc8a3f33fb".
    "a2999e4f3f3e3da5d7bfcf5d22a93f4d16ae6dd053685dfc7223628f92086735d09551bd29e8d0f537d06f33536fce8360d7443f583e9079685efce0347c1ffa".
    "fedd0b7d1125f0dfc9bb21460079f286abbbeb549bb744aeea0b7a6bc66a272c8af945621b57b8380d40fa067c3060b9d44b79bd4333ec96d47632124a9aad0a".
    "2df287eda9312f70f12f544fd7bdef9e6cc5e110effb8dbdebb821571f0fa95301db9da0bb60b77af6d5b7de00ca26039f1dda92f7a777c75d02fc340f1b81b5".
    "e7c5efc6aaa6ffe3b77db348b7a5973a9465cb1e01841fa10f398318bfb73a4f8f53a4bded656f35db0ef00685826d8eac3aa0941623b3401ffdaba927bc91f4".
    "808818548a60f653e9f340f79e40d666525923c4847ac3c0a9b36f3069620b0aea677ee7afa2c333987d9a5afade1b0e1e22ef7470228b07c9f482a6c343a37c".
    "462a749c02d4cc86447cc16c3c68955afa80e63a3a41aaa1375c7ca0cffa0335e96e599e1b6841ae5693b5fa6ff437c3c1dca20075b7a58aafa81845af0aa8f6".
    "30520d89a362d667447045c2b39f88f573f6b76b95ea4a98950ad797570b841975e9841306223dbefd21a4f092d69452c4539c664e27e110622ae7a7db5073d6".
    "17eb023b36f28a13eeeebdbd964df63dcb18762950b6bd3eeead2a25b9bba48060ac8b82af3f41ecafbb7134140ca8cc687b92eded8bdabd9567e50950ed617a".
    "a114d3db8648f9ab48a622456aec56fe79cfa6225fc7fd3fb0607f9dbc1bd861b316600fc10163fe8098ea685bc3fe06435f51cb1ce7ffebae67b3114fadf8c8".
    "808a4044bb06638d05bc9a73c44c5b1eb7c83cdb4bde51ffa85413a97fbd534ddb17dc899fc4e2ced6ed81eeb117b4c77f9ecd03251367649a5649ec58567907".
    "4fc8c2702dc42a58308f4023fb2cd30c79ecb9a952cde77dfcf92d8ef234811c327112abd568c49d4bf693f611d07e433fcd0a396530c6a279eb3ba567d780b7".
    "271b6bfc7f1683a6b9159e143788662e8c5f73dd25ab623633efe781edd647b32003c9f3eaf236d968244e4561bc855848b839bfb93af2ea3e230a30089230c4".
    "2e593ed3b9be53d677a7c9da744ee1961aaccac237f9e0bc1f886a92d5f335c6c0b0250ea76fbdcd85ae9cf6afe7ab25fd6b4753be6505b986757b003b94a089".
    "d6a42b1fb24d2249ec917bb0ad50c8bd31265f82071a0816c3f8985edf0311205f83eaf8ff5587a3c7c24938a3f0cf9ff438b567d71407a51292e6d7e3f939e6".
    "cdbecd49e913793f73cb964406934907ca4d48f44bec301bdf0110986757fcac6c2cca84eb7c5fad1662d1a833d24fa356771d6b772759a4837d9872d23ff1ab".
    "219597aadc062f317d6cbc044bf65dc5ddda95ddc34d68584b7db991c8441a43e0511f71b88dda141f36b7cb326650c3244b989f1b992d2baa318e2a76dd1c34".
    "a946c843255f65c6896eac3a6774ceff50b6f66b752672f5ce8dc84149ba6b227da844254d01bf470f6c987e8b5df2168414bcee11ad8c131d16e43addbdd493".
    "595117f4f211c5d6460ee1be41e72b42c21252ce6dcd9838e53b0e1fd8d1864c2d3d219b82d42d0446865848431658732a78f0d9348f8044fa7f576d11562d25".
    "d7b681f714c4b43532543d27069a21d1d152e646c56d75229bb198f87676108306e68fa49751f3b1d678bbf1ea38b2e0712d896882b5ea1494136f23a7e1d528".
    "ca456c6c2a2cfc8cb6b6e7e6526aaa1da082653492b624936213569892706d8f9c6496b1193ec5a4294e3c1da14b25c24337cf9bb3490ea3f8a54e0a5b9f77af".
    "fc70fe8dcb7687a9f45c7ae3ee8f2a94fa58e6c920cce1f447fd60526fa71b6f1048a3dcc7680e3b20ac66d78290bfc3878e72d4876e014036b0b80b6be4bf2e".
    "a358125bea811b51af76a0077b3a615750a9ca3368d1d17e060a0d37bfd3b13c91412ca83298b06aea3048607f718c04667dcfc7faa4ac5a594be1c1551140ba".
    "9c1ea7cebc074b1fbd338eef831fa3eb1f39088bcf1cf13bf706b1d287e12b165f4fb3e6c4586067c5e2f461c4cc86400b456428e8767c1b57a7bc3e64a8abe6".
    "d253646f8796763b2a33de35c6f1667d06f30bb12c0fd0e28e4859ebdc2f96236af4a895d9a7d6fb90cbb60084db28a0c628faf7653c316ec69b5c5103aea495".
    "792efd58ec42bc950f8608d5fa6834aab7bd2aaece33b3e16756f518a5410e8957dd534437e8c152451d86beb20124e8fb9e672d13fb7e98e153c124fdb2eaf7".
    "f94a23efffeea25ec31f821e492d9de00a6d056c67e565f734f864d425035bb13620b7a1f44ec02ab7a6b1c4a38511b6902cfcf199d3918eb07da11d634add44".
    "0860d123fa2b8003f87270777c6415e32f1b34dd6e1e22df3a78684e1169fce84b61cf461544f4e891fcd9d1f5a1e5fef148aeddbfcc922f5d7bfd3bd2480e8a".
    "3318c75ce0afc24ca179fc0e832ab64368c174407bf2cd45a72cd5c9e7dd0b9def7500cec54d4d692938a1bb18289189d4b2445640d8abc9a0b70c3ffc8ba3c8".
    "d483119a4f63851a57cf30f48c88616785a5ee00cb9221db45dd8dff118ca33bb4ae254937891f2c971edc8614fa3fc43e56f297a44a234fb1737f23d44a15f0".
    "6a9e364fe1daa8e28bf72927526296202713f76dc8342e3843483b479ff793697b11a934bdc206905dd020e2f321cf8d65c245a8e7c4275f87301211800f0751".
    "4e9cb59b88540f5441e6b09b4b73112d855ba0dffd4affd670c4f76ec11ac07a6cc2201ac65c83b3b3e4dc10d991ef4424cd001d34f0393dc262957df641469a".
    "e00f74c527f8c99f50432c5ff4c4260ec6998b7ef2a0223290762126542d8aa89bfd241ac59e3a9a6c6f13afc9d69a771d124d16359525e4b374605b699e32bd".
    "fb393d9397767bce32ab2d5557d05c33fa54183b0d5facc73a097441aa34abf7d6ac36fb35d6be7f19d0c26c7ad564c06f8a4f616ff4819c53e8b29e782b8791".
    "c4039e5d049bd36819ae6d01a113eae6260e25150b935ee364011558dea97e1ee0e7f2938b7368ad9a5a86bae4f89a9ffbd06638566a785cb6ad3982b133ce6a".
    "3edb13aa2c4ad4db7052ac646fcf336b375efb6a360d448862f2b711db3d8e657a706c14013664beae06b1a067fd078b0a8800c01dd610d583bee4fa4634e4f3".
    "5251372b8144a7194ed60dc2539283ce909e7d65338a9050b09b66b647f30b6d595d7e03d9a77029afce140df7717f64949ae1362f94602dc2e70840e3117ab1".
    "a26cc8e8ffd068ec225f0b75b2de63e3511f4485c87fb0087e4421675f3754bc4bc9c0a38db6392661e8a59802d83f887cf81aa99ed13a10b4b8a176144f76ce".
    "3a192cc77b09e3f8a087db488f3d304d048623f46a031ba9251896cd08ff601dd0b933f5110b4cc9d943b5705b2435fa1c0adaad6c3aed88022f57cc3d71048f".
    "9d5f420cfaf737b8a9f2434601b296b14384618fa9b76e6acbf1b55ad7130f582f36920a5aff71e15d120b11d6e0dd374554803538f3b12305512cf24322ed52".
    "cd7ce5f409efd2f2752684bc326bf4548fa17169028c819ba342ee672682860a6de09752f509caad897484160895dc712b70bd05d588fe218fd85718b9b833ff".
    "2c18e2566416ce1e52c3d7dc696cca1ad02b9b99e2953f92d8fe7ac0e4d75bd2ae2834b9ad8e87f179cdaf5e75609abdf1236787fe366347c32991f20c7faf41".
    "b65da4ed5edc3cab1134a4ee0a3b565cab7c6dcd6f93feb528ddf0a1e992f6ad4814e51d338433dc5b52fddd8e780a312d12c80c4dbdaf8818b1c84883d8be41".
    "186de5fdeeb9c7b7542a8429e53645a313cd8c9a53c3790b9fcf0143421da3bb586762790c91b0110f68b5fd111338560437d7d77457fb5587efb40a90ed1c02".
    "838ba4e83b0c6adb175d94b6e14767a4f4a127e80f79be7741f4dc446c520176fd5b0412cc4d7a8f3d293e438d50e4e79e52bbc2c3bc6707d97b6289f1b39733".
    "48c9351b66be55b2152bee9b76c42dc057d12134180488f45aee9491fe72f8634e3beeda8006869a829d2d58614150ab489dca7af268c09dde668cc20428ff88".
    "366a3c0119446bdba29c39b0723fcd639393d397d138ab241c187beac647d8f73e5e42b3468e3958e0e73908c081ce0b6c894f0409f3bd321807a1633860a8e7".
    "49cb4a10875a65b3f0a073f48f141747c88afe9039ef0795752dbd07ef51a2dadb40bb09bb9d4fcb328f68af28f8d76085fccaef4afe848a93c4cac43f55863a".
    "21b540e6d408eb55fdfbd2a0c13fbae6fdf68e51423737f6966105d1ed57570bb521adb9576b06988d7d5a6445fe77d177076d47ca45b437a9780b376d49689e".
    "6b0be983d90f46dbf935e14b53f3bf7ac7aec7fc1b92c14f161e59ae2620f7552206f22a365c91476943b8b51e920661efc19d040070407ba1cf011d3a0e072e".
    "68d10e064619aa2184d7e848729b254af6b83db15fca2134d0d54efc761fff25c1169d608ed2434de8ae3cafb8c3af0b5b23a16183b5ead5dc5d175c955f4db5".
    "454623d611244c462776118992ba03e8e20e6e1d9d6101d2286d7e040d5a56f22d6e3ae86bd6a0605c8b34d7a385fee5f3c9b6d0cf550f7aa67f338d8a014dfd".
    "639cade855e8d25df73ea01bc5635bb5e032269b2a10f6b2baea7c4a88ede42caf91d7c9d3b2802608fdc361e23ee8cdcc1c954da86f929e9721130ef6d74e99".
    "180f8c8c2263b41f538e105bc5f411f8dd1c2d3e0dc4540ff9cbdb9a6c44524ebcdfe37d9427a43dc24fd28c2fc25baef96490ae847b435ef4eea87db030829d".
    "06b4c5d9271c8ffda114c336f5d82f9e6ca0d140112f364b1613cfe84c6e924629cba51a7d21f92ce26802bda0651340a8aad0c1ef439acc5552634304321cf6".
    "02851751630d671a8cce7028f1cc6fdbce64f762c8ed522c2a81c2886986999a85d41a87d2ba5281dcbc2dbd728559470017e12fd70a97a771de499d2953c49b".
    "0e60abac5ced203dd26bb75df922938723b1341bb07b0250d7af1bf91788994f8ed193221dd829e6665b114763e490fd8482955b097ac3b5b124bf92ae8ce902".
    "1897b67db820cbfd646fe2c61e63baa972651a47bb1aae56f5e623a1167beff84166ea78cc9854b21a9478ebf3a1429226213c20a7a9ce8031eced508b937263".
    "1357591069d5c482c0f6f99e4a6084f34fdab7b26399b4efcb0e5217e4e9115d0f6011bcfe55e0f05d3d8850febab0a6100bab8142a3913662a568f9d32367bf".
    "5db46b6572cb76bd6a49d84bd567e1f834bbd705dd395c1609e9eba7fe8b9c59f1c4cb2561461204805c25a384140314e515f84050949529050279393884f8d0");

    if ($type == "aarmy3") { $game_key = "c6mw4it2kg7sz5o0813d9qyufenhj\x00"; } else { exit("UNKNOWN GAME CRYPT KEY"); }

    $buffer_length   = strlen($buffer);
    $game_key_length = strlen($game_key);

    if ($encrypt == TRUE) {
      for ($i=1; $i<$buffer_length; $i++) { $buffer[$i] = chr(ord($buffer[$i]) ^ ord($buffer[$i-1])); }
      for ($i=0; $i<$buffer_length; $i++) { $buffer[$i] = chr(ord($buffer[$i]) ^ ord($game_key[($i%128) % $game_key_length]) ^ ord($master_key[$i%128]) ^ ord($master_key[$i])); }
    } else {
      for ($i=0; $i<$buffer_length; $i++) { $buffer[$i] = chr(ord($buffer[$i]) ^ ord($master_key[$i]) ^ ord($master_key[$i%128]) ^ ord($game_key[($i%128) % $game_key_length])); }
      for ($i=$buffer_length; $i>0; $i--) { $buffer[$i] = chr(ord($buffer[$i]) ^ ord($buffer[$i-1])); }
    }
  }

//------------------------------------------------------------------------------------------------------------+
//--------- PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT -----------+
//-------- WANNA BE HERE? https://github.com/tltneon/lgsl/wiki/Who-uses-LGSL -> LET CREDITS STAY :P ----------+

  function lgsl_version() {
    return "Powered by LGSL</a> | <a href='https://github.com/tltneon/lgsl/releases'>v " . LGSL::VERSION;
  }

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  } // END OF DOUBLE LOAD PROTECTION

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
