<?php
include "./src/lgsl_class.php";
use tltneon\LGSL;
use PHPUnit\Framework\TestCase;

class LGSLMinecraftTest extends TestCase
{
    public function testMinecraftServer(): LGSL\Server {
        echo("Testing an oldie MC server");
        ob_flush();
        $server = new LGSL\Server([
            "ip" => "MinecraftOnline.com",
            "c_port" => 25565,
            "q_port" => 25565,
            "type" => "minecraft"
        ]);
        $this->assertIsObject($server);

        $this->assertIsScalar($server->get_timestamp('s', true));
        $server->lgsl_live_query('sep');

        $this->assertTrue($server->isvalid());
        $this->assertIsArray($server->to_array());
				$this->assertIsString($server->get_name());
				$this->assertSame($server->get_game(), "minecraft");
				$this->assertSame($server->get_map(), "freedonia");
        $this->assertIsScalar($server->get_timestamp('s', true));
				return $server;
    }
		
		/**
     * @depends testMinecraftServer
     */
		public function testMinecraftExtras(LGSL\Server $server): void {
				$extra = $server->get_extras();
				$this->assertIsArray($extra);
				$this->assertArrayHasKey('version', $extra);
				$this->assertArrayHasKey('plugins', $extra);
		}
		
		/**
     * @depends testMinecraftServer
     */
		public function testMinecraftPlayers(LGSL\Server $server): void {
				$players = $server->get_players();
				$this->assertIsArray($players);
        if ($server->get_players_count('active') > 0) {
					$this->assertSame(count($server->get_players()), $server->get_players_count("active"));
        }
		}
}