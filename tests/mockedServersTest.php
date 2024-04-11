<?php
  include_once "./src/lgsl_class.php";
  use tltneon\LGSL\Stream;
  use tltneon\LGSL\Server;
  use tltneon\LGSL\Protocol;
  use PHPUnit\Framework\TestCase;
    class StreamMock extends Stream {
        public $type = "";
        public function open(&$server = null) {$this->type = $server->get_type(); return true;}
        public function write($data) {}
        public function readRaw($length = 4096) {
            return str_replace("[null]", "\x00", example($this->type));
        }
    }
    function example($type) {
        $list = [
            Protocol::MINECRAFTPE => "[null][null][null][null][null]6��[null]c�wV4�[null]��[null]��������4Vx[null]^MCPE;§r§eLGSLSERVERNAME;649;1.20.60;34;500;63020977098711111;Bedrock Edition;Survival;1;19132;19132;",
        ];
        return $list[$type];
    }

    class LGSLMockedTest extends TestCase {
        public function testMockedServers() {
            echo("\nTesting mocked servers");
            ob_flush();
            foreach ([Protocol::MINECRAFTPE] as $type) {
                $server = new Server(["ip" => "LgslServerIp.com", "c_port" => 25565, "q_port" => 25565, "type" => $type]);
                $protocol = new Protocol($server, null);
                $query =  "tltneon\LGSL\\" . $protocol->lgslProtocolClass($server->get_type());
                $stream = new StreamMock($server);
                $stream->open($server);
                $need = [];
                $status = (new $query($server, $stream, $need))->execute();
                $server->set_queried();

                $this->assertSame($server->get_name(), "LGSLSERVERNAME");
            }
        }
    }