<?php
  include_once "./src/lgsl_class.php";
  use tltneon\LGSL;
  use PHPUnit\Framework\TestCase;

  class LGSLMinecraftTest extends TestCase {
    public function testMinecraftServer(): LGSL\Server {
      echo("\nTesting an oldie MC server");
      ob_flush();
      $server = new LGSL\Server([
        "ip" => "MinecraftOnline.com",
        "c_port" => 25565,
        "q_port" => 25565,
        "type" => "minecraft"
      ]);
      $this->assertIsObject($server);

      $this->assertIsScalar($server->getTimestamp(LGSL\Timestamp::SERVER));
      $server->queryLive('sep');

      $this->assertTrue($server->isValid());
      $this->assertIsArray($server->toArray());
      $this->assertIsString($server->getName());
      $this->assertSame($server->getGame(), "minecraft");
      if ($server->isOnline())
      $this->assertSame($server->getMap(), "freedonia");
      $this->assertIsScalar($server->getTimestamp(LGSL\Timestamp::SERVER));
      return $server;
    }
    
    /**
     * @depends testMinecraftServer
     */
    public function testMinecraftExtras(LGSL\Server $server): void {
      $extra = $server->getExtrasArray();
      $this->assertIsArray($extra);
      if ($server->isOnline()) {
        $this->assertArrayHasKey('version', $extra);
        $this->assertArrayHasKey('plugins', $extra);
      }
    }
    
    /**
     * @depends testMinecraftServer
     */
    public function testMinecraftPlayers(LGSL\Server $server): void {
      $players = $server->getPlayersArray();
      $this->assertIsArray($players);
      if ($server->getPlayersCount() > 0) {
        $this->assertSame(count($server->getPlayersArray()), $server->getPlayersCount());
      }
    }
  }