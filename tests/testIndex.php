<?php
include "./src/lgsl_class.php";
use tltneon\LGSL;
use PHPUnit\Framework\TestCase;

class LGSLTest extends TestCase
{
    public function testMockServer(): LGSL\Server {
        echo("Testing mock server");
        ob_flush();
        $server = new LGSL\Server([
            "ip" => "127.0.0.1",
            "c_port" => 12345,
            "q_port" => 2342,
            "type" => "test"
        ]);
        $this->assertIsObject($server);

        $this->assertIsScalar($server->get_timestamp('s', true));
        $server->lgsl_live_query('sep');

        $this->assertTrue($server->isvalid());
        $this->assertIsArray($server->to_array());

        if ($server->get_status() === LGSL\Server::OFFLINE) {
					$this->assertSame($server->get_game(), "test");
        } else {
					$this->assertSame($server->get_game(), "test_game");
        }
        $this->assertIsScalar($server->get_timestamp('s', true));
				return $server;
    }
		
		/**
     * @depends testMockServer
     */
		public function testMockExtras(LGSL\Server $server): void {
				$extra = $server->get_extras();
				$this->assertIsArray($extra);
				$this->assertSame($extra['testextra1'], "normal");
		}
		
		/**
     * @depends testMockServer
     */
		public function testMockPlayers(LGSL\Server $server): void {
				$players = $server->get_players();
				$this->assertIsArray($players);
        if ($server->get_players_count('active') > 0) {
					$this->assertSame($players[0]['name'], "Normal");
        }
		}
		
    public function testCommonFunctions(): void {
        $this->assertIsArray(LGSL\LGSL::locationCoords("XX"));
    }
}