<?php

namespace arcane\orm;

class Condition extends Relation
{

  public function __construct(Relation $lh, $op, Relation $rh)
  {
    $this->lh = $lh;
    $this->op = $op;
    $this->rh = $rh;
  }

  public function export()
  {
    return " {$this->lh} {$this->op} {$this->rh}";
  }

}