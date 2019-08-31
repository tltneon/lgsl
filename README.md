# LGSL v5.9.2 (Live Game Server List) for PHP 7+
Based-off LGSL v5.8 (SA)

This is almost original version of LGSL except adding new game types and transition to PHP 7+ functions.

## Supported games:
<pre>
function lgsl_type_list()
  {
    return array(
    "aarmy"         => "Americas Army",
    "aarmy3"        => "Americas Army 3",
    "arcasimracing" => "Arca Sim Racing",
    "arma"          => "ArmA: Armed Assault",
    "arma2"         => "ArmA 2",
    "arma3"         => "ArmA 3",
    "avp2"          => "Aliens VS. Predator 2",
    "avp2010"       => "Aliens VS. Predator ( 2010 By Rebellion )",
    "bfbc2"         => "Battlefield Bad Company 2",
    "bfvietnam"     => "Battlefield Vietnam",
    "bf1942"        => "Battlefield 1942",
    "bf2"           => "Battlefield 2",
    "bf2142"        => "Battlefield 2142",
    "callofduty"    => "Call Of Duty",
    "callofdutyuo"  => "Call Of Duty: United Offensive",
    "callofdutywaw" => "Call Of Duty: World at War",
    "callofduty2"   => "Call Of Duty 2",
    "callofduty4"   => "Call Of Duty 4",
    "cncrenegade"   => "Command and Conquer: Renegade",
    "crysis"        => "Crysis",
    "crysiswars"    => "Crysis Wars",
    "cs2d"          => "Counter-Strike 2D",
    "cube"          => "Cube Engine",
    "doomskulltag"  => "Doom - Skulltag",
    "doomzdaemon"   => "Doom - ZDaemon",
    "doom3"         => "Doom 3",
    "dh2005"        => "Deer Hunter 2005",
    "farcry"        => "Far Cry",
    "fear"          => "F.E.A.R.",
    "flashpoint"    => "Operation Flashpoint",
    "freelancer"    => "Freelancer",
    "frontlines"    => "Frontlines: Fuel Of War",
    "f1c9902"       => "F1 Challenge 99-02",
    "gamespy1"      => "Generic GameSpy 1",
    "ghostrecon"    => "Ghost Recon",
    "graw"          => "Ghost Recon: Advanced Warfighter",
    "graw2"         => "Ghost Recon: Advanced Warfighter 2",
    "gtr2"          => "GTR 2",
    "had2"          => "Hidden and Dangerous 2",
    "halflife"      => "Half-Life", //Gold Source games
    "halo"          => "Halo",
    "il2"           => "IL-2 Sturmovik",
    "jediknight2"   => "JediKnight 2: Jedi Outcast",
    "jediknightja"  => "JediKnight: Jedi Academy",
    "killingfloor"  => "Killing Floor",
    "kingpin"       => "Kingpin: Life of Crime",
    "minecraft"     => "Minecraft", // Supported partially
    "mohaa"         => "Medal of Honor: Allied Assault",
    "mohaab"        => "Medal of Honor: Allied Assault Breakthrough",
    "mohaas"        => "Medal of Honor: Allied Assault Spearhead",
    "mohpa"         => "Medal of Honor: Pacific Assault",
    "mta"           => "Multi Theft Auto",
    "nascar2004"    => "Nascar Thunder 2004",
    "neverwinter"   => "NeverWinter Nights",
    "neverwinter2"  => "NeverWinter Nights 2",
    "nexuiz"        => "Nexuiz",
    "openttd"       => "Open Transport Tycoon Deluxe",
    "painkiller"    => "PainKiller",
    "plainsight"    => "Plain Sight",
    "prey"          => "Prey",
    "quakeworld"    => "Quake World",
    "quakewars"     => "Enemy Territory: Quake Wars",
    "quake2"        => "Quake 2",
    "quake3"        => "Quake 3",
    "quake4"        => "Quake 4",
    "ravenshield"   => "Raven Shield",
    "redorchestra"  => "Red Orchestra",
    "rfactor"       => "RFactor",
    "samp"          => "San Andreas Multiplayer",
    "savage"        => "Savage",
    "savage2"       => "Savage 2",
    "serioussam"    => "Serious Sam",
    "serioussam2"   => "Serious Sam 2",
    "shatteredh"    => "Shattered Horizon",
    "sof2"          => "Soldier of Fortune 2",
    "soldat"        => "Soldat",
    "source"        => "Source Games (Half-Life 2, CS: GO, GMOD, etc.)",
    "stalker"       => "S.T.A.L.K.E.R.",
    "stalkercs"     => "S.T.A.L.K.E.R. Clear Sky",
    "startrekef"    => "StarTrek Elite-Force",
    "starwarsbf"    => "Star Wars: Battlefront",
    "starwarsbf2"   => "Star Wars: Battlefront 2",
    "starwarsrc"    => "Star Wars: Republic Commando",
    "swat4"         => "SWAT 4",
    "teeworlds"     => "Teeworlds",
    "tribes"        => "Tribes ( Starsiege )",
    "tribes2"       => "Tribes 2",
    "tribesv"       => "Tribes Vengeance",
    "ts"            => "Teamspeak",
    "ts3"           => "Teamspeak 3",
    "urbanterror"   => "UrbanTerror",
    "ut"            => "Unreal Tournament",
    "ut2003"        => "Unreal Tournament 2003",
    "ut2004"        => "Unreal Tournament 2004",
    "ut3"           => "Unreal Tournament 3",
    "vcmp"          => "Vice City Multiplayer",
    "vietcong"      => "Vietcong",
    "vietcong2"     => "Vietcong 2",
    "warsow"        => "Warsow",
    "wolfet"        => "Wolfenstein: Enemy Territory",
    "wolfrtcw"      => "Wolfenstein: Return To Castle Wolfenstein",
    "wolf2009"      => "Wolfenstein ( 2009 By Raven )");
  }
 </pre>
 ## Breeze Style:
 ### Server List
 ![alt text](https://i.imgur.com/Rq1BoY0.png)
 ### Details of server
 ![alt text](https://i.imgur.com/vB2PVHI.png)
 ### Admin Panel
 ![alt text](https://i.imgur.com/oQC1hkX.png)
 
## Changelog
#### v5.9.2
- **Now LGSL can use custom styles**
- **Default style was changed to: Breeze**
	- *Suggest your custom styles!*
	- *Classic style is still exists to use*
#### v5.8.2
- **LGSL now using PHP 7**
- **Added game types:**
  - Arma 3
  - Counter-Strike: Global Offensive
  - Minecraft
  - Teamspeak and Teamspeak 3
 
*Thanks to @Wussie*

All rights goes to Richard Perry (www.greycube.com)
