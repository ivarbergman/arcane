<?php

namespace arcane\db;

interface Db
{
  const DINAME = __CLASS__;

  public function execute($sql);
  public function query($sql);

}