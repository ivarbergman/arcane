<?php
namespace arcane\orm2;

class Relation
{

  protected $lh;
  protected $op;
  protected $rh;

  public function __construct($lh, $op, $rh)
  {
    $this->lh = $lh; 
    $this->op = $op; 
    $this->lh = $rh; 
  }
}