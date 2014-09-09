<?php
namespace arcane\orm2;

class Query
{

  protected $where;

  public function __construct()
  {
    $this->where = new Condition();
  }
  
  public function eq($lh, $rh)
  {
    return new Relation($lh, Operand::EQ, $rh);
  }

  public function neq($lh, $rh)
  {
    return new Relation($lh, Operand::NEQ, $rh);
  }

  public function where()
  {
    return $this->where;
  }


}