<?php

use arcane\Config;
use arcane\Log;
use arcane\DB;

include('SchemaBase.php');
class SchemaTest extends SchemaBase
{

    public function testShowTables()
    {
        $tables = arcane\orm\SchemaTable::all();
        //Log::dbg($tables);
        foreach ($tables as $table)
        {
            $table->saveClass("arcaneorm", "MyTest", "/tmp/arcaneorm/");
        }
        $this->assertEquals(1, count($tables));
    }

}
