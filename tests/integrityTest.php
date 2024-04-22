<?php
  include_once "./src/lgsl_class.php";
  use tltneon\LGSL;
  use PHPUnit\Framework\TestCase;

	class LGSLIntegrityTest extends TestCase {
		public function testIntegrity(): void {
			print("\nTesting LGSL main functions");
			$this->assertDirectoryExists('./src/');
			$this->assertFileExists('./src/lgsl_class.php');
		}
		public function testProtocolsIcons(): void {
			foreach (LGSL\Protocol::lgsl_type_list() as $type => $name) {
				if ($type === LGSL\Protocol::TEST) continue;
				$server = new LGSL\Server(["type" => $type]);
				$this->assertNotSame($server->getGameIcon("src/"), "src/other/icon_unknown.gif", "{$type} has no icon");
			}
		}
	}