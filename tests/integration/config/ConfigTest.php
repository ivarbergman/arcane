<?php
class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->config = new \arcane\config\ConfigArray();
        $this->config->load('file', __DIR__."/file.php");
    }

    public function tearDown()
    {

    }


    public function testGet()
    {

        $this->config->set("FOO VALUE", "FOO");
        $r = $this->config->get("FOO");
        $this->assertEquals("FOO VALUE", $r);
    }

    public function testHasNS()
    {

        $r = $this->config->hasNS("file");
        $this->assertEquals(true, $r);
    }

    public function testLoad()
    {

        $r = $this->config->get("file", "foo");
        $this->assertEquals("bar", $r);
    }
}
