<?php
class StackTest extends PHPUnit_Framework_TestCase
{

  private $stack;

  public function setUp()
  {
    $this->stack = [];
  }
  
  public function tearDown()
  {
    unset($this->stack);
  }
  
  public function testPushAndPop()
  {
    $this->assertEquals(0, count($this->stack));
    
    array_push($this->stack, 'foo');
    $this->assertEquals('foo', $this->stack[count($this->stack)-1]);
    $this->assertEquals(1, count($this->stack));
    
    $this->assertEquals('foo', array_pop($this->stack));
    $this->assertEquals(0, count($this->stack));

  }
}
