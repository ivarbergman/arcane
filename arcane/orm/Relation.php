<?php

namespace arcane\orm;

class Relation
{

  protected $lh;
  protected $op;
  protected $rh;

  public function __construct(Attribute $lh, $op, $rh)
  {
    $this->lh = $lh;
    $this->op = $op;
    $this->rh = $rh;
  }

  public function export()
  {
    return " {$this->lh->name()} {$this->op} {$this->rh}";
  }

}