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
		const UDP = "udp";
		const TCP = "tcp";
		const HTTP = "http";
		// Query protocols
    const AARMY = "aarmy";
    const ALTV = "altv";
    const ARCASIMRACING = "arcasimracing";
    const ARKASCENDED = "arkascended";
    const ARMA = "arma";
    const ARMA2 = "arma2";
    const ARMA3 = "arma3";
    const AVP2 = "avp2";
    const BEAMMP = "beammp";
    const BFBC2 = "bfbc2";
    const BFVIETNAM = "bfvietnam";
    const BF1942 = "bf1942";
    const BF2 = "bf2";
    const BF3 = "bf3";
    const BF4 = "bf4";
    const BF2142 = "bf2142";
    const CALLOFDUTY = "callofduty";
    const CALLOFDUTYBO3 = "callofdutybo3";
    const CALLOFDUTYIW = "callofdutyiw";
    const CALLOFDUTYUO = "callofdutyuo";
    const CALLOFDUTYWAW = "callofdutywaw";
    const CALLOFDUTY2 = "callofduty2";
    const CALLOFDUTY4 = "callofduty4";
    const CNCRENEGADE = "cncrenegade";
    const CONANEXILES = "conanexiles";
    const CRYOFALL = "cryofall";
    const CRYSIS = "crysis";
    const CRYSISWARS = "crysiswars";
    const CS2D = "cs2d";
    const CUBE = "cube";
    const DISCORD = "discord";
    const DOOMSKULLTAG = "doomskulltag";
    const DOOM3 = "doom3";
    const DH2005 = "dh2005";
    const ECO = "eco";
    const FACTORIO = "factorio";
    const HAD2 = "had2";
    const HALFLIFE = "halflife";
    const HALFLIFEWON = "halflifewon";
    const HALO = "halo";
    const IL2 = "il2";
    const FARCRY = "farcry";
    const FEAR = "fear";
    const FIVEM = "fivem";
    const FLASHPOINT = "flashpoint";
    const FREELANCER = "freelancer";
    const FRONTLINES = "frontlines";
    const F1C9902 = "f1c9902";
    const GAMESPY1 = "gamespy1";
    const GAMESPY2 = "gamespy2";
    const GAMESPY3 = "gamespy3";
    const GHOSTRECON = "ghostrecon";
    const GRAW = "graw";
    const GRAW2 = "graw2";
    const GTAC = "gtac";
    const JEDIKNIGHT2 = "jediknight2";
    const JEDIKNIGHTJA = "jediknightja";
    const JC2MP = "jc2mp";
    const KILLINGFLOOR = "killingfloor";
    const KINGPIN = "kingpin";
    const M2MP = "m2mp";
    const MAFIAC = "mafiac";
    const MINECRAFT = "minecraft";
    const MINECRAFTPE = "minecraftpe";
    const MOHAA = "mohaa";
    const MOHAAB = "mohaab";
    const MOHAAS = "mohaas";
    const MOHPA = "mohpa";
    const MTA = "mta";
    const MUMBLE = "mumble";
    const NASCAR2004 = "nascar2004";
    const NECESSE = "necesse";
    const NEVERWINTER = "neverwinter";
    const NEVERWINTER2 = "neverwinter2";
    const NEXUIZ = "nexuiz";
    const OPENTTD = "openttd";
    const PAINKILLER = "painkiller";
    const PALWORLD = "palworld";
    const PALWORLDDIRECT = "palworlddirect";
    const PLAINSIGHT = "plainsight";
    const PREY = "prey";
    const QUAKEWORLD = "quakeworld";
    const QUAKEWARS = "quakewars";
    const QUAKE2 = "quake2";
    const QUAKE3 = "quake3";
    const QUAKE4 = "quake4";
    const RAGEMP = "ragemp";
    const RAVENSHIELD = "ravenshield";
    const REDORCHESTRA = "redorchestra";
    const RFACTOR = "rfactor";
    const SAMP = "samp";
    const SAVAGE = "savage";
    const SAVAGE2 = "savage2";
    const SERIOUSSAM = "serioussam";
    const SERIOUSSAM2 = "serioussam2";
    const SCUM = "scum";
    const SF = "sf";
    const SHATTEREDH = "shatteredh";
    const SOF2 = "sof2";
    const SOLDAT = "soldat";
    const SOURCE = "source";
    const SRB2 = "srb2";
    const STALKER = "stalker";
    const STALKERCOP = "stalkercop";
    const STALKERCS = "stalkercs";
    const STARTREKEF = "startrekef";
    const STARWARSBF = "starwarsbf";
    const STARWARSBF2 = "starwarsbf2";
    const STARWARSRC = "starwarsrc";
    const SWAT4 = "swat4";
    const TEEWORLDS = "teeworlds";
    const TERRARIA = "terraria";
    const TITANFALL2 = "titanfall2";
    const TRIBES2 = "tribes2";
    const TRIBESV = "tribesv";
    const TS = "ts";
    const TS3 = "ts3";
    const TEASPEAK = "teaspeak";
    const WARSOW = "warsow";
    const UNVANQUISHED = "unvanquished";
    const URBANTERROR = "urbanterror";
    const UT = "ut";
    const UT2003 = "ut2003";
    const UT2004 = "ut2004";
    const UT3 = "ut3";
    const VCMP = "vcmp";
    const VIETCONG = "vietcong";
    const VIETCONG2 = "vietcong2";
    const VINTAGESTORY = "vintagestory";
    const WINDWARD = "windward";
    const WOLFET = "wolfet";
    const WOLFRTCW = "wolfrtcw";
    const WOLF2009 = "wolf2009";
    const WOW = "wow";
    const TEST = "test";
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
    static public function lgslConnectionType($type) {
      $protocol = [
        self::ALTV          => self::HTTP,
        self::ARKASCENDED   => self::HTTP,
        self::BEAMMP        => self::HTTP,
        self::BFBC2         => self::TCP,
        self::BF3           => self::TCP,
        self::DISCORD       => self::HTTP,
        self::ECO           => self::HTTP,
        self::FIVEM         => self::HTTP,
        self::PALWORLD      => self::HTTP,
        self::PALWORLDDIRECT=> self::HTTP,
        self::RAGEMP        => self::HTTP,
        self::SCUM          => self::HTTP,
        self::TERRARIA      => self::HTTP,
        self::TITANFALL2    => self::HTTP,
        self::TS            => self::TCP,
        self::TS3           => self::TCP,
        self::TEASPEAK      => self::TCP,
        self::VINTAGESTORY  => self::TCP,
        self::WINDWARD      => self::TCP,
        self::WOW           => self::TCP
      ];
      return $protocol[$type] ?? self::UDP;
    }
    static public function lgslProtocolWithoutPort($type) {
      return in_array($type, [self::DISCORD, self::TITANFALL2]);
    }
    static public function lgslList($type = null) {
      $list = [
        self::AARMY         => ["Query09", "Americas Army"],
        self::ALTV          => ["Query53", "Alt:V"],
        self::ARCASIMRACING => ["Query16", "Arca Sim Racing"],
        self::ARKASCENDED   => ["Query52", "ARK: Survival Ascended"],
        self::ARMA          => ["Query09", "ArmA: Armed Assault"],
        self::ARMA2         => ["Query09", "ArmA 2"],
        self::ARMA3         => ["Query05", "ArmA 3 / DayZ"],
        self::AVP2          => ["Query03", "Aliens VS. Predator 2"],
        self::BEAMMP        => ["Query48", "BeamMP"],
        self::BFBC2         => ["Query30", "Battlefield Bad Company 2"],
        self::BFVIETNAM     => ["Query09", "Battlefield Vietnam"],
        self::BF1942        => ["Query03", "Battlefield 1942"],
        self::BF2           => ["Query06", "Battlefield 2"],
        self::BF3           => ["Query30", "Battlefield 3"],
        self::BF4           => ["Query06", "Battlefield 4"],
        self::BF2142        => ["Query06", "Battlefield 2142"],
        self::CALLOFDUTY    => ["Query02", "Call Of Duty"],
        self::CALLOFDUTYBO3 => ["Query05", "Call Of Duty: Black Ops 3"],
        self::CALLOFDUTYIW  => ["Query02", "Call Of Duty (Plutonium, AlterWare)"],
        self::CALLOFDUTYUO  => ["Query02", "Call Of Duty: United Offensive"],
        self::CALLOFDUTYWAW => ["Query02", "Call Of Duty: World at War"],
        self::CALLOFDUTY2   => ["Query02", "Call Of Duty 2"],
        self::CALLOFDUTY4   => ["Query02", "Call Of Duty 4 / CoD4X"],
        self::CNCRENEGADE   => ["Query03", "Command and Conquer: Renegade"],
        self::CONANEXILES   => ["Query05", "Conan Exiles"],
        self::CRYOFALL      => ["Query44", "Cryofall"],
        self::CRYSIS        => ["Query06", "Crysis"],
        self::CRYSISWARS    => ["Query06", "Crysis Wars"],
        self::CS2D          => ["Query29", "Counter-Strike 2D"],
        self::CUBE          => ["Query24", "Cube Engine"],
        self::DISCORD       => ["Query36", "Discord"],
        self::DOOMSKULLTAG  => ["Query27", "Doom (Zandronum)"],
        self::DOOM3         => ["Query10", "Doom 3"],
        self::DH2005        => ["Query09", "Deer Hunter 2005"],
        self::ECO           => ["Query40", "ECO"],
        self::FACTORIO      => ["Query42", "Factorio"],
        self::HAD2          => ["Query03", "Hidden and Dangerous 2"],
        self::HALFLIFE      => ["Query05", "Half-Life Steam Protocol (CS 1.6, etc)"],
        self::HALFLIFEWON   => ["Query05", "Half-Life WON Protocol [OLD] (CS 1.5)"],
        self::HALO          => ["Query03", "Halo"],
        self::IL2           => ["Query03", "IL-2 Sturmovik"],
        self::FARCRY        => ["Query08", "Far Cry"],
        self::FEAR          => ["Query09", "F.E.A.R."],
        self::FIVEM         => ["Query35", "FiveM / RedM"],
        self::FLASHPOINT    => ["Query03", "Operation Flashpoint"],
        self::FREELANCER    => ["Query14", "Freelancer"],
        self::FRONTLINES    => ["Query20", "Frontlines: Fuel Of War"],
        self::F1C9902       => ["Query03", "F1 Challenge 99-02"],
        self::GAMESPY1      => ["Query03", "Generic GameSpy 1"],
        self::GAMESPY2      => ["Query09", "Generic GameSpy 2"],
        self::GAMESPY3      => ["Query06", "Generic GameSpy 3"],
        self::GHOSTRECON    => ["Query19", "Ghost Recon"],
        self::GRAW          => ["Query06", "Ghost Recon: Advanced Warfighter"],
        self::GRAW2         => ["Query09", "Ghost Recon: Advanced Warfighter 2"],
        self::GTAC          => ["Query45", "GTA Connected"],
        self::JEDIKNIGHT2   => ["Query02", "JediKnight 2: Jedi Outcast"],
        self::JEDIKNIGHTJA  => ["Query02", "JediKnight: Jedi Academy"],
        self::JC2MP         => ["Query06", "Just Cause 2 Multiplayer"],
        self::KILLINGFLOOR  => ["Query13", "Killing Floor"],
        self::KINGPIN       => ["Query03", "Kingpin: Life of Crime"],
        self::M2MP          => ["Query39", "Mafia II Multiplayer"],
        self::MAFIAC        => ["Query45", "Mafia Connected"],
        self::MINECRAFT     => ["Query06", "Minecraft"],
        self::MINECRAFTPE   => ["Query54", "Minecraft Pocket/Bedrock Edition"],
        self::MOHAA         => ["Query03", "Medal of Honor: Allied Assault"],
        self::MOHAAB        => ["Query03", "Medal of Honor: Allied Assault Breakthrough"],
        self::MOHAAS        => ["Query03", "Medal of Honor: Allied Assault Spearhead"],
        self::MOHPA         => ["Query03", "Medal of Honor: Pacific Assault"],
        self::MTA           => ["Query08", "Multi Theft Auto"],
        self::MUMBLE        => ["Query43", "Mumble"],
        self::NASCAR2004    => ["Query09", "Nascar Thunder 2004"],
        self::NECESSE       => ["Query47", "Necesse"],
        self::NEVERWINTER   => ["Query09", "NeverWinter Nights"],
        self::NEVERWINTER2  => ["Query09", "NeverWinter Nights 2"],
        self::NEXUIZ        => ["Query02", "Nexuiz"],
        self::OPENTTD       => ["Query22", "Open Transport Tycoon Deluxe"],
        self::PAINKILLER    => ["Query08", "PainKiller"],
        self::PALWORLD      => ["Query51", "Palworld"],
        self::PALWORLDDIRECT=> ["Query55", "Palworld Direct"],
        self::PLAINSIGHT    => ["Query32", "Plain Sight"],
        self::PREY          => ["Query10", "Prey"],
        self::QUAKEWORLD    => ["Query07", "Quake World"],
        self::QUAKEWARS     => ["Query10", "Enemy Territory: Quake Wars"],
        self::QUAKE2        => ["Query02", "Quake 2"],
        self::QUAKE3        => ["Query02", "Quake 3"],
        self::QUAKE4        => ["Query10", "Quake 4"],
        self::RAGEMP        => ["Query34", "Rage:MP"],
        self::RAVENSHIELD   => ["Query04", "Raven Shield"],
        self::REDORCHESTRA  => ["Query13", "Red Orchestra"],
        self::RFACTOR       => ["Query16", "rFactor"],
        self::SAMP          => ["Query12", "San Andreas Multiplayer"],
        self::SAVAGE        => ["Query17", "Savage"],
        self::SAVAGE2       => ["Query18", "Savage 2"],
        self::SERIOUSSAM    => ["Query03", "Serious Sam"],
        self::SERIOUSSAM2   => ["Query09", "Serious Sam 2"],
        self::SCUM          => ["Query37", "SCUM"],
        self::SF            => ["Query41", "Satisfactory"],
        self::SHATTEREDH    => ["Query05", "Shattered Horizon"],
        self::SOF2          => ["Query02", "Soldier of Fortune 2"],
        self::SOLDAT        => ["Query08", "Soldat"],
        self::SOURCE        => ["Query05", "Source Protocol (Half-Life 2, etc.)"],
        self::SRB2          => ["Query46", "Sonic Robo Blast 2"],
        self::STALKER       => ["Query06", "S.T.A.L.K.E.R."],
        self::STALKERCOP    => ["Query09", "S.T.A.L.K.E.R. Call of Pripyat"],
        self::STALKERCS     => ["Query09", "S.T.A.L.K.E.R. Clear Sky"],
        self::STARTREKEF    => ["Query02", "StarTrek Elite-Force"],
        self::STARWARSBF    => ["Query09", "Star Wars: Battlefront"],
        self::STARWARSBF2   => ["Query09", "Star Wars: Battlefront 2"],
        self::STARWARSRC    => ["Query09", "Star Wars: Republic Commando"],
        self::SWAT4         => ["Query03", "SWAT 4"],
        self::TEEWORLDS     => ["Query21", "Teeworlds"],
        self::TERRARIA      => ["Query38", "Terraria"],
        self::TITANFALL2    => ["Query50", "Titanfall 2"],
        self::TRIBES2       => ["Query25", "Tribes 2"],
        self::TRIBESV       => ["Query09", "Tribes Vengeance"],
        self::TS            => ["Query33", "Teamspeak"],
        self::TS3           => ["Query33", "Teamspeak 3"],
        self::TEASPEAK      => ["Query33", "Teaspeak"],
        self::WARSOW        => ["Query02", "Warsow"],
        self::UNVANQUISHED  => ["Query02", "Unvanquished"],
        self::URBANTERROR   => ["Query02", "UrbanTerror"],
        self::UT            => ["Query03", "Unreal Tournament"],
        self::UT2003        => ["Query13", "Unreal Tournament 2003"],
        self::UT2004        => ["Query13", "Unreal Tournament 2004"],
        self::UT3           => ["Query11", "Unreal Tournament 3"],
        self::VCMP          => ["Query12", "Vice City Multiplayer"],
        self::VIETCONG      => ["Query03", "Vietcong"],
        self::VIETCONG2     => ["Query09", "Vietcong 2"],
        self::VINTAGESTORY  => ["Query56", "Vintage Story"],
        self::WINDWARD      => ["Query49", "Windward"],
        self::WOLFET        => ["Query02", "Wolfenstein: Enemy Territory"],
        self::WOLFRTCW      => ["Query02", "Wolfenstein: Return To Castle Wolfenstein"],
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
      $types = [ //            |C > Q |C def |Q def |C > S
        self::AARMY         => [1,     1716,  1717],
        self::ARCASIMRACING => [-100,  34397, 34297],
        self::ARMA3         => [0,     2302,  2303],
        self::BFBC2         => [0,     19567, 48888],
        self::BFVIETNAM     => [0,     15567, 23000],
        self::BF1942        => [0,     14567, 23000],
        self::BF2           => [0,     16567, 29900],
        self::BF3           => [22000, 25200, 47200],
        self::BF2142        => [0,     17567, 29900],
        self::CALLOFDUTYBO3 => [0,     27017, 27017],
        self::CUBE          => [1,     28785, 28786],
        self::DH2005        => [0,     23459, 34567],
        self::DISCORD       => [0,     1,     1],
        self::FACTORIO      => [0,     34197, 34197],
        self::FARCRY        => [123,   49001, 49124],
        self::FIVEM         => [0,     30120, 30120],
        self::FLASHPOINT    => [1,     2302,  2303],
        self::FRONTLINES    => [2,     5476,  5478],
        self::GHOSTRECON    => [2,     2346,  2348],
        self::HAD2          => [3,     11001, 11004],
        self::KINGPIN       => [-10,   31510, 31500],
        self::KILLINGFLOOR  => [1,     7708,  7709],
        self::MINECRAFT     => [0,     25565, 25565],
        self::MINECRAFTPE   => [0,     19132, 19132],
        self::MOHAA         => [97,    12203, 12300],
        self::MOHAAB        => [97,    12203, 12300],
        self::MOHAAS        => [97,    12203, 12300],
        self::MOHPA         => [97,    13203, 13300],
        self::MTA           => [123,   22003, 22126],
        self::PAINKILLER    => [123,   3455,  3578],
        self::RAGEMP        => [0,     22005, 22005],
        self::RAVENSHIELD   => [1000,  7777,  8777],
        self::REDORCHESTRA  => [1,     7758,  7759],
        self::RFACTOR       => [-100,  34397, 34297],
        self::SERIOUSSAM    => [1,     25600, 25601],
        self::SOLDAT        => [123,   23073, 23196],
        self::SF            => [0,     7777,  15777],
        self::STALKER       => [2,     5447,  5445],
        self::STALKERCOP    => [2,     5447,  5445],
        self::STALKERCS     => [2,     5447,  5445],
        self::STARWARSRC    => [0,     7777,  11138],
        self::SWAT4         => [1,     10780, 10781],
        self::TERRARIA      => [101,   7777,  7878],
        self::TITANFALL2    => [0,     1,     1],
        self::TRIBESV       => [1,     7777,  7778],
        self::TS            => [0,     8767,  51234],
        self::TS3           => [0,     9987,  10011],
        self::TEASPEAK      => [0,     9987,  10101],
        self::UT            => [1,     7777,  7778],
        self::UT2003        => [1,     7757,  7758,  10],
        self::UT2004        => [1,     7777,  7778,  10],
        self::UT3           => [0,     7777,  6500],
        self::VIETCONG      => [10000, 5425,  15425],
        self::VIETCONG2     => [0,     5001,  19967],
        self::VINTAGESTORY  => [0,     42420, 42420],
        self::WOW           => [0,     3724,  8085],
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
  
    public function lgslProtocolClass($type) {
      $list = $this->lgsl_protocol_list();
      return $list[$type] ?? "err";
    }
		public function updateTimestamps() {
			$this->_server->setTimestamp("sep", time());
		}
    public function query() {
      $protocol = $this->lgslConnectionType($this->_server->getType());
			$this->_lgsl_fp = new Stream($protocol);
			if ($status = $this->_lgsl_fp->open($this->_server)) {
        $query = __NAMESPACE__ . "\\" . $this->lgslProtocolClass($this->_server->getType());
        if (class_exists($query)) {
          $status = (new $query($this->_server, $this->_lgsl_fp, $this->_lgsl_need))->execute();
        } else {
          $this->_server->addOption('_error', "LGSL PROBLEM: FUNCTION DOES NOT EXIST FOR TYPE {$this->_server->getType()}");
          $this->updateTimestamps();
        }
			} else {
        $this->_server->addOption('_error', 'Can\'t establish the connection to server.');
				$this->updateTimestamps();
      }
      $this->_server->setStatus($status);
			$this->_lgsl_fp->close();
    }
  }

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+
	abstract class Query {
    const NO_RESPOND = 0;
    const SUCCESS = 1;
    const WITH_ERROR = 2;
    protected $_server, $_fp, $_need;
    protected $_data = ['s' => [], 'e' => [], 'p' => []];
    protected $separatedPackets = false;
		public function __construct(Server &$server, Stream &$fp, array &$need) {
      $this->_server = $server;
      $this->_fp = $fp;
      $this->_need = $need;
      return $this;
    }
    public function need($key): bool {
      if ($this->_need[$key]) {
        $this->_need[$key] = false;
        $this->_server->setTimestamp($key, time());
        return true;
      }
      return false;
    }
    abstract function process();
    public function execute(): int {
      $time = microtime(true);
      $status = $this->process();
      if ($status === $this::SUCCESS) {
        if ($this->separatedPackets) {
          if ($this->_need['e']) $status |= $this->process();
          if ($this->_need['p']) $status |= $this->process();
        } else {
          $this->_need = [
            's' => false,
            'e' => false,
            'p' => false
          ];
          $this->_server->setTimestamp("sep", time());
        }
        $this->_data['o']['conn_tries'] = 0;
      } else {
        $this->_data['o']['conn_tries'] = $this->_server->getConnectionTries() + 1;
        if ($this->_data['o']['conn_tries'] > 4) {
          $this->_server->setTimestamp("sep", time());
          $this->_data['o']['conn_tries'] = 5;
        }
        $this->_server->updateValues($this->_data);
      }
      $this->_data['o']['time_execution'] = $time - microtime(true);
      if ($status !== $this::NO_RESPOND) {
        if ($status === $this::SUCCESS) {
          $this->_server->removeOption("_error");
        }
        if ($status === $this::WITH_ERROR) {
          $this->_server->addOption("_error", "Probably protocol mistake: " . static::class);
        }
        $this->_server->updateValues($this->_data);
      } else {
        $this->_server->addOption("_error", "Successful ping but no correct answer");
      }
      return $status;
    }
	}
  abstract class QuerySocket extends Query {
    public function fetch($packet, $length = 4096) {
      $this->_fp->write($packet);
      return $this->_fp->read($length);
    }
  }
  abstract class QueryJson extends Query {
    public function fetch(string $url) {
      $this->_fp->write($url);
      return $this->_fp->readJson();
    }
  }
  abstract class QueryEOS extends QueryJson { // Epic Online Services
    protected $grant_type = "client_credentials";
    protected $deployment_id, $user_id, $user_secret;
    protected function filter($k) { return true; }
    public function process() {
      $ch = $this->_fp->getStream();
      // auth
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . base64_encode("{$this->user_id}:{$this->user_secret}"), 'Accept-Encoding: deflate, gzip', 'Content-Type: application/x-www-form-urlencoded']);
      $external_auth_add = "";
      if ($this->grant_type == "external_auth") {
        curl_setopt($ch, CURLOPT_POSTFIELDS, "deviceModel=PC");
        $buffer = $this->fetch("https://api.epicgames.dev/auth/v1/accounts/deviceid");
        if (!$buffer) return $this::NO_RESPOND;
        $external_auth_add = "&external_auth_type=deviceid_access_token&external_auth_token={$buffer['access_token']}&nonce=ABCHFA3qgUCJ1XTPAoGDEF&display_name=User";
      }
      curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type={$this->grant_type}&deployment_id={$this->deployment_id}{$external_auth_add}");
      $buffer = $this->fetch("https://api.epicgames.dev/auth/v1/oauth/token");
      if (!$buffer) return $this::NO_RESPOND;
      // request servers by ip
      curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer {$buffer['access_token']}", 'Accept: application/json', 'Content-Type: application/json']);
      curl_setopt($ch, CURLOPT_POSTFIELDS, '{"criteria": [{"key": "attributes.ADDRESS_s", "op": "EQUAL", "value": "' . $this->_server->getIp(true) . '"}], "maxResults": 200}'); // v1 not supported "op": "ANY_OF"
      $buffer = $this->fetch("https://api.epicgames.dev/matchmaking/v1/{$this->deployment_id}/filter");
      if (!$buffer || $buffer['count'] == 0) return $this::NO_RESPOND;
      // filtering by port
      $find = array_filter($buffer['sessions'], function($k) {
        return $this->filter($k);
      });
      if (!$find) return $this::NO_RESPOND;
      return $this->placeData(reset($find));
    }
    protected function placeData($buffer) {return 0;}
  }
  class QueryStatus extends QuerySocket { // Only status
    protected $packets = [];
    public function process(): int {
      $buffer = $this->fetch($this->packets[0]);
      if (!$buffer) return $this::NO_RESPOND;
      $this->_data['s']['name'] = Protocol::lgslList($this->_server->getType())[1] . " Server";
      $this->postProcess($buffer);
      return $this::SUCCESS;
    }
    public function postProcess(&$buffer) {}
  }
	/* Query 01-10 */

  class Query02 extends QuerySocket { // 
    public function process() {
      $type = $this->_server->getType();
      $isMoh = strpos($type, "moh") !== FALSE; // mohaa_ mohaab_ mohaas_ mohpa_
      $mohSymbol = $isMoh ? "\x02" : "";
      if     ($type === PROTOCOL::QUAKE2)       { $this->_fp->write("\xFF\xFF\xFF\xFFstatus");        }
      elseif ($type === PROTOCOL::CALLOFDUTYIW) { $this->_fp->write("\xFF\xFF\xFF\xFFgetinfo LGSL");  }
      else { $this->_fp->write("\xFF\xFF\xFF\xFF{$mohSymbol}getstatus"); }

      $buffer = $this->_fp->read();
      if (!$buffer) { return $this::NO_RESPOND; }

      $part = explode("\n", $buffer->getAll());  // SPLIT INTO PARTS: HEADER/SETTINGS/PLAYERS/FOOTER
      if ($type !== PROTOCOL::CALLOFDUTYIW) {
        array_pop($part);              // REMOVE FOOTER WHICH IS EITHER NULL OR "\challenge\"
      }
      $item = explode("\\", $part[1]); // SPLIT PART INTO ITEMS

      foreach ($item as $item_key => $data_key) {
        if (!($item_key % 2)) { continue; } // SKIP EVEN KEYS

        $s = 1;
        if ($item[0]) $s = 0; // IW4 HAS NO EXTRA "\"
        for ($i = $s; $i < count($item); $i += 2) { // SKIP EVEN KEYS
          $data_key               = strtolower(Helper::lgslParseColor($item[$i], "1"));
          $this->_data['e'][$data_key] = Helper::lgslParseColor($item[$i+1], "1");
        }
      }

      $this->_data['s']['name'] = $this->_data['e']['hostname'] ?? $this->_data['e']['sv_hostname'] ?? LGSL::NONE;
      if (isset($this->_data['e']['protocol']) && $type === PROTOCOL::CALLOFDUTYIW) {
        $games = ['1' => 'IW6', '2' => 'H1', '6' => 'IW3', '7' => 'T7', '20604' => 'IW5', '151' => 'IW4', '101' => 'T4'];
				$this->_data['s']['game'] = $games[$this->_data['e']['protocol']] ?? "Unknown {$this->_data['e']['protocol']}";
      }
      if (isset($this->_data['e']['gamename'])) { $this->_data['s']['game'] = $this->_data['e']['gamename']; }
      if (isset($this->_data['e']['gm'])) { $this->_data['s']['mode'] = $this->_data['e']['gm']; }
      if (isset($this->_data['e']['g_gametype'])) {
        if ($type === PROTOCOL::URBANTERROR) {
          $games = ["0" => "Free for All", "1" => "Last Man Standing", "3" => "Team Deathmatch", "4" => "Team Survivor", "5" => "Follow the Leader",
          "6" => "Capture and Hold", "7" => "Capture the Flag", "8" => "Bomb Mode", "9" => "Jump", "10" => "Freeze Tag", "11" => "Gun Game"];
        }
        $this->_data['s']['mode'] = $games[$this->_data['e']['g_gametype']] ?? $this->_data['e']['g_gametype'];
      }
      $this->_data['s']['map'] = $this->_data['e']['mapname'] ?? LGSL::NONE;
      $this->_data['s']['players'] = empty($part['2']) ? 0 : count($part) - 2;
      $this->_data['s']['playersmax'] = $this->_data['e']['maxclients'] ?? $this->_data['e']['sv_maxclients'] ?? 0;
      $this->_data['s']['password'] = (int) ($this->_data['e']['pswrd'] ?? $this->_data['e']['needpass'] ?? $this->_data['e']['g_needpass'] ?? 0);

      array_shift($part); // REMOVE HEADER
      array_shift($part); // REMOVE SETTING

      $fieldType = "other";
      if (strpos($type, "mohpa") !== FALSE) {
        $fieldType = "mohpa";
      } elseif ($isMoh) {
        $fieldType = "moh";
      } elseif (in_array($type, [PROTOCOL::NEXUIZ, PROTOCOL::WARSOW])) {
        $fieldType = $type;
      }
      $fieldsList = [
        PROTOCOL::NEXUIZ => ["pattern" => "/(.*) (.*) (.*)\"(.*)\"/U", "fields" => [1=>"score", 2=>"ping", 3=>"team", 4=>"name"]],
        PROTOCOL::WARSOW => ["pattern" => "/(.*) (.*) \"(.*)\" (.*)/", "fields" => [1=>"score", 2=>"ping", 3=>"name", 4=>"team"]],
        "mohpa"          => ["pattern" => "/(.*) (.*) (.*) (.*) (.*) \"(.*)\" \"(.*)\"/", "fields" => [2=>"score", 3=>"deaths", 4=>"time", 6=>"rank", 7=>"name"]],
        "moh"            => ["pattern" => "/(.*) \"(.*)\"/", "fields" => [1=>"ping", 2=>"name"]],
        "other"          => ["pattern" => "/(.*) (.*) \"(.*)\"/", "fields" => [1=>"score", 2=>"ping", 3=>"name"]]
      ];
      $pattern = $fieldsList[$fieldType]["pattern"];
      $fields = $fieldsList[$fieldType]["fields"];

      foreach ($part as $player_key => $data) {
        if (!$data) { continue; }
        preg_match($pattern, $data, $match);
        foreach ($fields as $match_key => $field_name) {
          if (isset($match[$match_key])) { $this->_data['p'][$player_key][$field_name] = trim($match[$match_key]); }
        }
        $this->_data['p'][$player_key]['name'] = Helper::lgslParseColor($this->_data['p'][$player_key]['name'], "1");
        if (isset($this->_data['p'][$player_key]['time'])) {
          $this->_data['p'][$player_key]['time'] = Helper::lgslTime($this->_data['p'][$player_key]['time']);
        }
      }
      return $this::SUCCESS;
    }
  }
  class Query03 extends QuerySocket { // GameSpy Generic 1
    protected $separatedPackets = true;
    public function process() {
      $isBf1942 = $this->_server->getType() === PROTOCOL::BF1942;
      if     ($this->_server->getType() == PROTOCOL::CNCRENEGADE) { $this->_fp->write("\\status\\"); }
      elseif ($this->need('s') || $this->need('e')) { $this->_fp->write("\\basic\\\\info\\\\rules\\"); $this->_need['e'] = FALSE; }
      elseif ($this->need('p')) { $this->_fp->write("\\players\\");}

      $buffer = "";
      $packet_count = 0;
      $packet_total = 20;

      do {
        $packet = $this->_fp->read();

        // QUERY PORT CHECK AS THE CONNECTION PORT WILL ALSO RESPOND
        if (!$packet || !$packet->has("\\")) { return $this::NO_RESPOND; }

        // REMOVE SLASH PREFIX
        if ($packet->get(0) == "\\") { $packet->skip(1); }

        while ($packet->length()) {
          $key   = strtolower($packet->cutString(0, "\\"));
          $value =       trim($packet->cutString(0, "\\"));

          // CHECK IF KEY IS PLAYER DATA
          if (preg_match("/(.*)_([0-9]+)$/", $key, $match)) {
            // SEPERATE TEAM NAMES
            if ($match[1] == "teamname") { $server['t'][$match[2]]['name'] = $value; continue; }

            // CONVERT TO LGSL STANDARD
            $name = ["player" => "name", "playername" => "name", "frags" => "score", "ngsecret" => "stats"];
            $match[1] = $name[$match[1]] ?? $match[1];

            $this->_data['p'][$match[2]][$match[1]] = $value; continue;
          }

          // SEPERATE QUERYID
          if ($key == "queryid") { $queryid = $value; continue; }

          // SERVER SETTING
          $this->_data['e'][$key] = $value;
        }

        // FINAL PACKET NUMBER IS THE TOTAL
        if (isset($this->_data['e']['final'])) {
          preg_match("/([0-9]+)\.([0-9]+)/", $queryid, $match);
          $packet_total = intval($match[2]);
          unset($this->_data['e']['final']);
        }

        $packet_count ++;
      }
      while ($packet_count < $packet_total);

      if (isset($this->_data['e']['mapname'])) {
        $this->_data['s']['map'] = $this->_data['e']['mapname'];

        if (!empty($this->_data['e']['hostname']))    { $this->_data['s']['name'] = LGSL::removeChars($this->_data['e']['hostname']); }
        if (!empty($this->_data['e']['sv_hostname'])) { $this->_data['s']['name'] = $this->_data['e']['sv_hostname']; }

        if (isset($this->_data['e']['password']))   { $this->_data['s']['password']   = $this->_data['e']['password']; }
        if (isset($this->_data['e']['numplayers'])) { $this->_data['s']['players']    = $this->_data['e']['numplayers']; }
        if (isset($this->_data['e']['maxplayers'])) { $this->_data['s']['playersmax'] = $this->_data['e']['maxplayers']; }

        if (!empty($this->_data['e']['gamename']))                                   { $this->_data['s']['game'] = $this->_data['e']['gamename']; }
        if (!empty($this->_data['e']['gameid']) && empty($this->_data['e']['gamename']))  { $this->_data['s']['game'] = $this->_data['e']['gameid']; }
        if (!empty($this->_data['e']['gameid']) && $isBf1942) { $this->_data['s']['game'] = $this->_data['e']['gameid']; }
        
        if (!empty($this->_data['e']['gametype'])) { $this->_data['s']['mode'] = $this->_data['e']['gametype']; }
      }

      if ($this->_data['s']['players'] > 0 && isset($this->_data['p'])) {
        if ($isBf1942 && $this->_data['s']['players']) { // BF1942 BUG - REMOVE 'GHOST' PLAYERS
          $this->_data['p'] = array_slice($this->_data['p'], 0, $this->_data['s']['players']);
        }

        if ($this->_server->getType() === PROTOCOL::FLASHPOINT) { // OPERATION FLASHPOINT BUG: 'GHOST' PLAYERS IN UN-USED 'TEAM' FIELD
          foreach ($this->_data['p'] as $key => $value) {
            unset($this->_data['p'][$key]['team']);
          }
        }

        if ($this->_server->getType() === PROTOCOL::AVP2) { // AVP2 BUG: PLAYER NUMBER PREFIXED TO NAMES
          foreach ($this->_data['p'] as $key => $value) {
            $this->_data['p'][$key]['name'] = preg_replace("/[0-9]+~/", "", $this->_data['p'][$key]['name']);
          }
        }

        if (isset($this->_data['t'][0]['name'])) { // IF TEAM NAMES AVAILABLE USED INSTEAD OF TEAM NUMBERS
          foreach ($this->_data['p'] as $key => $value) {
            $team_key = $this->_data['p'][$key]['team'] - 1;
            $this->_data['p'][$key]['team'] = $this->_data['t'][$team_key]['name'];
          }
        }
        $this->_data['p'] = array_values($this->_data['p']); // RE-INDEX PLAYER KEYS TO REMOVE ANY GAPS
      }
      return $this::SUCCESS;
    }
  }
  class Query04 extends QuerySocket { // Raven Shield
    public function process() {
      $buffer = $this->fetch("REPORT");
      if (!$buffer) return $this::NO_RESPOND;

      $lgsl_ravenshield_key = ["A1" => "playersmax", "A2" => "tkpenalty", "B1" => "players", "B2" => "allowradar", "D2" => "version", "E1" => "mapname", "E2" => "lid",
      "F1" => "maptype", "F2" => "gid", "G1" => "password", "G2" => "hostport", "H1" => "dedicated", "H2" => "terroristcount", "I1" => "hostname", "I2" => "aibackup",
      "J1" => "mapcycletypes", "J2" => "rotatemaponsuccess", "K1" => "mapcycle", "K2" => "forcefirstpersonweapons", "L1" => "players_name", "L2" => "gamename",
      "L3" => "punkbuster", "M1" => "players_time", "N1" => "players_ping", "O1" => "players_score", "P1" => "queryport", "Q1" => "rounds", "R1" => "roundtime",
      "S1" => "bombtimer", "T1" => "bomb", "W1" => "allowteammatenames", "X1" => "iserver", "Y1" => "friendlyfire", "Z1" => "autobalance"];

      $item = explode("\xB6", $buffer->getAll());
      foreach ($item as $data_value) {
        $tmp = explode(" ", $data_value, 2);
        $data_key = $lgsl_ravenshield_key[$tmp[0]] ?? $tmp[0]; // CONVERT TO DESCRIPTIVE KEYS
        $this->_data['e'][$data_key] = trim($tmp[1]); // ALL VALUES NEED TRIMMING
      }

      $this->_data['e']['mapcycle']      = str_replace("/", " | ", $this->_data['e']['mapcycle']);      // CONVERT SLASH TO SPACE
      $this->_data['e']['mapcycletypes'] = str_replace("/", " | ", $this->_data['e']['mapcycletypes']); // SO LONG LISTS WRAP
      $this->_data['s']['game']       = $this->_data['e']['gamename'];
      $this->_data['s']['name']       = $this->_data['e']['hostname'];
      $this->_data['s']['map']        = $this->_data['e']['mapname'];
      $this->_data['s']['players']    = $this->_data['e']['players'];
      $this->_data['s']['playersmax'] = $this->_data['e']['playersmax'];
      $this->_data['s']['password']   = $this->_data['e']['password'];

      $fields = ['name', 'time', 'ping', 'score'];
      if ($this->_data['s']['players'] > 0) {
        $playerData = [];
        $fields = ['name', 'time', 'ping', 'score'];
        foreach ($fields as $field) {
          $playerData["players_$field"] = isset($this->_data['e']["players_$field"]) ? explode("/", substr($this->_data['e']["players_$field"],  1)) : [];
        }

        foreach ($playerData['players_name'] as $key => $name) {
          foreach ($fields as $field) {
            $this->_data['p'][$key][$field]  = $playerData["players_$field"][$key];
          }
        }
      }
      foreach ($fields as $field) {
        unset($this->_data['e']["players_$field"]);
      }
      return $this::SUCCESS;
    }
  }
  class Query05 extends QuerySocket { // A2S Source Query Protocol
    protected $separatedPackets = true;
    public function process() {
      $xf = "\xFF\xFF\xFF\xFF";
      $isOldProtocol = $this->_server->getType() === PROTOCOL::HALFLIFEWON;
      $challenge_code = isset($this->_need['challenge']) ? $this->_need['challenge'] : "\x00\x00\x00\x00";
      $packets = [
        ['s' => "{$xf}details\x00", 'e' => "{$xf}rules\x00", 'p' => "{$xf}players\x00"],
        ['s' => "{$xf}\x54Source Engine Query\x00{$challenge_code}", 'e' => "{$xf}\x56{$challenge_code}", 'p' => "{$xf}\x55{$challenge_code}"],
      ];
      foreach (['s', 'e', 'p'] as $key) {
        if ($this->_need[$key]) $this->_fp->write($packets[((int) !$isOldProtocol)][$key]);
      }

      //---------------------------------------------------------+
      //  THE STANDARD HEADER POSITION REVEALS THE TYPE BUT IT MAY NOT ARRIVE FIRST
      //  ONCE WE KNOW THE TYPE WE CAN FIND THE TOTAL NUMBER OF PACKETS EXPECTED

      $packet_temp  = [];
      $packet_type  = 0;
      $packet_count = 0;
      $packet_total = 4;

      do {
        if (!($packet = $this->_fp->read())) {
          if ($this->_need['s']) { return $this::NO_RESPOND; }
          else { $this->need('e'); return $this::WITH_ERROR; }
        }

        //---------------------------------------------------------------------------------------------------------------------------------+
        // NEWER HL1 SERVERS REPLY TO A2S_INFO WITH 3 PACKETS ( HL1 FORMAT INFO, SOURCE FORMAT INFO, PLAYERS )
        // THIS DISCARDS UN-EXPECTED PACKET FORMATS ON THE GO ( AS READING IN ADVANCE CAUSES TIMEOUT DELAYS FOR OTHER SERVER VERSIONS )
        // ITS NOT PERFECT AS [s] CAN FLIP BETWEEN HL1 AND SOURCE FORMATS DEPENDING ON ARRIVAL ORDER ( MAYBE FIX WITH RETURN ON HL1 APPID )
        if     ($this->_need['s']) { if ($packet->char(4) == "D") { continue; } }
        elseif ($this->_need['e']) { if ($packet->char(4) == "m" || $packet->char(4) == "I" || $packet->char(4) == "D") { continue; } }
        elseif ($this->_need['p']) { if ($packet->char(4) == "m" || $packet->char(4) == "I") { continue; } }
        //---------------------------------------------------------------------------------------------------------------------------------+

        if     ($packet->get(0,  5) == "{$xf}\x41") { $this->_need['challenge'] = $packet->get(5, 4); return $this->process(); } // REPEAT WITH GIVEN CHALLENGE CODE
        elseif ($packet->get(0,  4) == "{$xf}")     { $packet_total = 1;                           $packet_type = 1;       } // SINGLE PACKET - HL1 OR HL2
        elseif ($packet->get(9,  4) == "{$xf}")     { $packet_total = ord($packet->char(8)) & 0xF; $packet_type = 2;       } // MULTI PACKET  - HL1 ( TOTAL IS LOWER NIBBLE OF BYTE )
        elseif ($packet->get(12, 4) == "{$xf}")     { $packet_total = ord($packet->char(8));       $packet_type = 3;       } // MULTI PACKET  - HL2
        elseif ($packet->get(18, 2) == "BZ")        { $packet_total = ord($packet->char(8));       $packet_type = 4;       } // BZIP PACKET   - HL2

        $packet_count ++;
        $packet_temp[] = $packet;
      }
      while ($packet && $packet_count < $packet_total);

      if ($packet_type == 0) { return $this->_data['s'] ? $this::SUCCESS : $this::NO_RESPOND; } // UNKNOWN RESPONSE ( SOME SERVERS ONLY SEND [s] )

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
          $this->_data['e']['_bzip2'] = "unavailable";
          $this->need('e');
          return $this::SUCCESS;
        }

        $buffer->set(bzdecompress($buffer->getAll()));
      }

      $header = $buffer->cutByte(4);
      if ($header != $xf) { return $this::NO_RESPOND; } // SOMETHING WENT WRONG

      $response_type = $buffer->cutByte();
      if ($response_type === "I" || $response_type === "m") { // SOURCE AND HALF-LIFE 1 INFO
        if ($isOldProtocol) {
        $buffer->cutString();
        } else {
        $this->_data['e']['netcode']     = $buffer->cutByteOrd();
        }
        $this->_data['s']['name']        = $buffer->cutString();
        $this->_data['s']['map']         = $buffer->cutString();
        $this->_data['s']['game']        = $buffer->cutString();
        $this->_data['e']['description'] = $buffer->cutString();
        if (!$isOldProtocol) {
        $this->_data['e']['appid']       = $buffer->cutByteUnpack(2, "S");
        }
        $this->_data['s']['players']     = $buffer->cutByteOrd();
        $this->_data['s']['playersmax']  = $buffer->cutByteOrd();
        $this->_data['e']['bots']        = $buffer->cutByteOrd();
        $this->_data['e']['dedicated']   = $buffer->cutByte();
        $this->_data['e']['os']          = $buffer->cutByte();
        $this->_data['s']['password']    = $buffer->cutByteOrd();
        if ($isOldProtocol) {
          if ($buffer->cutByteOrd()) { // MOD FIELDS ( OFF FOR SOME HALFLIFEWON-VALVE SERVERS )
            $this->_data['e']['mod_url_info']     = $buffer->cutString();
            $this->_data['e']['mod_url_download'] = $buffer->cutString();
            $buffer->skip(1);
            $this->_data['e']['mod_version']      = $buffer->cutByteUnpack(4, "l");
            $this->_data['e']['mod_size']         = $buffer->cutByteUnpack(4, "l");
            $this->_data['e']['mod_server_side']  = $buffer->cutByteOrd();
            $this->_data['e']['mod_custom_dll']   = $buffer->cutByteOrd();
          }
        }
        $this->_data['e']['anticheat']   = $buffer->cutByteOrd();
        $this->_data['e']['version']     = $buffer->cutString();
        if (!$isOldProtocol) {
          $buffer->skip(6);
          if ($buffer->cutByteOrd() === 177) {
            $buffer->skip(4);
          }
          $this->_data['e']['tags']        = $buffer->cutString();

          if ($this->_data['s']['game'] === 'rust') {
            preg_match('/cp\d{1,3}/', $this->_data['e']['tags'], $e);
            $this->_data['s']['players'] = substr($e[0], 2);
            preg_match('/mp\d{1,3}/', $this->_data['e']['tags'], $e);
            $this->_data['s']['playersmax'] = substr($e[0], 2);
          }
        }
        
        $mode = explode('_', $this->_data['s']['map'])[0];
        $modes = ['gg' => 'gungame', 'zm' => 'zombiemod', 'dm' => 'deathmatch', 'ze' => 'zombie escape', 'jail' => 'jailbreak', 'deathrun' => 'deathrun', 'rp' => 'roleplay',
        'ctf' => 'capture the flag', 'cp' => 'control point'];
        $this->_data['s']['mode'] = $modes[$mode] ?? 'none';

        $this->need('s');
      } elseif ($response_type === "D") { // SOURCE AND HALF-LIFE 1 PLAYERS
        $buffer->skip(1);
        $player_key = 0;
        while ($buffer->length() > 4) {
          $buffer->skip(1);
          $this->_data['p'][$player_key]['name']  = $buffer->cutString();
          if (strlen($this->_data['p'][$player_key]['name']) === 0) $this->_data['p'][$player_key]['name']  = "*unknown*";
          $this->_data['p'][$player_key]['score'] = $buffer->cutByteUnpack(4, "l");
          $this->_data['p'][$player_key]['time']  = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
          $player_key ++;
        }
        $this->need('p');
      } elseif ($response_type === "E") { // SOURCE AND HALF-LIFE 1 RULES
        $buffer->skip(2);
        while ($buffer->length() > 0) {
          $this->_data['e'][strtolower($buffer->cutString())] = $buffer->cutString();
        }
        $this->need('e');
      }
      return $this::SUCCESS;
    }
  }
  class Query06 extends QuerySocket { // Generic GameSpy 3
    public function process() {
      $challenge_code = "";
      if (!in_array($this->_server->getType(), [PROTOCOL::BF2, PROTOCOL::GRAW])) {
        $buffer = $this->fetch("\xFE\xFD\x09\x21\x21\x21\x21\xFF\xFF\xFF\x01");
        if (!$buffer) return $this::NO_RESPOND;
        $buffer->skip(5, 1); // REMOVE HEADER AND TRAILING NULL
        $challenge_code = $buffer->get(0);

        // IF CODE IS RETURNED ( SOME STALKER SERVERS RETURN BLANK WHERE THE CODE IS NOT NEEDED )
        // CONVERT DECIMAL |TO| HEX AS 8 CHARACTER STRING |TO| 4 PAIRS OF HEX |TO| 4 PAIRS OF DECIMAL |TO| 4 PAIRS OF ASCII

        $challenge_code = $challenge_code ? chr($challenge_code >> 24).chr($challenge_code >> 16).chr($challenge_code >> 8).chr($challenge_code >> 0) : "";
      }

      $this->_fp->write("\xFE\xFD\x00\x21\x21\x21\x21{$challenge_code}\xFF\xFF\xFF\x01");

      //---------------------------------------------------------+
      //  GET RAW PACKET DATA

      $buffer = [];
      $packet_count = 0;
      $packet_total = 4;

      do {
        $packet_count ++;
        $packet = $this->_fp->read(8192);

        if (!$packet) { return $this::NO_RESPOND; }

        $packet->skip(14); // REMOVE SPLITNUM HEADER
        $packet_order = $packet->cutByteOrd();

        if ($packet_order >= 128) { // LAST PACKET - SO ITS ORDER NUMBER IS ALSO THE TOTAL
          $packet_order -= 128;
          $packet_total = $packet_order + 1;
        }

        $buffer[$packet_order] = $packet;
        if ($this->_server->getType() == "minecraft" || $this->_server->getType() == "jc2mp") { $packet_total = 1; }

      }
      while ($packet_count < $packet_total);

      //---------------------------------------------------------+
      //  PROCESS AND SORT PACKETS
			
			if ($packet_total > 1) {
				foreach ($buffer as $key => $packet) {
					$packet->skip(0, 1); // REMOVE END NULL FOR JOINING

					if ($packet->get(-1) != "\x00") { // LAST VALUE HAS BEEN SPLIT
						$part = explode("\x00", $packet->getAll()); // REMOVE SPLIT VALUE AS COMPLETE VALUE IS IN NEXT PACKET
						array_pop($part);
						$packet->set(implode("\x00", $part)."\x00");
					}

					if ($packet->char(0) != "\x00") { // PLAYER OR TEAM DATA THAT MAY BE A CONTINUATION
						$pos = $packet->pos("\x00") + 1; // WHEN DATA IS SPLIT THE NEXT PACKET STARTS WITH A REPEAT OF THE FIELD NAME

						if ($packet->char($pos) && $packet->char($pos) != "\x00") { // REPEATED FIELD NAMES END WITH \x00\x?? INSTEAD OF \x00\x00
							$packet = $packet->get($pos + 1); // REMOVE REPEATED FIELD NAME
						} else {
							$packet->set("\x00".$packet->getAll()); // RE-ADD NULL AS PACKET STARTS WITH A NEW FIELD
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
        $this->_data['e'][$key] = $buffer->cutString();
      }

      $lgsl_conversion = ["hostname"=>"name", "gamename"=>"game", "mapname"=>"map", "gametype"=>"mode", "gamemode"=>"mode", "map"=>"map", "numplayers"=>"players", "maxplayers"=>"playersmax", "password"=>"password"];
      foreach ($lgsl_conversion as $e => $s) { if (isset($this->_data['e'][$e])) { $this->_data['s'][$s] = $this->_data['e'][$e]; unset($this->_data['e'][$e]); } }

      if (in_array($this->_server->getType(), [PROTOCOL::BF2, PROTOCOL::BF2142])) {
        $this->_data['s']['map'] = ucwords(str_replace("_", " ", $this->_data['s']['map']));
      } elseif ($this->_server->getType() === PROTOCOL::JC2MP) {
        $this->_data['s']['map'] = 'Panau'; // MAP NAME CONSISTENCY
      } elseif ($this->_server->getType() === PROTOCOL::MINECRAFT) {
        if (isset($this->_data['e']['gametype'])) {
          $this->_data['s']['game'] = strtolower($this->_data['e']['game_id']);
        }
        $this->_data['s']['name'] = Helper::lgslParseColor($this->_data['s']['name'], "minecraft");
        foreach ($this->_data['e'] as $key => $val) {
          if (($key != 'version') && ($key != 'plugins') && ($key != 'whitelist')) {
            unset($this->_data['e'][$key]);
          }
        }

        $plugins = explode(": ", $server['e']['plugins'], 2);
        if ($plugins[0]) {
          $this->_data['e']['plugins'] = $plugins[0];
        } else {
          $this->_data['e']['plugins'] = 'none (vanilla)';
        }
        if (count($plugins) == 2) {
          while ($key = Helper::lgslCutString($plugins[1], 0, " ")) {
            $this->_data['e'][$key] = Helper::lgslCutString($plugins[1], 0, "; ");
          }
        }
        $buffer->add("\x00"); // Needed to correctly terminate the players list
      }
      if (empty($this->_data['s']['players']) || $this->_data['s']['players'] == "0") { return $this::SUCCESS; } // IF SERVER IS EMPTY SKIP THE PLAYER CODE

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
          $this->_data['p'][$key][$field] = $value;
        }
      }

      //---------------------------------------------------------+
      //  TEAM DATA

      $buffer->skip(1); // REMOVE HEADER \x02

      while ($buffer->length() > 0) {
        if ($buffer->get(0) == "\x00") { break; }

        $field = $buffer->cutString(0, "\x00\x00");
        $field = strtolower($field);

        if     ($field == "team_t")  { $field = "name";  }
        elseif ($field == "score_t") { $field = "score"; }

        $value_list = $buffer->cutString(0, "\x00\x00");
        $value_list = explode("\x00", $value_list);

        foreach ($value_list as $key => $value) {
          $this->_data['t'][$key][$field] = $value;
        }
      }

      //---------------------------------------------------------+
      //  TEAM NAME CONVERSION

      if ($this->_data['p'] && isset($this->_data['t'][0]['name']) && $this->_data['t'][0]['name'] != "Team") {
        foreach ($this->_data['p'] as $key => $value) {
          if (empty($this->_data['p'][$key]['team'])) { continue; }

          $team_key = $this->_data['p'][$key]['team'] - 1;

          if (!isset($this->_data['t'][$team_key]['name'])) { continue; }

          $this->_data['p'][$key]['team'] = $this->_data['t'][$team_key]['name'];
        }
      }

      return $this::SUCCESS;
    }
  }
  class Query07 extends QuerySocket { // Quake World
    public function process() {
      $buffer = $this->fetch("\xFF\xFF\xFF\xFFstatus\x00");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(6, 2); // REMOVE HEADER AND FOOTER
      $part = explode("\n", $buffer->getAll()); // SPLIT INTO SETTINGS/PLAYER/PLAYER/PLAYER

      $item = explode("\\", $part[0]);
      foreach ($item as $item_key => $data_key) {
        if ($item_key % 2) { continue; } // SKIP ODD KEYS
        $data_key = strtolower($data_key);
        $this->_data['e'][$data_key] = $item[$item_key+1];
      }

      array_shift($part); // REMOVE SETTINGS
      $this->_data['p'] = [];
      foreach ($part as $key => $data) {
        preg_match("/(.*) (.*) (.*) (.*) \"(.*)\" \"(.*)\" (.*) (.*)/s", $data, $match); // GREEDY MATCH FOR SKINS

        $this->_data['p'][$key]['pid']         = $match[1];
        $this->_data['p'][$key]['score']       = $match[2];
        $this->_data['p'][$key]['time']        = $match[3];
        $this->_data['p'][$key]['ping']        = $match[4];
        $this->_data['p'][$key]['name']        = Helper::lgslParseColor($match[5], $this->_server->getType());
        $this->_data['p'][$key]['skin']        = $match[6];
        $this->_data['p'][$key]['skin_top']    = $match[7];
        $this->_data['p'][$key]['skin_bottom'] = $match[8];
      }

      $this->_data['s']['game']       = $this->_data['e']['*gamedir'];
      $this->_data['s']['name']       = $this->_data['e']['hostname'];
      $this->_data['s']['map']        = $this->_data['e']['map'];
      $this->_data['s']['players']    = $this->_data['p'] ? count($this->_data['p']) : 0;
      $this->_data['s']['playersmax'] = $this->_data['e']['maxclients'];
      $this->_data['s']['password']   = isset($this->_data['e']['needpass']) && $this->_data['e']['needpass'] > 0 && $this->_data['e']['needpass'] < 4 ? 1 : 0;
      return $this::SUCCESS;
    }
  }
  class Query08 extends QuerySocket { // All Seeing Eye | MTA
    public function process() {
      $buffer = $this->fetch("s");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(4); // REMOVE HEADER
      $this->_data['e']['gamename']   = $buffer->cutPascal(1, -1);
      $this->_data['e']['hostport']   = $buffer->cutPascal(1, -1);
      $this->_data['s']['name']       = Helper::lgslParseColor($buffer->cutPascal(1, -1), $this->_server->getType());
      $this->_data['e']['gamemode']   = $buffer->cutPascal(1, -1);
      $this->_data['s']['map']        = $buffer->cutPascal(1, -1);
      $this->_data['e']['version']    = $buffer->cutPascal(1, -1);
      $this->_data['s']['password']   = $buffer->cutPascal(1, -1);
      $this->_data['s']['players']    = $buffer->cutPascal(1, -1);
      $this->_data['s']['playersmax'] = $buffer->cutPascal(1, -1);

      while ($buffer->length() > 0 && $buffer->char(0) != "\x01") {
        $item_key   = strtolower($buffer->cutPascal(1, -1));
        $item_value = $buffer->cutPascal(1, -1);

        $server['e'][$item_key] = $item_value;
      }
      $buffer->skip(1); // REMOVE END MARKER

      $player_key = 0;
      $fields = [
        "farcryconnecting" => ["name", "score", "", "time"],
        Protocol::FARCRY => ["name", "team", "", "score", "ping", "time"],
        Protocol::MTA => ["name", "", "", "score", "ping", ""],
        Protocol::PAINKILLER => ["name", "", "skin", "score", "ping", ""],
        Protocol::SOLDAT => ["name", "team", "", "score", "ping", "time"]
      ];

      while ($buffer->length() > 0) {
        $bit_flags = $buffer->cutByte(); // FIELDS HARD CODED BELOW BECAUSE GAMES DO NOT USE THEM PROPERLY

        if ($bit_flags === "\x3D") {
          $field_list = $fields["farcryconnecting"]; // FARCRY PLAYERS CONNECTING
        } else {
          $field_list = $fields[$this->_server->getType()];
        }

        foreach ($field_list as $item_key) {
          $item_value = $buffer->cutPascal(1, -1);
          if (!$item_key) { continue; }
          if ($item_key === "name") { Helper::lgslParseColor($item_value, $this->_server->getType()); }
          $this->_data['p'][$player_key][$item_key] = $item_value;
        }
        $player_key ++;
      }
      return $this::SUCCESS;
    }
  }
  class Query09 extends QuerySocket { // GameSpy QR2 | SERIOUS SAM 2 | STALKER | ArmA 2
    public function process() {
      if ($this->_server->getType() === Protocol::SERIOUSSAM2) { $this->_need['p'] = FALSE; } // SERIOUS SAM 2 RETURNS ALL PLAYER NAMES AS "Unknown Player" SO SKIP ANY PLAYER REQUESTS
      if ($this->need('s') || $this->need('e')) {
        $this->_need['e'] = FALSE;
        $buffer = $this->fetch("\xFE\xFD\x00\x21\x21\x21\x21\xFF\x00\x00\x00");
        if (!$buffer) return $this::NO_RESPOND;

        $buffer->skip(5, 2); // REMOVE HEADER AND FOOTER
        $item = explode("\x00", $buffer->getAll());

        foreach ($item as $item_key => $data_key) {
          if ($item_key % 2) { continue; } // SKIP EVEN KEYS

          $data_key = strtolower($data_key);
          $this->_data['e'][$data_key] = $item[$item_key+1];
        }

        $this->_data['s']['name']       = $this->_data['e']['hostname'] ?? "";
        $this->_data['s']['map']        = $this->_data['e']['mapname'] ?? "";
        $this->_data['s']['players']    = $this->_data['e']['numplayers'] ?? "";
        $this->_data['s']['playersmax'] = $this->_data['e']['maxplayers'] ?? "";
        $this->_data['s']['password']   = $this->_data['e']['password'] ?? "";
        $this->_data['s']['mode']       = $this->_data['e']['gametype'] ?? "";

        if (!empty($this->_data['e']['gamename']))   { $this->_data['s']['game'] = $this->_data['e']['gamename']; }   // AARMY
        if (!empty($this->_data['e']['gsgamename'])) { $this->_data['s']['game'] = $this->_data['e']['gsgamename']; } // FEAR
        if (!empty($this->_data['e']['game_id']))    { $this->_data['s']['game'] = $this->_data['e']['game_id']; }    // BFVIETNAM

        if (in_array($this->_server->getType(), [Protocol::ARMA, Protocol::ARMA2])) {
          $this->_data['s']['map'] = $this->_data['e']['mission'];
        } elseif ($this->_server->getType() === Protocol::VIETCONG2) {
          $this->_data['e']['extinfo_autobalance'] = Helper::bool(ord($this->_data['e']['extinfo'][18]) === 2);
        }
      }
      if ($this->need('p') && $this->_data['s']['players']) {
        $buffer = $this->fetch("\xFE\xFD\x00\x21\x21\x21\x21\x00\xFF\x00\x00");
        if (!$buffer) return $this::WITH_ERROR;

        $buffer->skip(7, 1); // REMOVE HEADER / PLAYER TOTAL / FOOTER
        if (!$buffer->has("\x00\x00")) { return $this::SUCCESS; } // NO PLAYERS

        $buffer     = explode("\x00\x00", $buffer->getAll(), 2); // SPLIT FIELDS FROM ITEMS
        $buffer[0]  = str_replace("_",      "",     $buffer[0]); // REMOVE UNDERSCORES FROM FIELDS
        $buffer[0]  = str_replace("player", "name", $buffer[0]); // LGSL STANDARD
        $field_list = explode("\x00", $buffer[0]);               // SPLIT UP FIELDS
        $item       = explode("\x00", $buffer[1]);               // SPLIT UP ITEMS

        $item_position = 0;
        $item_total    = count($item);
        $player_key    = 0;

        do {
          foreach ($field_list as $field) {
            $this->_data['p'][$player_key][$field] = iconv('cp1251//IGNORE', 'utf-8//IGNORE', $item[$item_position]);
            $item_position ++;
          }
          $player_key ++;
        }
        while ($item_position < $item_total);
      }
      return $this::SUCCESS;
    }
  }
  class Query10 extends QuerySocket { // QUAKEWARS | QUAKE4 | DOOM3 | PREY
    public function process() {
      $quakewars = $this->_server->getType() === Protocol::QUAKEWARS;
      $ex = ($quakewars ? "EX" : "");
      $buffer = $this->fetch("\xFF\xFFgetInfo{$ex}\xFF");
      if (!$buffer) return $this::NO_RESPOND;

      if ($quakewars) { $buffer->skip(10); } // REMOVE HEADERS
      $buffer->skip(23);
      $buffer->set(Helper::lgslParseColor($buffer->getAll(), "2"));
      while ($buffer->length() && $buffer->get() != "\x00") {
        $this->_data['e'][strtolower($buffer->cutString())] = $buffer->cutString();
      }
      $buffer->skip(2);

      $player_key = 0;
      if ($quakewars) { // QUAKEWARS: (PID)(PING)(NAME)(TAGPOSITION)(TAG)(BOT)
        while ($buffer->length() && $buffer->get() != "\x20") { // STOPS AT PID 32
          $this->_data['p'][$player_key]['pid']  = $buffer->cutByteOrd();
          $this->_data['p'][$player_key]['ping'] = $buffer->cutByteUnpack(2, "S");
          $this->_data['p'][$player_key]['name'] = $buffer->cutString();
          $player_tag_position              = $buffer->cutByte();
          $player_tag                       = $buffer->cutString();
          $this->_data['p'][$player_key]['bot']  = $buffer->cutByteOrd();

          if ($player_tag_position == "1") { $this->_data['p'][$player_key]['name'] .= " {$player_tag}"; }
          elseif ($player_tag_position != "") { $this->_data['p'][$player_key]['name'] = "{$player_tag} {$this->_data['p'][$player_key]['name']}"; }
          $player_key ++;
        }

        $buffer->skip(1);
        $this->_data['e']['si_osmask']    = $buffer->cutByteUnpack(4, "I");
        $this->_data['e']['si_ranked']    = $buffer->cutByteOrd();
        $this->_data['e']['si_timeleft']  = Helper::lgslTime($buffer->cutByteUnpack(4, "I") / 1000);
        $this->_data['e']['si_gamestate'] = $buffer->cutByteOrd();
        $buffer->skip(2);

        $player_key = 0;
        while ($buffer->length() && $buffer->get() != "\x20") { // QUAKEWARS EXTENDED: (PID)(XP)(TEAM)(KILLS)(DEATHS)
          $this->_data['p'][$player_key]['pid']    = $buffer->cutByteOrd();
          $this->_data['p'][$player_key]['xp']     = (int) $buffer->cutByteUnpack(4, "f");
          $this->_data['p'][$player_key]['team']   = $buffer->cutString();
          $this->_data['p'][$player_key]['score']  = $buffer->cutByteUnpack(4, "i");
          $this->_data['p'][$player_key]['deaths'] = $buffer->cutByteUnpack(4, "i");
          $player_key ++;
        }
      } else { // DOOM3 AND PREY: (PID)(PING)(RATE)(NULLNULL)(NAME) // QUAKE4: (PID)(PING)(RATE)(NULLNULL)(NAME)(TAG)
        while ($buffer->length() && $buffer->get() != "\x20") { // STOPS AT PID 32
          $this->_data['p'][$player_key]['pid']  = $buffer->cutByteOrd();
          $this->_data['p'][$player_key]['ping'] = $buffer->cutByteUnpack(2, "S");
          $this->_data['p'][$player_key]['rate'] = $buffer->cutByteUnpack(2, "S");
          $buffer->skip(2);
          $this->_data['p'][$player_key]['name'] = $buffer->cutString();
          if ($this->_server->getType() === Protocol::QUAKE4) {
            $player_tag = $buffer->cutString();
            $this->_data['p'][$player_key]['name'] = "{$player_tag} {$this->_data['p'][$player_key]['name']}";
          }
          $player_key ++;
        }
      }

      $this->_data['s']['game']       = $this->_data['e']['gamename'];
      $this->_data['s']['name']       = $this->_data['e']['si_name'];
      $this->_data['s']['map']        = $this->_data['e']['si_map'];
      $this->_data['s']['players']    = $this->_data['p'] ? count($this->_data['p']) : 0;
      $this->_data['s']['playersmax'] = $this->_data['e']['si_maxplayers'];

      if ($quakewars) {
        $this->_data['s']['map']      = str_replace([".entities", "maps/"], ["",""], $this->_data['s']['map']);
        $this->_data['s']['password'] = $this->_data['e']['si_needpass'];
      } else {
        $this->_data['s']['password'] = $this->_data['e']['si_usepass'];
      }
      return $this::SUCCESS;
    }
  }
  /* Query 11-20 */
  class Query11 extends Query06 { // Unreal Tournament 3
    public function process(): int {
      $status = parent::process();
      if (!$status) { return $this::NO_RESPOND; }

      $this->_data['s']['map'] = $this->_data['e']['p1073741825']; unset($this->_data['e']['p1073741825']);
      $lgsl_ut3_key = ["s0" => "bots_skill", "s6" => "pure", "s7" => "password", "s8" => "bots_vs", "s10" => "forcerespawn", "p268435703" => "bots", "p268435704" => "goalscore",
      "p268435705" => "timelimit", "p268435717" => "mutators_default", "p1073741826" => "gametype", "p1073741827" => "description", "p1073741828" => "mutators_custom",
      "s32779" => "gamemode_id"];

      foreach ($lgsl_ut3_key as $old => $new) {
        if (!isset($this->_data['e'][$old])) { continue; }
        $this->_data['e'][$new] = $this->_data['e'][$old];
        unset($this->_data['e'][$old]);
      }
      $modes = ["DM", "WAR", "VCTF", "TDM", "DUEL"];
      $this->_data['s']['mode'] = $modes[$this->_data['e']['gamemode_id']];
      unset($this->_data['e']['s1'], $this->_data['e']['s9'], $this->_data['e']['s11'], $this->_data['e']['s12'], $this->_data['e']['s13'], $this->_data['e']['s14']);

      $part = explode(".", $this->_data['e']['gametype']);

      if ($part[0] && (stristr($part[0], "UT") === FALSE)) {
        $this->_data['s']['game'] = $part[0];
      }

      $this->_data['e']['mutators_default'] = Helper::bitComparer($this->_data['e']['mutators_default'], ["BigHead","FriendlyFire","Handicap","Instagib","LowGrav","?","NoPowerups","NoTranslocator","Slomo","?","SpeedFreak","SuperBerserk","?","WeaponReplacement","WeaponsRespawn"]);
      $this->_data['e']['mutators_custom']  = str_replace("\x1c", " / ", $this->_data['e']['mutators_custom']);

      return $this::SUCCESS;
    }
  }
  class Query12 extends QuerySocket { // SAMP | VCMP
    protected $separatedPackets = true;
    public function process() {
      $ip = explode('.', $this->_server->getIp(true));
      $isVcmp = $this->_server->getType() === Protocol::VCMP;
      $sPacket = chr($ip[0]).chr($ip[1]).chr($ip[2]).chr($ip[3]).chr($this->_server->getQueryPort() & 0xFF).chr($this->_server->getQueryPort() >> 8 & 0xFF);
      if ($isVcmp) { $challenge_packet = "VCMP{$sPacket}"; $this->_need['e'] = FALSE; }
      else { $challenge_packet = "SAMP{$sPacket}"; }

      if     ($this->need('s')) { $challenge_packet .= "i"; }
      elseif ($this->need('e')) { $challenge_packet .= "r"; }
      elseif ($this->need('p') && !$isVcmp) { $challenge_packet .= "d"; }
      elseif ($this->need('p') && $isVcmp) { $challenge_packet .= "c"; }

      $buffer = $this->fetch($challenge_packet);
      if (!$buffer) { // IN CASE OF PACKET LOSS
        $buffer = $this->fetch($challenge_packet);
      }
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(10); // REMOVE HEADER
      $response_type = $buffer->cutByte();
      if ($response_type == "i") {
        if ($isVcmp) { $buffer->skip(12); }
        $this->_data['s']['password']   = $buffer->cutByteOrd();
        $this->_data['s']['players']    = $buffer->cutByteUnpack(2, "S");
        $this->_data['s']['playersmax'] = $buffer->cutByteUnpack(2, "S");
        $this->_data['s']['name']       = iconv('cp1251//IGNORE', 'utf-8//IGNORE', $buffer->cutPascal(4));
        $this->_data['s']['mode']       = iconv('cp1251//IGNORE', 'utf-8//IGNORE', $buffer->cutPascal(4));
        $this->_data['s']['map']        = $buffer->cutPascal(4);
      }
      elseif ($response_type == "r") {
        $item_total = $buffer->cutByteUnpack(2, "S");

        for ($i=0; $i < $item_total; $i++) {
          if ($buffer->length() == 0) { return $this::WITH_ERROR; }  
          $data_key   = strtolower($buffer->cutPascal());
          $data_value = $buffer->cutPascal();

          $this->_data['e'][$data_key] = $data_value;
        }
      }
      elseif ($response_type == "d") {
        $player_total = $buffer->cutByteUnpack(2, "S");

        for ($i=0; $i < $player_total; $i++) {
          if ($buffer->length() == 0) { return $this::WITH_ERROR; }  

          $this->_data['p'][$i]['pid']   = $buffer->cutByteOrd();
          $this->_data['p'][$i]['name']  = $buffer->cutPascal();
          $this->_data['p'][$i]['score'] = $buffer->cutByteUnpack(4, "S");
          $this->_data['p'][$i]['ping']  = $buffer->cutByteUnpack(4, "S");
        }
      }
      elseif ($response_type == "c") {
        $player_total = $buffer->cutByteUnpack(2, "S");

        for ($i=0; $i<$player_total; $i++) {
          if ($buffer->length() == 0) { return $this::WITH_ERROR; }  

          $this->_data['p'][$i]['name']  = $buffer->cutPascal();
        }
      }
      return $this::SUCCESS;
    }
  }
  class Query13 extends QuerySocket { // Killing Floor | Red Orchestra | Unreal Tournament 2003 | Unreal Tournament 2004
    public function process() {
      $buffer_s = ""; $this->_fp->write("\x21\x21\x21\x21\x00"); // REQUEST [s]
      $buffer_e = ""; $this->_fp->write("\x21\x21\x21\x21\x01"); // REQUEST [e]
      $buffer_p = ""; $this->_fp->write("\x21\x21\x21\x21\x02"); // REQUEST [p]

      while ($packet = $this->_fp->readRaw()) {
        if     ($packet[4] == "\x00") { $buffer_s .= substr($packet, 5); }
        elseif ($packet[4] == "\x01") { $buffer_e .= substr($packet, 5); }
        elseif ($packet[4] == "\x02") { $buffer_p .= substr($packet, 5); }
      }

      if (!$buffer_s) { return $this::NO_RESPOND; }

      //---------------------------------------------------------+
      //  SOME VALUES START WITH A PASCAL LENGTH AND END WITH A NULL BUT THERE IS AN ISSUE WHERE
      //  CERTAIN CHARACTERS CAUSE A WRONG PASCAL LENGTH AND NULLS TO APPEAR WITHIN NAMES

      $buffer_s = new Buffer(str_replace("\xa0", "\x20", $buffer_s)); // REPLACE SPECIAL SPACE WITH NORMAL SPACE
      $buffer_s->skip(5);
      $this->_data['e']['hostport']   = $buffer_s->cutByteUnpack(4, "S");
      $buffer_s->skip(4);
      $this->_data['s']['name']       = $buffer_s->cutString(1);
      $this->_data['s']['map']        = $buffer_s->cutString(1);
      $this->_data['s']['mode']       = $buffer_s->cutString(1);
      $this->_data['s']['players']    = $buffer_s->cutByteUnpack(4, "S");
      $this->_data['s']['playersmax'] = $buffer_s->cutByteUnpack(4, "S");

      //---------------------------------------------------------+

      while ($buffer_e && $buffer_e[0] != "\x00") {
        $item_key   = strtolower(Helper::lgslCutString($buffer_e, 1));
        $item_value = Helper::lgslCutString($buffer_e, 1);

        $item_key   = str_replace("\x1B\xFF\xFF\x01", "", $item_key);   // REMOVE MOD
        $item_value = str_replace("\x1B\xFF\xFF\x01", "", $item_value); // GARBAGE

        $this->_data['e'][$item_key] = $item_value;
      }

      $this->_data['s']['password'] = empty($this->_data['e']['password']) && empty($this->_data['e']['gamepassword']) ? "0" : "1";

      //---------------------------------------------------------+

      $player_key = 0;

      while ($buffer_p && $buffer_p[0] != "\x00") {
        $this->_data['p'][$player_key]['pid']   = Helper::lgslUnpack(Helper::lgslCutByte($buffer_p, 4), "S");

        $end_marker = ord($buffer_p[0]) > 64 ? "\x00\x00" : "\x00"; // DIRTY WORK-AROUND FOR NAMES WITH PROBLEM CHARACTERS

        $this->_data['p'][$player_key]['name']  = Helper::lgslCutString($buffer_p, 1, $end_marker);
        $this->_data['p'][$player_key]['ping']  = Helper::lgslUnpack(Helper::lgslCutByte($buffer_p, 4), "S");
        $this->_data['p'][$player_key]['score'] = Helper::lgslUnpack(Helper::lgslCutByte($buffer_p, 4), "s");
        $tmp                               = Helper::lgslCutString($buffer_p, 4);

            if ($tmp[3] == "\x20") { $this->_data['p'][$player_key]['team'] = 1; }
        elseif ($tmp[3] == "\x40") { $this->_data['p'][$player_key]['team'] = 2; }

        $player_key ++;
      }
      return $this::SUCCESS;
    }
  }
  class Query14 extends QuerySocket { // Freelancer
    public function process() {
      $buffer = $this->fetch("\x00\x02\xf1\x26\x01\x26\xf0\x90\xa6\xf0\x26\x57\x4e\xac\xa0\xec\xf8\x68\xe4\x8d\x21");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(16);
      $this->_data['s']['map']        = "freelancer";
      $this->_data['s']['password']   = $buffer->cutByteUnpack(4, "l") - 1 ? 1 : 0;
      $this->_data['s']['playersmax'] = $buffer->cutByteUnpack(4, "l") - 1;
      $this->_data['s']['players']    = $buffer->cutByteUnpack(4, "l") - 1;
      $buffer->skip(4);
      $name_length                    = $buffer->cutByteUnpack(4, "l");
      $buffer->skip(56);
      $this->_data['s']['name']       = $buffer->cutByte($name_length);
      $buffer->cutString();
      $buffer->skip(0, 1);
      $this->_data['e']['motd'] = $buffer->getAll();

      // REMOVE UTF-8 ENCODING NULLS
      $this->_data['s']['name'] = str_replace("\x00", "", $this->_data['s']['name']);
      $this->_data['e']['motd'] = str_replace("\x00", "", $this->_data['e']['motd']);
      return $this::SUCCESS;
    }
  }
  class Query16 extends QuerySocket { // rFactor
    public function process() {
      $buffer = $this->fetch("rF_S");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(9);
      $this->_data['e']['region']           = $buffer->cutByteUnpack(2, "S");
      $buffer->skip(4);
      $this->_data['e']['size']             = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['version']          = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['version_racecast'] = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['hostport']         = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['queryport']        = $buffer->cutByteUnpack(2, "S");
      $buffer->skip(20);
      $this->_data['s']['name']             = Helper::lgslCutString($buffer->cutByte(28));
      $this->_data['s']['map']              = Helper::lgslCutString($buffer->cutByte(32));
      $this->_data['e']['motd']             = Helper::lgslCutString($buffer->cutByte(96));
      $packed_aids                          = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['ping']             = $buffer->cutByteUnpack(2, "S");
      $buffer->cutByteUnpack(1, "C");       // packed_flags
      $this->_data['e']['rate']             = $buffer->cutByteUnpack(1, "C");
      $this->_data['s']['players']          = $buffer->cutByteUnpack(1, "C");
      $this->_data['s']['playersmax']       = $buffer->cutByteUnpack(1, "C");
      $this->_data['e']['bots']             = $buffer->cutByteUnpack(1, "C");
      $packed_special                       = $buffer->cutByteUnpack(1, "C");
      $this->_data['e']['damage']           = $buffer->cutByteUnpack(1, "C");
      $buffer->cutByteUnpack(2, "S");       // packed_rules
      $this->_data['e']['credits1']         = $buffer->cutByteUnpack(1, "C");
      $this->_data['e']['credits2']         = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['time']             = Helper::lgslTime($buffer->cutByteUnpack(2, "S"));
      $this->_data['e']['laps']             = $buffer->cutByteUnpack(2, "s") / 16;
      $buffer->skip(3);
      $this->_data['e']['vehicles']         = str_replace("|", " / ", trim($buffer->cutString()));
      $this->_data['s']['password']         = ($packed_special & 2)  ? 1 : 0;
      $this->_data['e']['racecast']         = ($packed_special & 4)  ? 1 : 0;
      $this->_data['e']['fixedsetups']      = ($packed_special & 16) ? 1 : 0;
      $this->_data['e']['aids'] = Helper::bitComparer($packed_aids, ["TractionControl","AntiLockBraking","StabilityControl","AutoShifting","AutoClutch","Invulnerability","OppositeLock","SteeringHelp","BrakingHelp","SpinRecovery","AutoPitstop"]);
      return $this::SUCCESS;
    }
  }
  class Query17 extends QuerySocket { // Savage
    public function process() {
      $buffer = $this->fetch("\x9e\x4c\x23\x00\x00\xce\x21\x21\x21\x21");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(12); // REMOVE HEADER
      while ($key = strtolower($buffer->cutString(0, "\xFE"))) {
        if ($key == "players") { break; }
        $value = str_replace("\x00", "", $buffer->cutString(0, "\xFF"));
        $this->_data['e'][$key] = Helper::lgslParseColor($value, $this->_server->getType());
      }

      $this->_data['s']['name']       = $this->_data['e']['name'];  unset($this->_data['e']['name']);
      $this->_data['s']['map']        = $this->_data['e']['world']; unset($this->_data['e']['world']);
      $this->_data['s']['players']    = $this->_data['e']['cnum'];  unset($this->_data['e']['cnum']);
      $this->_data['s']['playersmax'] = $this->_data['e']['cmax'];  unset($this->_data['e']['cnum']);
      $this->_data['s']['password']   = $this->_data['e']['pass'];  unset($this->_data['e']['cnum']);
      $this->_data['t'][0]['name'] = $this->_data['e']['race1'];
      $this->_data['t'][1]['name'] = $this->_data['e']['race2'];
      $this->_data['t'][2]['name'] = "spectator";

      $team_key   = -1;
      $player_key = 0;
      while ($value = $buffer->cutString(0, "\x0a")) {
        if ($value[0] == "\x00") { break; }
        if ($value[0] != "\x20") { $team_key++; continue; }
        $this->_data['p'][$player_key]['name'] = Helper::lgslParseColor(substr($value, 1), $this->_server->getType());
        $this->_data['p'][$player_key]['team'] = $this->_data['t'][$team_key]['name'];
        $player_key++;
      }
      return $this::SUCCESS;
    }
  }
  class Query18 extends QuerySocket { // Savage 2
    public function process() {
      $buffer = $this->fetch("\x01");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(12); // REMOVE HEADER
      $this->_data['s']['name']            = Helper::lgslParseColor($buffer->cutString(), 1);
      $this->_data['s']['players']         = $buffer->cutByteOrd();
      $this->_data['s']['playersmax']      = $buffer->cutByteOrd();
      $this->_data['e']['time']            = $buffer->cutString();
      $this->_data['s']['map']             = $buffer->cutString();
      $this->_data['e']['nextmap']         = $buffer->cutString();
      $this->_data['e']['location']        = $buffer->cutString();
      $this->_data['e']['minimum_players'] = ord($buffer->cutString());
      $this->_data['s']['mode']            = $buffer->cutString();
      $this->_data['e']['version']         = $buffer->cutString();
      $this->_data['e']['minimum_level']   = $buffer->cutByteOrd();
      // DOES NOT RETURN PLAYER INFORMATION
      return $this::SUCCESS;
    }
  }
  class Query19 extends QuerySocket { // Ghost Recon
    public function process() {
      $buffer = $this->fetch("\xC0\xDE\xF1\x11\x42\x06\x00\xF5\x03\x21\x21\x21\x21");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(25); // REMOVE HEADER
      $this->_data['s']['name']       = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      $this->_data['s']['map']        = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      $this->_data['e']['nextmap']    = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      $this->_data['e']['gametype']   = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      $buffer->skip(1);
      $this->_data['s']['password']   = $buffer->cutByteOrd();
      $this->_data['s']['playersmax'] = $buffer->cutByteOrd(4);
      $this->_data['s']['players']    = $buffer->cutByteOrd(4);
      for ($player_key = 0; $player_key < $this->_data['s']['players']; $player_key++) {
        $this->_data['p'][$player_key]['name'] = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      }
      $buffer->skip(17);
      $this->_data['e']['version']    = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      $this->_data['e']['mods']       = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      $this->_data['e']['dedicated']  = $buffer->cutByteOrd();
      $this->_data['e']['time']       = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $status = ['?','?','?','Joining','Joining','Joining'];
      $this->_data['e']['status']     = $buffer->cutByteOrd(4);
      $modes = ['?','?','Co-Op','Solo','Team'];
      $this->_data['s']['mode']       = $modes[$buffer->cutByteOrd(4)];
      $this->_data['e']['motd']       = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      $respawns = ['None','Individual','Team','Infinite'];
      $this->_data['e']['respawns']   = $respawns[$buffer->cutByteOrd(4)];
      $this->_data['e']['time_limit'] = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $this->_data['e']['voting']     = $buffer->cutByteOrd(4);
      $buffer->skip(2);
      for ($player_key = 0; $player_key < $this->_data['s']['players']; $player_key++) {
        $this->_data['p'][$player_key]['team'] = $buffer->cutByteOrd(4);
        $buffer->skip(1);
      }
      $buffer->skip(7);
      $this->_data['e']['platoon_1_color']   = $buffer->cutByteOrd(8);
      $this->_data['e']['platoon_2_color']   = $buffer->cutByteOrd(8);
      $this->_data['e']['platoon_3_color']   = $buffer->cutByteOrd(8);
      $this->_data['e']['platoon_4_color']   = $buffer->cutByteOrd(8);
      $this->_data['e']['timer_on']          = $buffer->cutByteOrd();
      $this->_data['e']['timer_time']        = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $this->_data['e']['time_debriefing']   = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $this->_data['e']['time_respawn_min']  = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $this->_data['e']['time_respawn_max']  = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $this->_data['e']['time_respawn_safe'] = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $difficulty = ['Recruit','Veteran','Elite'];
      $this->_data['e']['difficulty']        = $difficulty[$buffer->cutByteOrd(4)];
      $this->_data['e']['respawn_total']     = $buffer->cutByteOrd(4);
      $this->_data['e']['random_insertions'] = $buffer->cutByteOrd();
      $this->_data['e']['spectators']        = $buffer->cutByteOrd();
      $this->_data['e']['arcademode']        = $buffer->cutByteOrd();
      $this->_data['e']['ai_backup']         = $buffer->cutByteOrd();
      $this->_data['e']['random_teams']      = $buffer->cutByteOrd();
      $this->_data['e']['time_starting']     = Helper::lgslTime($buffer->cutByteUnpack(4, "f"));
      $this->_data['e']['identify_friends']  = $buffer->cutByteOrd();
      $this->_data['e']['identify_threats']  = $buffer->cutByteOrd();
      $buffer->skip(5);
      $this->_data['e']['restrictions']      = Helper::lgslCutString($buffer->cutPascal(4, 3, -3));
      return $this::SUCCESS;
    }
  }
  class Query20 extends QuerySocket { // Frontlines: Fuel Of War
    protected $separatedPackets = true;
    public function process() {
      if ($this->need('s')) {
        $buffer = $this->fetch("\xFF\xFF\xFF\xFFFLSQ");
      } else {
        $buffer = $this->fetch("\xFF\xFF\xFF\xFF\x57");
        if (!$buffer) return $this::NO_RESPOND;

        $buffer->skip(5);
        $challenge = $buffer->cutByte(4);
        if     ($this->need('e')) { $buffer = $this->fetch("\xFF\xFF\xFF\xFF\x56{$challenge}"); }
        elseif ($this->need('p') && $this->_server->getPlayersCount() > 0) { $buffer = $this->fetch("\xFF\xFF\xFF\xFF\x55{$challenge}"); }
      }
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(4); // REMOVE HEADER
      $response_type = $buffer->cutByte();
      if ($response_type == "I") {
        $this->_data['e']['netcode']     = $buffer->cutByteOrd();
        $this->_data['s']['name']        = $buffer->cutString();
        $this->_data['s']['map']         = $buffer->cutString();
        $this->_data['s']['game']        = $buffer->cutString();
        $this->_data['s']['mode']        = $buffer->cutString();
        $this->_data['e']['description'] = $buffer->cutString();
        $this->_data['e']['version']     = $buffer->cutString();
        $this->_data['e']['hostport']    = $buffer->cutByteUnpack(2, "n");
        $this->_data['s']['players']     = $buffer->cutByteUnpack(1, "C");
        $this->_data['s']['playersmax']  = $buffer->cutByteUnpack(1, "C");
        $this->_data['e']['dedicated']   = Helper::bool($buffer->cutByte() === "d");
        $this->_data['e']['os']          = $buffer->cutByte();
        $this->_data['s']['password']    = $buffer->cutByteUnpack(1, "C");
        $this->_data['e']['anticheat']   = Helper::bool($buffer->cutByteUnpack(1, "C"));
        $this->_data['e']['cpu_load']    = round(3.03 * $buffer->cutByteUnpack(1, "C"))."%";
        $this->_data['e']['round']       = $buffer->cutByteUnpack(1, "C");
        $this->_data['e']['roundsmax']   = $buffer->cutByteUnpack(1, "C");
        $this->_data['e']['timeleft']    = Helper::lgslTime($buffer->cutByteUnpack(2, "S") / 250);
      } elseif ($response_type == "E") {
        $buffer->cutByteUnpack(2, "S"); // returned
        while ($buffer->length() > 0) {
          $this->_data['e'][strtolower($buffer->cutString())] = $buffer->cutString();
        }
      } elseif ($response_type == "D") {
        $buffer->skip(1); // returned
        $player_key = 0;
        while ($buffer->length() > 0) {
          $this->_data['p'][$player_key]['pid']   = $buffer->cutByteOrd();
          $this->_data['p'][$player_key]['name']  = $buffer->cutString();
          $this->_data['p'][$player_key]['score'] = $buffer->cutByteUnpack(4, "N");
          $this->_data['p'][$player_key]['time']  = Helper::lgslTime(Helper::lgslUnpack(strrev($buffer->cutByte(4)), "f"));
          $this->_data['p'][$player_key]['ping']  = $buffer->cutByteUnpack(2, "n");
          $this->_data['p'][$player_key]['uid']   = $buffer->cutByteUnpack(4, "N");
          $this->_data['p'][$player_key]['team']  = $buffer->cutByteOrd();
          $player_key ++;
        }
      }
      return $this::SUCCESS;
    }
  }
  /* Query 21-30 */
  class Query21 extends QuerySocket { // Teeworlds
    public function process() {
      $buffer = $this->fetch("\x04\x00\x00\xff\xff\xff\xff\x05\x30\x12\x16\x72\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00");
      if (!$buffer) return $this::NO_RESPOND;
      $buffer->skip(8);
      $buffer = $this->fetch("\x21{$buffer->cutByte(4)}\x30\x12\x16\x72\xff\xff\xff\xff\x67\x69\x65\x33\x95\xfd\xaa\xff\x0e");

      $buffer->skip(22);
      $this->_data['e']['version']    = $buffer->cutString();
      $this->_data['s']['name']       = $buffer->cutString();
      $buffer->skip(1);
      $this->_data['s']['map']        = $buffer->cutString();
      $this->_data['s']['mode']       = $buffer->cutString();
      $this->_data['e']['progress']   = "{$buffer->cutByteOrd()}%";
      $difficulty = ["Casual","Normal","Competitive"];
      $this->_data['e']['difficulty'] = $difficulty[$buffer->cutByteOrd()];
      $this->_data['s']['players']    = $buffer->cutByteOrd();
      $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
      $buffer->skip(2);

      $player_key = 0;
      while ($buffer->length() > 0) {
        $this->_data['p'][$player_key]['name'] = $buffer->cutString();
        $this->_data['p'][$player_key]['clan'] = $buffer->cutString();
        $buffer->cutString(); // some player's data
        $player_key ++;
      }
      return $this::SUCCESS;
    }
  }
  class Query22 extends QuerySocket { // OpenTTD 
    public function process() {
      $buffer = $this->fetch("\x03\x00\x00");
      if (!$buffer) return $this::NO_RESPOND;

      $this->_fp = new Stream(Protocol::TCP);
      $this->_fp->open($this->_server);
      $buffer = $this->fetch("\x03\x00\x07");

      $buffer->skip(9);
      $buffer->cutByteOrd(); // TYPE SHOULD BE 4
      $grf_count = $buffer->cutByteOrd();
      for ($a=0; $a<$grf_count; $a++) {
        $this->_data['e']["grf_{$a}_id"] = strtoupper(dechex($buffer->cutByteUnpack(4, "N")));
        for ($b=0; $b<16; $b++) {
          $this->_data['e']["grf_{$a}_md5"] .= strtoupper(dechex($buffer->cutByteOrd()));
        }
        $this->_data['e']["grf_{$a}_name"] = $buffer->cutString();
      }

      $this->_data['e']['date_current']   = floor($buffer->cutByteUnpack(4, "L") / 365.3) . " year";
      $this->_data['e']['date_start']     = floor($buffer->cutByteUnpack(4, "L") / 365.3) . " year";
      $this->_data['e']['companies_max']  = $buffer->cutByteOrd();
      $this->_data['e']['companies']      = $buffer->cutByteOrd();
      $this->_data['e']['spectators_max'] = $buffer->cutByteOrd();
      $this->_data['s']['name']           = $buffer->cutString();
      $this->_data['e']['version']        = $buffer->cutString();
      $this->_data['e']['language']       = $buffer->cutByteOrd();
      $this->_data['s']['password']       = $buffer->cutByteOrd();
      $this->_data['s']['playersmax']     = $buffer->cutByteOrd();
      $this->_data['s']['players']        = $buffer->cutByteOrd();
      $this->_data['e']['spectators']     = $buffer->cutByteOrd();
      $this->_data['s']['map']            = $buffer->cutString();
      $this->_data['e']['map_width']      = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['map_height']     = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['map_set']        = $buffer->cutByteOrd();
      $this->_data['e']['dedicated']      = $buffer->cutByteOrd();

      $this->_data['s']['players'] = $this->_data['e']['spectators'] + $this->_data['e']['companies'];
      $this->_data['s']['playersmax'] = $this->_data['e']['spectators_max'];
      return $this::SUCCESS;
    }
  }
  class Query24 extends QuerySocket { // Cube
    public function process() {
      $buffer = $this->fetch("\x21\x21");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(2); // REMOVE HEADER
      $this->_need['e'] = false;
      $isBloodFronier = $buffer->get(1) == "\x06";
      if ($buffer->get(0) == "\x1b") { // CUBE 1
        // RESPONSE IS XOR ENCODED FOR SOME STRANGE REASON
        for ($i=0; $i<$buffer->length(); $i++) { $buffer[$i] = chr(ord($buffer->get($i)) ^ 0x61); }

        $this->_data['s']['game']       = "Cube";
        $this->_data['e']['netcode']    = $buffer->cutByteOrd();
        $this->_data['e']['gamemode']   = $buffer->cutByteOrd();
        $this->_data['s']['players']    = $buffer->cutByteOrd();
        $this->_data['e']['timeleft']   = Helper::lgslTime($buffer->cutByteOrd() * 60);
        $this->_data['s']['map']        = $buffer->cutString();
        $this->_data['s']['name']       = $buffer->cutString();
        $this->_data['s']['playersmax'] = "0"; // NOT PROVIDED
        $this->_need['p'] = false;
        return $this::SUCCESS;
      } elseif ($buffer->get(0) == "\x80") { // ASSAULT CUBE
        $this->_data['s']['game']       = "AssaultCube";
        $this->_data['e']['netcode']    = $buffer->cutByteOrd();
        $this->_data['e']['version']    = $buffer->cutByteUnpack(2, "S");
        $this->_data['e']['gamemode']   = $buffer->cutByteOrd();
        $this->_data['s']['players']    = $buffer->cutByteOrd();
        $this->_data['e']['timeleft']   = Helper::lgslTime($buffer->cutByteOrd() * 60);
        $this->_data['s']['map']        = $buffer->cutString();
        $this->_data['s']['name']       = $buffer->cutString();
        $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
      } else { // Sauerbraten & Blood Frontier
        $this->_data['s']['game']       = ($isBloodFronier ? "Blood Frontier" : "Sauerbraten");
        $this->_data['s']['players']    = $buffer->cutByteOrd();
        $buffer->cutByteOrd(); // CODED FOR 6
        $this->_data['e']['netcode']    = $buffer->cutByteOrd();
        $this->_data['e']['version']    = $buffer->cutByteUnpack(2, "S");
        $modes = ["ffa","coop_edit","teamplay","instagib","insta_team", 12 => "insta_ctf", 17 => "effic_ctf"];
        $this->_data['s']['mode']   = $modes[$buffer->cutByteOrd()];
        if (!$isBloodFronier) $this->_data['e']['mutators'] = $buffer->cutByteOrd();
        $this->_data['e']['timeleft']   = Helper::lgslTime($buffer->cutByteOrd() * 60);
        $buffer->skip(1);
        $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
        $this->_data['s']['password']   = Helper::bool($buffer->cutByteOrd() & 4); // BIT FIELD
        $this->_data['s']['map']        = $buffer->cutString();
        $this->_data['s']['name']       = $buffer->cutString();
      }

      //---------------------------------------------------------+
      //  CRAZY PROTOCOL - REQUESTS MUST BE MADE FOR EACH PLAYER
      //  BOTS ARE RETURNED BUT NOT INCLUDED IN THE PLAYER TOTAL
      //  AND THERE CAN BE ID GAPS BETWEEN THE PLAYERS RETURNED

      if ($this->need('p') && $this->_data['s']['players'] > 0) {
        $player_key = 0;

        for ($player_id=0; $player_id<32; $player_id++) {
          $buffer = $this->fetch("\x00\x01".chr($player_id));
          if (!$buffer) { break; }

          // CHECK IF PLAYER ID IS ACTIVE
          if ($buffer->get(5) != "\x00") {
            if ($player_key < $this->_data['s']['players']) { continue; }
            break;
          }

          // IF PREVIEW PACKET GET THE FULL PACKET THAT FOLLOWS
          if ($buffer->length() < 15) {
            $buffer = $this->_fp->read(4096);
            if (!$buffer) { break; }
          }

          // REMOVE HEADER
          $buffer->skip(7);

          // WE CAN NOW GET THE PLAYER DETAILS
          $this->_data['p'][$player_key]['pid']       = $buffer->cutByteUnpack(1, "C");
          $this->_data['p'][$player_key]['ping']      = $buffer->cutByteUnpack(1, "C");
          $this->_data['p'][$player_key]['ping']      = $this->_data['p'][$player_key]['ping'] == 128 ? $buffer->cutByteUnpack(2, "S") : $this->_data['p'][$player_key]['ping'];
          $this->_data['p'][$player_key]['name']      = $buffer->cutString();
          $this->_data['p'][$player_key]['team']      = $buffer->cutString();
          $this->_data['p'][$player_key]['score']     = $buffer->cutByteUnpack(1, "c");
          if ($isBloodFronier) {
          $this->_data['p'][$player_key]['damage']    = $buffer->cutByteUnpack(1, "C");
          }
          $this->_data['p'][$player_key]['deaths']    = $buffer->cutByteUnpack(1, "C");
          $this->_data['p'][$player_key]['teamkills'] = $buffer->cutByteUnpack(1, "C");
          $this->_data['p'][$player_key]['accuracy']  = "{$buffer->cutByteUnpack(1, "C")}%";
          $this->_data['p'][$player_key]['health']    = $buffer->cutByteUnpack(1, "c");
          $this->_data['p'][$player_key][$isBloodFronier?'spree':'armour']    = $buffer->cutByteUnpack(1, "C");
          $this->_data['p'][$player_key]['weapon']    = $buffer->cutByteUnpack(1, "C");

          $player_key++;
        }
      }
      return $this::SUCCESS;
    }
  }
  class Query25 extends QuerySocket { // Tribes 2
    public function process() {
      $buffer = $this->fetch("\x12\x02\x21\x21\x21\x21");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(6); // REMOVE HEADER
      $this->_data['s']['game']       = $buffer->cutPascal();
      $this->_data['s']['mode']       = $buffer->cutPascal();
      $this->_data['s']['map']        = $buffer->cutPascal();
      $bit_flags = $buffer->cutByteOrd();
      $this->_data['s']['players']    = $buffer->cutByteOrd();
      $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
      $this->_data['e']['bots']       = $buffer->cutByteOrd();
      $this->_data['e']['cpu']        = $buffer->cutByteUnpack(2, "S");
      $this->_data['e']['motd']       = $buffer->cutPascal();
      $this->_data['e']['unknown']    = $buffer->cutByteUnpack(2, "S");

      $this->_data['e']['dedicated']  = Helper::bool($bit_flags & 1);
      $this->_data['s']['password']   = $bit_flags & 2;
      $this->_data['e']['os']         = ($bit_flags & 4) ? "L" : "W";
      $this->_data['e']['tournament'] = Helper::bool($bit_flags & 8);
      $this->_data['e']['no_alias']   = Helper::bool($bit_flags & 16);

      $team_total = $buffer->cutString(0, "\x0A");
      for ($i=0; $i<$team_total; $i++) {
        $this->_data['t'][$i]['name']  = $buffer->cutString(0, "\x09");
        $this->_data['t'][$i]['score'] = $buffer->cutString(0, "\x0A");
      }

      $player_total = $buffer->cutString(0, "\x0A");
      for ($i=0; $i<$player_total; $i++) {
        $buffer->skip(1); // ? 16
        $buffer->skip(1); // ? 8 or 14 = BOT / 12 = ALIAS / 11 = NORMAL
        if ($buffer->cutByteOrd() < 32) { $buffer->cutByte(); } // ? 8 PREFIXES SOME NAMES

        $this->_data['p'][$i]['name']  = $buffer->cutString(0, "\x11");
        $buffer->cutString(0, "\x09"); // ALWAYS BLANK
        $this->_data['p'][$i]['team']  = $buffer->cutString(0, "\x09");
        $this->_data['p'][$i]['score'] = $buffer->cutString(0, "\x0A");
      }
      return $this::SUCCESS;
    }
  }
  class Query27 extends QuerySocket { // Doom Zandronum (Skulltag)
    public function process() {
      $buffer = $this->fetch("\x02\xB8\x49\x1A\x9C\x8B\xB5\x3F\x1E\x8F\x07");
      if (!$buffer) return $this::NO_RESPOND;

      $buffer->skip(1); // REMOVE HEADER
      $packet_binary = "";

      for ($i=0; $i<$buffer->length(); $i++) {
        $packet_binary .= strrev(sprintf("%08b", ord($buffer->get($i))));
      }

      $buffer = "";
      require_once "lgsl_uncommon.php";
      $huffman_table = Uncommon::lgslHuffmanTable();

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
      $buffer = new Buffer($buffer);

      //---------------------------------------------------------+
      if ($buffer->cutByteUnpack(4, "l") != "5660023") { return $this::WITH_ERROR; }
      $buffer->cutByteUnpack(4, "l"); //response_time
      $this->_data['e']['version'] = $buffer->cutString();
      $response_flag = $buffer->cutByteUnpack(4, "l");

      //---------------------------------------------------------+
      if ($response_flag & 0x00000001) { $this->_data['s']['name']       = $buffer->cutString(); }
      if ($response_flag & 0x00000002) { $this->_data['e']['wadurl']     = $buffer->cutString(); }
      if ($response_flag & 0x00000004) { $this->_data['e']['email']      = $buffer->cutString(); }
      if ($response_flag & 0x00000008) { $this->_data['s']['map']        = $buffer->cutString(); }
      if ($response_flag & 0x00000010) { $this->_data['s']['playersmax'] = $buffer->cutByteOrd(); }
      if ($response_flag & 0x00000020) { $this->_data['e']['playersmax'] = $buffer->cutByteOrd(); }
      if ($response_flag & 0x00000040) {
        $pwad_total = $buffer->cutByteOrd();

        $this->_data['e']['pwads'] = "";

        for ($i=0; $i<$pwad_total; $i++) {
          $this->_data['e']['pwads'] .= "{$buffer->cutString()}\n";
        }
      }
      if ($response_flag & 0x00000080) {
        $modes = ["Cooperative","Survival","Invasion","Deathmatch","","Duel","Terminator"];
        $this->_data['s']['mode'] = $modes[$buffer->cutByteOrd()];
        $this->_data['e']['instagib'] = $buffer->cutByteOrd();
        $this->_data['e']['buckshot'] = $buffer->cutByteOrd();
      }
      if ($response_flag & 0x00000100) { $this->_data['s']['game']         = $buffer->cutString(); }
      if ($response_flag & 0x00000200) { $this->_data['e']['iwad']         = $buffer->cutString(); }
      if ($response_flag & 0x00000400) { $this->_data['s']['password']     = $buffer->cutByteOrd(); }
      if ($response_flag & 0x00000800) { $this->_data['e']['playpassword'] = $buffer->cutByteOrd(); }
      if ($response_flag & 0x00001000) { $this->_data['e']['skill']        = $buffer->cutByteOrd() + 1; }
      if ($response_flag & 0x00002000) { $this->_data['e']['botskill']     = $buffer->cutByteOrd() + 1; }
      if ($response_flag & 0x00004000) {
        $this->_data['e']['dmflags']     = $buffer->cutByteUnpack(4, "l");
        $this->_data['e']['dmflags2']    = $buffer->cutByteUnpack(4, "l");
        $this->_data['e']['compatflags'] = $buffer->cutByteUnpack(4, "l");
      }
      if ($response_flag & 0x00010000) {
        $this->_data['e']['fraglimit'] = $buffer->cutByteUnpack(2, "s");
        $timelimit                = $buffer->cutByteUnpack(2, "S");

        if ($timelimit) { // FUTURE VERSION MAY ALWAYS RETURN THIS
          $this->_data['e']['timeleft'] = Helper::lgslTime($buffer->cutByteUnpack(2, "S") * 60);
        }

        $this->_data['e']['timelimit']  = Helper::lgslTime($timelimit * 60);
        $this->_data['e']['duellimit']  = $buffer->cutByteUnpack(2, "s");
        $this->_data['e']['pointlimit'] = $buffer->cutByteUnpack(2, "s");
        $this->_data['e']['winlimit']   = $buffer->cutByteUnpack(2, "s");
      }
      if ($response_flag & 0x00020000) { $this->_data['e']['teamdamage'] = $buffer->cutByteUnpack(4, "f"); }
      if ($response_flag & 0x00040000) { // DEPRECATED
        $this->_data['t'][0]['score'] = $buffer->cutByteUnpack(2, "s");
        $this->_data['t'][1]['score'] = $buffer->cutByteUnpack(2, "s");
      }
      if ($response_flag & 0x00080000) { $this->_data['s']['players'] = $buffer->cutByteOrd(); }
      if ($response_flag & 0x00100000) {
        for ($i=0; $i<$this->_data['s']['players']; $i++) {
          $this->_data['p'][$i]['name']      = Helper::lgslParseColor($buffer->cutString(), $this->_data['b']['type']);
          $this->_data['p'][$i]['score']     = $buffer->cutByteUnpack(2, "s");
          $this->_data['p'][$i]['ping']      = $buffer->cutByteUnpack(2, "S");
          $this->_data['p'][$i]['spectator'] = $buffer->cutByteOrd();
          $this->_data['p'][$i]['bot']       = $buffer->cutByteOrd();

          if (($response_flag & 0x00200000) && ($response_flag & 0x00400000)) {
            $this->_data['p'][$i]['team'] = $buffer->cutByteOrd();
          }

          $this->_data['p'][$i]['time'] = Helper::lgslTime($buffer->cutByteOrd() * 60);
        }
      }
      if ($response_flag & 0x00200000) {
        $team_total = $buffer->cutByteOrd();

        if ($response_flag & 0x00400000) {
          for ($i=0; $i<$team_total; $i++) { $this->_data['t'][$i]['name'] = $buffer->cutString(); }
        }
        if ($response_flag & 0x00800000) {
          for ($i=0; $i<$team_total; $i++) { $this->_data['t'][$i]['color'] = $buffer->cutByteUnpack(4, "l"); }
        }
        if ($response_flag & 0x01000000) {
          for ($i=0; $i<$team_total; $i++) { $this->_data['t'][$i]['score'] = $buffer->cutByteUnpack(2, "s"); }
        }

        for ($i=0; $i<$this->_data['s']['players']; $i++) {
          if ($this->_data['t'][$i]['name']) { $this->_data['p'][$i]['team'] = $this->_data['t'][$i]['name']; }
        }
      }
      return $this::SUCCESS;
    }
  }
  class Query29 extends QuerySocket { // CS2D
    public function process() {
      if ($this->_need['s'] || $this->_need['e']) {
        $this->_need['e'] = false; // preventing additional query
        $buffer = $this->fetch("\x01\x00\x03\x10\x21\xFB\x01\x75\x00");
        if (!$buffer) { return $this::NO_RESPOND; }

        $buffer->skip(4); // REMOVE HEADER
        $bit_flags  = $buffer->cutByteOrd() - 48;
        $this->_data['s']['name']       = $buffer->cutPascal();
        $this->_data['s']['map']        = $buffer->cutPascal();
        $this->_data['s']['players']    = $buffer->cutByteOrd();
        $this->_data['s']['playersmax'] = $buffer->cutByteOrd();
        $this->_data['e']['gamemode']   = $buffer->cutByteOrd();
        $modes = ["Standard", "", "Deathmatch", "Construction", "Zombies"];
        $this->_data['s']['mode']       = $modes[$this->_data['e']['gamemode']];
        $this->_data['e']['bots']       = $buffer->cutByteOrd();

        $this->_data['s']['password']        = $bit_flags & 1;
        $this->_data['e']['registered_only'] = Helper::bool($bit_flags & 2);
        $this->_data['e']['fog_of_war']      = Helper::bool($bit_flags & 4);
        $this->_data['e']['friendlyfire']    = Helper::bool($bit_flags & 8);
      }

      if ($this->need('p') && $this->_data['s']['players'] > 0) {
        $buffer = $this->fetch("\x01\x00\xFB\x05");
        if (!$buffer) { return $this::NO_RESPOND; }

        $buffer->skip(4); // REMOVE HEADER
        $player_total = $buffer->cutByteOrd();
        for ($i=0; $i < $player_total; $i++) {
          $this->_data['p'][$i]['pid']    = $buffer->cutByteOrd();
          $this->_data['p'][$i]['name']   = $buffer->cutPascal();
          $this->_data['p'][$i]['team']   = $buffer->cutByteOrd();
          $this->_data['p'][$i]['score']  = $buffer->cutByteUnpack(4, "l");
          $this->_data['p'][$i]['deaths'] = $buffer->cutByteUnpack(4, "l");
        }
      }
      return $this::SUCCESS;
    }
  }
  class Query30 extends QuerySocket { // Battlefield Bad Company 2
    public function fetchAll($packet) {
      $buffer = $this->fetch($packet);
      if (!$buffer) return $this::NO_RESPOND;
      $buffer->skip(4);
      $length = $buffer->cutByteUnpack(4, "L");
      while ($buffer->length() < $length) {
        $packet = $this->_fp->read();
        if ($packet) { $buffer->add($packet); } else { break; }
      }
      $buffer->skip(4); // REMOVE HEADER
      if ($buffer->cutPascal(4, 0, 1) != "OK") { return $this::WITH_ERROR; }
      return $buffer;
    }
    public function process() {
      if ($this->need('s') || $this->need('e')) {
        $buffer = $this->fetchAll("\x00\x00\x00\x00\x1B\x00\x00\x00\x01\x00\x00\x00\x0A\x00\x00\x00serverInfo\x00");
        if (is_numeric($buffer)) return $buffer;
        $this->_need['e'] = false; // preventing additional query
        $this->_data['s']['name']            = $buffer->cutPascal(4, 0, 1);
        $this->_data['s']['players']         = $buffer->cutPascal(4, 0, 1);
        $this->_data['s']['playersmax']      = $buffer->cutPascal(4, 0, 1);
        $this->_data['s']['mode']            = $buffer->cutPascal(4, 0, 1);
        $this->_data['e']['level']           = $buffer->cutPascal(4, 0, 1);
        $this->_data['e']['score_attackers'] = $buffer->cutPascal(4, 0, 1);
        $this->_data['e']['score_defenders'] = $buffer->cutPascal(4, 0, 1);

        // CONVERT MAP NUMBER TO DESCRIPTIVE NAME
        $names = [
          "001" => "Panama Canal", "002" => "Valparaiso", "003" => "Laguna Alta", "004" => "Isla Inocentes", "005" => "Atacama Desert",
          "006" => "Arica Harbor", "007" => "White Pass", "008" => "Nelson Bay", "009" => "Laguna Presa", "012" => "Port Valdez"
        ];
        $this->_data['s']['map'] = str_replace("Levels/MP_", "", $this->_data['e']['level']);
        $this->_data['s']['map'] = $names[$this->_data['s']['map']] ?? $this->_data['s']['map'];
      }

      if ($this->need('p')) {
        $buffer = $this->fetchAll("\x00\x00\x00\x00\x24\x00\x00\x00\x02\x00\x00\x00\x0B\x00\x00\x00listPlayers\x00\x03\x00\x00\x00all\x00");
        if (is_numeric($buffer)) return $buffer;
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
              case "clantag": $this->_data['p'][$i]['name']  = $value; break;
              case "name":    $this->_data['p'][$i]['name']  = empty($this->_data['p'][$i]['name']) ? $value : "[{$this->_data['p'][$i]['name']}] {$value}"; break;
              case "teamid":  $this->_data['p'][$i]['team']  = $player_team[$value] ?? $value; break;
              case "squadid": $this->_data['p'][$i]['squad'] = $player_squad[$value] ?? $value; break;
              default:        $this->_data['p'][$i][$field]  = $value; break;
            }
          }
        }
      }
      return $this::SUCCESS;
    }
  }
  /* Query 31-40 */
  class Query32 extends QuerySocket { // Plain Sight
    public function process() {
      $buffer = $this->fetch("\x05\x00\x00\x01\x0A");
      if (!$buffer) return $this::NO_RESPOND;
      $buffer->skip(5); // REMOVE HEADER
      $this->_data['s']['name']    = $buffer->cutPascal();
      $this->_data['s']['map']     = $buffer->cutPascal();
      $this->_data['s']['players'] = $buffer->cutByteOrd();
      return $this::SUCCESS;
    }
  }
  class Query33 extends Query { // TeamSpeak 1 / 3 / TeaSpeak
    private $error = "";
    public function read($length = 4096) {
      return $this->_fp->read($length);
    }
    public function fetch($packet = "", $length = 4096) {
      $this->_fp->write($packet);
      return $this->read($length);
    }
    public function addError($msg) {
      $this->error .= $msg . "\n";
    }
    public function process() {
      $buffer = $this->fetch();
      if (!$buffer) return $this::NO_RESPOND;
      if ($this->_server->getType() === 'teaspeak') {
        if ($buffer->has('TeaSpeak') && $this->_fp->read()->has('TeaSpeak')) {
          return $this::WITH_ERROR;
        }
      } else {
        if (!$buffer->has('TS')) {
          return $this::WITH_ERROR;
        }
      }
      $ver = $this->_server->getType() === Protocol::TS ? 0 : 1;
      $param = [
        ['sel ', 'si', "\r\n", 'pl'],
        ['use port=', 'serverinfo', ' ', 'clientlist -country', 'channellist -topic']
      ];
      if ($ver) { $this->fetch(); }
      $buffer = $this->fetch("{$param[$ver][0]}{$this->_server->get_c_port()}\n"); // select virtualserver
      if (!$buffer) {
        return $this::WITH_ERROR;
      }
      if (strtoupper($buffer->get(-4, -2)) != 'OK') { 
        $this->_data['e']['error'] = "No server with port {$this->_server->get_c_port()}";
        return $this::WITH_ERROR;
      }
      
      $getPackets = function($message) {
        $buffer = $this->fetch($message);
        if (!$buffer || $buffer->get(0, 5) === 'error') {
          $this->addError($buffer->getAll());
          return $this::WITH_ERROR;
        }
        while (strtoupper($buffer->get(-4, -2)) != 'OK') {
          $part = $this->read();
          if ($part && $part->get(0, 5) != 'error') { $buffer->add($part); } else { break; }
        }
        return $buffer;
      };

      $buffer = $getPackets("{$param[$ver][1]}\n"); // request serverinfo
      if ($buffer === $this::WITH_ERROR) {
        $this->addError("No privilleges to retrieve server info");
      } else {
      while ($val = $buffer->cutString(7 + 7 * $ver, $param[$ver][2])) {
        $key = Helper::lgslCutString($val, 0, '='); $items[$key] = $val;
      }
        if (!isset($items['name'])) return $this::WITH_ERROR;
        $this->_data['s']['name']         = $ver ? Helper::lgslUnescape($items['name']) : $items['name'];
        $this->_data['s']['players']      = (int) ($items[$ver ? 'clientsonline' : 'currentusers']);
        $this->_data['s']['playersmax']   = (int) ($items[$ver ? 'maxclients' : 'maxusers']);
        $this->_data['s']['password']     = (int) ($items[$ver ? 'flag_password' : 'password']);
        $this->_data['e']['platform']     = $items['platform'];
        $this->_data['e']['motd']         = Helper::lgslParseColor($ver ? Helper::lgslUnescape($items['welcomemessage']) : $items['welcomemessage'], 'bbcode');
        $this->_data['e']['uptime']       = Helper::lgslTime($items['uptime']);
        $this->_data['e']['banner']       = Helper::lgslUnescape($items['hostbanner_url']);
        $this->_data['e']['channelscount']= $items[$ver ? 'channelsonline' : 'currentchannels'];
        if ($ver) { $this->_data['e']['version'] = Helper::lgslUnescape($items['version']); }
      }

      if ($this->need('p') && ($this->_data['s']['players'] ?? 0) > 0) {
        $buffer = $getPackets("{$param[$ver][3]}\n"); // request playerlist

        if ($buffer === $this::WITH_ERROR) {
          $this->addError("No privilleges to retrieve player list");
        } else {
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
      }

      if ($this->need('e') && $ver) {
        $buffer = $getPackets("{$param[$ver][4]}\n"); // request channellist
        if ($buffer === $this::WITH_ERROR) {
          $this->addError("No privilleges to retrieve channel list");
        } else {
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
      }
      if ($this->error)
        $this->_data['e']['error'] = $this->error;
      return $this::SUCCESS;
    }
  }
  class Query34 extends QueryJson { // Rage:MP
    public function process() {
      $buffer = $this->fetch("https://cdn.rage.mp/master/");
      if (!$buffer) return $this::NO_RESPOND;
      if ($value = $buffer["{$this->_server->getIp()}:{$this->_server->get_c_port()}"]) {
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
      $buffer = $this->fetch("http://{$this->_server->getIp()}:{$this->_server->getQueryPort()}/dynamic.json");
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
        $buffer = $this->fetch("http://{$this->_server->getIp()}:{$this->_server->getQueryPort()}/players.json");

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
      $buffer = $this->fetch("https://discord.com/api/v9/invites/{$this->_server->getIp()}?with_counts=true");
      if (!$buffer) return $this::NO_RESPOND;
      if (isset($buffer['message'])) {
        $this->_data['e']['_error_fetching_info'] = $buffer['message'];
        return $this::NO_RESPOND;
      }
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
      $this->need('s');
      $this->need('e');

      if ($this->need('p')) {
        $buffer = $this->fetch("https://discordapp.com/api/guilds/{$this->_server->getOption('id')}/widget.json");

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
      $buffer = $this->fetch("https://api.hellbz.de/scum/api.php?address={$this->_server->getIp()}&port={$this->_server->get_c_port()}");
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
      $buffer = $this->fetch("http://{$this->_server->getIp()}:{$this->_server->getQueryPort()}/v2/server/status?players=true");
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
    public function process() {
      $buffer = $this->fetch("M2MPi");
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
      $buffer = $this->fetch("http://{$this->_server->getIp()}:{$this->_server->getQueryPort()}/info");
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
  /* Query 41-50 */
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
    public function process() {
      $buffer = $this->fetch("\x30");
      if (!$buffer) return $this::NO_RESPOND;
      $packetLength = $buffer->length();
      while ($packetLength >= 504) {
        $packet = substr($this->_fp->readRaw(512), 4);
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
      $this->_data['s']['players']     = count($this->_data['p'] ?? []);
      return $this::SUCCESS;
    }
  }
  class Query43 extends QuerySocket {  // Mumble
    public function process() {
      $buffer = $this->fetch("\x00\x00\x00\x00\x01\x02\x03\x04LGSL");
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
    public function process() {
      $buffer = $this->fetch("\x05\x0b\x00\x00\x00\x86\x76\x41\x31\xa0\x87\xdb\x08\x10\x02\x00\x55\xf0\x86\xff\xde\x58\x00\x00\x00\x00\x00\x00\x00\x00\x08\x00\x00\x00\x43\x72\x79\x6f\x46\x61\x6c\x6c");
      if (!$buffer) return $this::NO_RESPOND;
      $buffer = $this->fetch("\x0c\x0a\x00\x01\x00\x00\x02\x00\x05\x60\x02\xe8\x03\x07\x00\x00\x06\x5f\x02\x20\x4e\x01");
      $buffer = $this->fetch("\x01\x00\x00\x02\x00\x05\x60\x02\xe8\x03");
      if ($buffer->length() < 12) {
        $buffer = $this->fetch("\x00\x06\x61\x02\x20\x4e\x02");
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
    public function process() {
      $buffer = $this->fetch("\xFF\xFFUGP\x00\x01\x00");
      if (!$buffer) return $this::NO_RESPOND;
      $buffer = $this->fetch("\xFF\xFFUGP\x00\x01\x01\x09\x6c\x07");
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
    public function process() {
      $buffer = $this->fetch("\x00\x00\x01\x00\x00\x17\x7f\xd3\x96");
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
        return $k['ip'] == $this->_server->getIp() && ((int) $k['port']) == $this->_server->getQueryPort();
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
  class Query50 extends QueryJson { // Titanfall 2 (by tltneon)
    public function process() {
      $buffer = $this->fetch("https://northstar.tf/client/servers");
      if (!$buffer) return $this::NO_RESPOND;
      $find = array_filter($buffer, function($k) {
        return $k['id'] == $this->_server->getIp();
      });
      if (!$find) return $this::NO_RESPOND;
      $find = reset($find);

      $this->_data['s']['name'] = Helper::lgslParseColor($find['name'], '2');
      $this->_data['s']['players'] = $find['playerCount'];
      $this->_data['s']['playersmax'] = $find['maxPlayers'];
      $this->_data['s']['password'] = $find['hasPassword'];
      $this->_data['s']['map'] = $find['map'];
      $this->_data['e']['description'] = $find['description'];
      $this->_data['e']['version'] = $find['version'];
      $this->_data['e']['region'] = $find['region'];
      $this->_data['s']['mode'] = $find['playlist'];
      $this->_data['e']['modInfo'] = array_reduce($find['modInfo']['Mods'], function($a, $c) {
        return "{$a}\n{$c['Name']} {$c['Version']}";
      }, "");
      return $this::SUCCESS;
    }
  }
  /* Query 51-60 */
  class Query51 extends QueryJSON { // Palworld
    public function process() {
      $search = ($this->_server->getName() === "" ? "list" : "search?q=" . str_replace(" ", "%20", $this->_server->getName()));
      $buffer = $this->fetch("https://api.palworldgame.com/server/{$search}");
      if (!$buffer) return $this::NO_RESPOND;
      if (!$buffer['server_list']) return $this::NO_RESPOND;
      $find = array_filter($buffer['server_list'], function($k) {
        return $k['address'] == $this->_server->getIp() && ((int) $k['port']) == ((int) $this->_server->getQueryPort());
      });
      if (!$find) return FALSE;
      $find = reset($find);
      $this->_data['s']['name'] = $find['name'];
      $this->_data['s']['map'] = $find['map_name'];
      $this->_data['s']['password'] = $find['is_password'];
      $this->_data['s']['players'] = $find['current_players'];
      $this->_data['s']['playersmax'] = $find['max_players'];
      $this->_data['e']['server_id'] = $find['server_id'];
      $this->_data['e']['create_time'] = Date("d.m.Y", $find['created_at']);
      $this->_data['e']['days'] = $find['days'];
      $this->_data['e']['server_time'] = $find['server_time'];
      $this->_data['e']['description'] = isset($find['description']) ? $find['description'] : "";
      $this->_data['e']['version'] = $find['version'];
      return $this::SUCCESS;
    }
  }
  class Query52 extends QueryEOS { // ARK: Survival Ascended
    protected $deployment_id = "ad9a8feffb3b4b2ca315546f038c3ae2";
    protected $user_id = "xyza7891muomRmynIIHaJB9COBKkwj6n";
    protected $user_secret = "PP5UGxysEieNfSrEicaD1N2Bb3TdXuD7xHYcsdUHZ7s";
    protected function filter($k) {
      return $k['attributes']['ADDRESSBOUND_s'] === "{$this->_server->getIp()}:{$this->_server->get_c_port()}" || $k['attributes']['ADDRESSBOUND_s'] === "0.0.0.0:{$this->_server->get_c_port()}";
    }
    protected function placeData($find) {
      $this->_data['s']['name'] = $find['attributes']['CUSTOMSERVERNAME_s'];
      $this->_data['s']['map'] = $find['attributes']['MAPNAME_s'];
      $this->_data['s']['password'] = $find['attributes']['SERVERPASSWORD_b'];
      $this->_data['s']['players'] = $find['totalPlayers'];
      $this->_data['s']['playersmax'] = $find['settings']['maxPublicPlayers'];
      
      $this->_data['e']['anticheat'] = Helper::bool($find['attributes']['SERVERUSESBATTLEYE_b']);
      $this->_data['e']['allowJoinInProgress'] = Helper::bool($find['settings']['allowJoinInProgress']);
      $this->_data['e']['day'] = $find['attributes']['DAYTIME_s'];
      $this->_data['e']['version'] = "v{$find['attributes']['BUILDID_s']}.{$find['attributes']['MINORBUILDID_s']}";
      return $this::SUCCESS;
    }
  }
  class Query53 extends QueryJson { // Alt:V
    public function process() {
      $buffer = $this->fetch("https://altv.mp/api/servers");
      if (!$buffer) return $this::NO_RESPOND;

      $find = array_filter($buffer, function($k) {
        return explode(":", $k['address'])[0] == $this->_server->getIp();
      });
      if (!$find) return $this::NO_RESPOND;
      $find = reset($find);

      $this->_data['s']['name'] = Helper::lgslParseColor($find['name'], '2');
      $this->_data['s']['players'] = $find['playersCount'];
      $this->_data['s']['playersmax'] = $find['maxPlayersCount'];
      $this->_data['s']['password'] = $find['passworded'];
      $this->_data['s']['mode'] = $find['gameMode'];
      $this->_data['e']['description'] = $find['description'];
      $this->_data['e']['version'] = $find['version'];
      $this->_data['e']['region'] = $find['region'];
      $this->_data['e']['language'] = $find['language'];
      $this->_data['e']['website'] = $find['website'];
      $this->_data['e']['banner'] = $find['bannerUrl'] ? "<img src='{$find['bannerUrl']}'>" : "";
      $this->_data['e']['tags'] = array_reduce($find['tags'], function($a, $c) {
        return "{$a}\n{$c}";
      }, "");
      return $this::SUCCESS;
    }
  }
  class Query54 extends QuerySocket { // Minecraft PE | Minecraft BE
    public function process() {
      $buffer = $this->fetch("\x01\x00\x00\x00\x00\x00\x00\x00\x00\x00\xFF\xFF\x00\xFE\xFE\xFE\xFE\xFD\xFD\xFD\xFD\x12\x34\x56\x78LGSLLIST");
      if (!$buffer) return $this::NO_RESPOND;
      $buffer->skip(35);
      $this->_data['s']['game'] = $buffer->cutString(0, ";");
      $this->_data['s']['name'] = Helper::lgslParseColor($buffer->cutString(0, ";"), "minecraft");
      $this->_data['e']['protocol'] = $buffer->cutString(0, ";");
      $this->_data['e']['version'] = $buffer->cutString(0, ";");
      $this->_data['s']['players'] = $buffer->cutString(0, ";");
      $this->_data['s']['playersmax'] = $buffer->cutString(0, ";");
      $this->_data['e']['id'] = $buffer->cutString(0, ";");
      $this->_data['e']['motd'] = Helper::lgslParseColor($buffer->cutString(0, ";"), "minecraft");
      $this->_data['s']['mode'] = $buffer->cutString(0, ";");
      return $this::SUCCESS;
    }
  }
  class Query55 extends QueryJSON { // Palworld Direct
    public function process() {
      $cred = $this->_server->getAdditionalData();
      if (empty($cred['login']) || empty($cred['password'])) {
        $this->_data['e']['_error'] = "No login or password presented";
        return $this::WITH_ERROR;
      }
      $auth = base64_encode("{$cred['login']}:{$cred['password']}");
      $this->_fp->setOpt(CURLOPT_HTTPHEADER, ['Accept: application/json', "Authorization: Basic {$auth}"]);
      $buffer = $this->fetch("http://{$this->_server->getIp()}:{$this->_server->getQueryPort()}/v1/api/settings");
      if (!$buffer) return $this::NO_RESPOND;
      $this->_data['s']['name'] = $buffer['ServerName'];
      $this->_data['s']['password'] = 0;
      $this->_data['s']['players'] = 0;
      $this->_data['s']['playersmax'] = $buffer['ServerPlayerMaxNum'];
      $this->_data['e']['description'] = isset($buffer['ServerDescription']) ? $buffer['ServerDescription'] : "";
      return $this::SUCCESS;
    }
  }
  class Query56 extends QuerySocket { // Vintage Story
    public function process() {
      $this->need('s');
      $this->need('e');
      $this->need('p');
      $buffer = $this->fetch("\x00\x00\x00\x10\x08\x21\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00");
      if (!$buffer) return $this::NO_RESPOND;
      $version = file_get_contents('https://api.vintagestory.at/lateststable.txt');
      $packets = [
        "\x00\x00\x00\x3E\x12\x3C\x0A\x06{$version}\x12\x04\x4C\x47\x53\x4C\x1A\x01\x31\x32\x17\x74\x6C\x74\x6E\x65\x6F\x6E\x2E\x67\x69\x74\x68\x75\x62\x2E\x63\x6F\x6D\x2F\x6C\x67\x73\x6C\x38\x20\x4A\x06{$version}\x52\x06{$version}",
        "\x00\x00\x00\x10\x08\x02\x32\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00"
      ];
      $buffer = $this->fetch($packets[0]);
      if (preg_match_all("/\d{1,3}\.\d{1,3}\.\d{1,3}/", $buffer->getAll(), $vers, 0, 4)) {
        $this->_data['e']['version'] = $vers[0][1];
        return $this::WITH_ERROR;
      }
      $buffer = $this->fetch($packets[1]);
      if (!$buffer || $buffer->length() < 60) {
        $buffer = $this->fetch($packets[1]);
      }
      if (!$buffer || $buffer->length() === 0) return $this::WITH_ERROR;
      $buffer->cutString(0, "\x1a");
      $this->_data['s']['name'] = $buffer->cutByte($buffer->cutByteOrd());
      $buffer->skip(30);
      $this->_data['s']['mode'] = $buffer->cutByte($buffer->cutByteOrd());
      for ($i = 0; $i < 3; $i++) {
        $buffer->skip(2);
        $this->_data['e']["mode{$i}"] = $buffer->cutByte($buffer->cutByteOrd());
      }
      $this->_data['e']['settings'] = str_replace("\x05", ";", $buffer->cutString());
      $this->_data['e']['version'] = $version; 
      return $this::SUCCESS;
    }
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
		public function getAll($s = false): string {
      if ($s) {
        return str_replace("\x00", "[null]", $this->_string);
      }
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
		public function pos(string $string) {
			return strpos($this->_string, $string);
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
		protected $_server;
		public function __construct($protocol) {
			$this->_protocol = $protocol;
		}
		private function _isHttp() {
			return $this->_protocol === Protocol::HTTP;
		}
		public function open(&$server = null) {
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
        $this->_stream = @fsockopen("{$this->_protocol}://{$server->getIp()}", $server->getQueryPort(), $errno, $errstr, 1);
        if (!$this->_stream) {
          $server->addOption('_error', $errstr);
          $server->setStatus(Server::OFFLINE);
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
        $resultStatus = curl_getinfo($this->_stream, CURLINFO_HTTP_CODE);
        if ($resultStatus != 200) {
          $err = "Request failed: HTTP status code {$resultStatus}";
        }
				if (curl_errno($this->_stream)) {
          $msg = "{$err}<br>" . curl_error($this->_stream);
          if ($this->_server) {
            $this->_server->addOption('_error', $msg);
            $this->_server->setStatus(Server::OFFLINE);
            return false;
          } else {
            return $msg;
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
		public function setOpt($name, $value) {
			curl_setopt($this->_stream, $name, $value);
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
        case "minecraft": return preg_replace("/(§.)/S", "", $string);
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
        $raw .= ($value == 0 ? "<span style='color:gray;'>[0]</span>" : $cd);
        $raw2 .= "<div class='char-element'><div class='char-cell'>{$cd}</div><div class='char-cell' ". ($value == 0 ? "style='color:gray;'" : "") .">{$value}</div></div>";
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
    static function lgslCutByte(&$buffer, $length) {
      $string = substr($buffer, 0, $length);
      $buffer = substr($buffer, $length);
      return $string;
    }
    static function bool($condition) {
      if ($condition) return 'true';
      return 'false';
    }
    static function bitComparer($bit_flags, $strings_array) {
      $result = [];
      foreach ($strings_array as $key => $string) {
        if ($bit_flags & pow(2, $key)) $result[] = $string;
      }
      return implode(" / ", $result);
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
