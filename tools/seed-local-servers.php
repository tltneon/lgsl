<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqlPassword = isset($argv[1]) ? $argv[1] : "usbw";
$db = mysqli_connect("127.0.0.1", "root", $mysqlPassword, "lgsl", 3306);
mysqli_set_charset($db, "utf8mb4");

$servers = array(
  array("EMIRATES.KiNGS 亗 GAMEAREA ||͇̿P͇̿U͇̿B͇̿L͇̿I͇̿C͇̿| ✪", "51.38.60.53", 27015, "de_dust2", 32, 32),
  array("(33:10) ANORMALII.LEAGUECS.RO # BE ANORMAL", "51.195.71.210", 27015, "de_barcelona", 30, 32),
  array("ROMANIA.FULLBOOST.RO V.I.P FREE", "139.162.153.162", 27015, "de_amr", 30, 32),
  array("CS-TERVEL.NET # Dust2 Only", "139.162.185.34", 27015, "de_dust2", 31, 32),
  array(".:: NESTLE.LEAGUECS.RO # VIP FREE 24/7 ::.", "217.156.22.211", 27015, "de_inferno", 29, 32),
  array("REBELII.LEAGUECS.RO - CLASSIC SERVER | VIP FREE", "172.104.253.92", 27015, "de_dust2", 29, 32),
  array("РЕАЛЬНЫЕ ПАЦАНЫ-ДЕВУШКИ 18+ [STEAM BONUS]", "91.211.118.152", 27015, "de_cloister2", 30, 32),
  array("~ Zombie Plague GunXP 24/7 ~ Double XP 06-10PM EET", "135.125.147.173", 27017, "zm_deko2", 30, 32),
  array("SUD.LALEAGANE.RO [LEGENDS NEVER DIE]", "141.95.4.187", 27015, "de_dust2", 31, 32),
  array("Techline Gaming | Zombie Escape | [Multi-Jumps x2 + FREE VIP]", "92.118.207.11", 27016, "ze_goto_escape2", 31, 32),
  array("|PUBLIC #4| • ЛИЦА В ПОЛ • [18+]", "45.136.205.48", 27015, "de_dustyaztec", 26, 32),
  array("[ZOMBIES]+[CSO MOD] [#1] CSOMOD.COM [since 2012]", "81.181.244.5", 27015, "zm_forza", 32, 32),
  array("FRIENDS.FANMIX.RO | FREE VIP ALL TIME", "81.181.244.49", 27015, "de_dust2", 27, 32),
  array("CS.TEAMGAME.RO --> Friends & More", "217.156.22.86", 27015, "de_amr", 28, 32),
  array("SaBoR 4FUN[PATENTE][SKINS][1000FPS] @Brasil-Server", "177.54.152.59", 27025, "de_dust2", 22, 32),
);

$now = time();
$cacheTime = $now . "_" . $now . "_" . $now;
$select = mysqli_prepare($db, "SELECT id FROM `lgsl` WHERE `type`=? AND `ip`=? AND `q_port`=? LIMIT 1");
$insert = mysqli_prepare($db, "INSERT INTO `lgsl` (`type`,`ip`,`c_port`,`q_port`,`s_port`,`zone`,`disabled`,`comment`,`status`,`cache`,`cache_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$update = mysqli_prepare($db, "UPDATE `lgsl` SET `c_port`=?, `s_port`=?, `zone`=?, `disabled`=0, `comment`=?, `status`=1, `cache`=?, `cache_time`=? WHERE `id`=?");

$type = "halflife";
$sPort = 0;
$zone = "0";
$disabled = 0;
$comment = "Seeded local test server";
$added = 0;
$updated = 0;

foreach ($servers as $srv) {
  list($name, $ip, $port, $map, $players, $maxPlayers) = $srv;
  $cache = array(
    "b" => array("status" => 1, "pending" => 0),
    "s" => array(
      "game" => "cstrike",
      "name" => $name,
      "map" => $map,
      "players" => $players,
      "playersmax" => $maxPlayers,
      "password" => 0,
      "cache_time" => $now,
      "history" => array(),
    ),
    "e" => array(),
    "p" => array(),
    "o" => array("location" => ""),
  );

  $packed = base64_encode(serialize($cache));
  mysqli_stmt_bind_param($select, "ssi", $type, $ip, $port);
  mysqli_stmt_execute($select);
  $result = mysqli_stmt_get_result($select);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    $id = (int) $row["id"];
    mysqli_stmt_bind_param($update, "iissssi", $port, $sPort, $zone, $comment, $packed, $cacheTime, $id);
    mysqli_stmt_execute($update);
    $updated++;
  } else {
    $status = 1;
    mysqli_stmt_bind_param($insert, "ssiiisissss", $type, $ip, $port, $port, $sPort, $zone, $disabled, $comment, $status, $packed, $cacheTime);
    mysqli_stmt_execute($insert);
    $added++;
  }
}

echo "Seed complete: added={$added}, updated={$updated}\n";
