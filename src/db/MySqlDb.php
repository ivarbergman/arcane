<?php

namespace arcane\db;

class MySqlDb implements Db
{

    use \arcane\log\DI;

    public function execute($sql)
    {
        $this->log()->dbg("execute($sql)");
    }
    public function query($sql)
    {
        $this->log()->dbg("query($sql)");
    }

}