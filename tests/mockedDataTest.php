<?php
  include_once "./src/lgsl_class.php";
  use tltneon\LGSL;
  use PHPUnit\Framework\TestCase;

  class LGSLTest extends TestCase {
      public function testMockServer(): LGSL\Server {
          print("\nTesting server's functions");
          ob_flush();
          $server = new LGSL\Server([
              "ip" => "127.0.0.1",
              "c_port" => 12345,
              "q_port" => 2342,
              "type" => "test"
          ]);
          $this->assertIsObject($server);

          $this->assertIsScalar($server->getTimestamp(LGSL\Timestamp::SERVER));
          $server->queryLive('sep');

          $this->assertTrue($server->isValid());
          $this->assertIsArray($server->toArray());

          if ($server->getStatus() === LGSL\Server::OFFLINE) {
            $this->assertSame($server->getGame(), PROTOCOL::TEST);
          } else {
            $this->assertSame($server->getGame(), "test_game");
          }
          $this->assertIsScalar($server->getTimestamp(LGSL\Timestamp::SERVER));
          return $server;
      }
      
      /**
       * @depends testMockServer
       */
      public function testMockExtras(LGSL\Server $server): void {
          $extra = $server->getExtrasArray();
          $this->assertIsArray($extra);
          if (count($extra) > 0) {
            $this->assertSame($extra['testextra1'], "normal");
          }
      }
      
      /**
       * @depends testMockServer
       */
      public function testMockPlayers(LGSL\Server $server): void {
          $players = $server->getPlayersArray();
          $this->assertIsArray($players);
      }
      
      public function testCommonFunctions(): void {
          $this->assertIsArray(LGSL\LGSL::locationCoords("XX"));
      }
  }