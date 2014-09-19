<?php
namespace arcane\log;

class StdLogTest extends \PHPUnit_Framework_TestCase
{

  private $log;
  private $stream;
  private $stream_var;

  public function setUp()
  {
    ini_set("display_errors", '0');
    $this->stream = fopen("php://memory", "w+");
    $this->log = new \arcane\log\StdLog();
  }

  public function tearDown()
  {
    fclose($this->stream);
  }

  /* ************************************************** */

  public function testStream()
  {
    $this->assertEquals(true, is_resource($this->stream));        
  }

  /**
   * @depends testStream
   */
  public function testDbg()
  {    
    $this->level(E_USER_NOTICE);
    $this->log->dbg("THE DBG TEST");
    $r = $this->read();
    $this->assertEquals("THE DBG TEST", $r);    
  }

  /**
   * @depends testStream
   */
  public function testDbgEmpty()
  {    
    $this->level(1);
    $this->log->dbg("THE DBG TEST");
    $r = $this->read();
    $this->assertEquals("", $r);    
  }

  /**
   * @depends testStream
   */
  public function testLog()
  {
    
    $this->level(E_USER_WARNING);
    $this->log->log("THE LOG TEST");
    $r = $this->read();
    $this->assertEquals("THE LOG TEST", $r);
    
  }

  /**
   * @depends testStream
   */
  public function testLogEmpty()
  {
    
    $this->level(1);
    $this->log->log("THE LOG TEST");
    $r = $this->read();
    $this->assertEquals("", $r);
    
  }


  /* ************************************************** */
  public function write($errno, $error)
  {
    fwrite($this->stream, $error);
  }

  private function level($level)
  {
    set_error_handler(array($this, "write"), $level);
  }

  private function read()
  {
    rewind($this->stream);
    $r = stream_get_contents($this->stream);
    fflush($this->stream);
    return $r;
  }


}


