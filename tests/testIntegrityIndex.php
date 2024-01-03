<?php
include "./src/lgsl_class.php";
use tltneon\LGSL;
use PHPUnit\Framework\TestCase;

class LGSLIntegrityTest extends TestCase
{
    public function testIntegrity(): void {
        $this->assertDirectoryExists('./src/');
        $this->assertFileExists('./src/lgsl_class.php');
    }
    
    public function testCommonFunctions(): void {
        $this->assertIsArray(LGSL\LGSL::locationCoords("XX"));
    }
}