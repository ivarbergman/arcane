<?php

use arcane\Config;
use arcane\Log;
use arcane\DB;

include('DbBase.php');
class MySqlDbTest extends DbBase
{

    public function testConfig()
    {

        $r = Config::hasNS("db");
        $this->assertEquals(true, $r);
    }

    public function testShowTables()
    {
        $sql = "SHOW TABLES like '%arcanetest%'";
        $r = DB::fetch($sql);
        $this->assertEquals(1, count($r));
    }

    public function testDbFetchAll()
    {
        $sql = "SELECT * FROM arcanetest ";
        $r = DB::fetch($sql);
        $this->assertEquals(2, count($r));
    }

    public function testDbFetch()
    {
        $params = [
            'id' => 1
            ];

        $sql = "SELECT * FROM arcanetest WHERE id > :id ";
        $r = DB::fetch($sql, $params);
        $this->assertEquals(1, count($r));
    }

    public function testDbFetchObjectParam()
    {
        $obj = new StdClass();
        $obj->id = 1;
        $obj->ida = 1;
        $obj->idb = 1;

        $sql = "SELECT * FROM arcanetest WHERE id > :id  AND id >= :id ";
        $r = DB::fetch($sql, $obj);
        $this->assertEquals(1, count($r));
    }

    public function testUUID()
    {
        $uuid = DB::uuid();
        $this->assertEquals(36, strlen($uuid));
    }

    public function testLastInsertID()
    {
        $sql = "INSERT INTO arcanetest (foo) VALUES ('test')";
        $r = DB::execute($sql);
        $id = DB::lastInsertId();
        $this->assertGreaterThan(0, $id);
    }
}
