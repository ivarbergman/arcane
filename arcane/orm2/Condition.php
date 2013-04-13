<?php
namespace arcane\orm2;

class Condition
{

  protected $parent;
  protected $lh;
  protected $op;
  protected $rh;


  public function __construct($lh = null, $op = null, $rh = null)
  {
    
  }

  public function land($lh, $rh)
  {
    $c = new Condition($lh, Operand::LAND, $rh);
    $c->setParent($this);
    return $c;
  }

  public function lor($lh, $rh)
  {
    $c = new Condition($lh, Operand::LOR, $rh);
    $c->setParent($this);
    return $c;
  }

  public function setParent($c)
  {
    $this->parent = $c;
  }


}