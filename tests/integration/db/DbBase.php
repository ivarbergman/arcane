<?php

use arcane\DI;
use arcane\Config;
use arcane\Log;
use arcane\DB;

use arcane\Config\ConfigArray;
use arcane\Log\FileLog;
use arcane\DB\MySqlDB;


class DbBase extends PHPUnit_Framework_TestCase
{

    public static $di;
    public static $config;
    public static $db;
    public static $log;

    public static function setUpBeforeClass()
    {

        $cfg = [
            'db' => [
                'user' => 'root',
                'password' => '',
                'host' => 'localhost',
                'database' => 'test',

                'log' => [
                    'file' => '/tmp/bump-db.log'
                    ]

                ],
            'log' => [
                'file' => '/tmp/bump.log'
                ]
            ];

        DI::register( new ConfigArray($cfg) );
        DI::register( new FileLog() );
        DI::register( new MySqlDB() );

        $cl = \arcane\classloader\ArcaneLoader::instance();

        $sqls = [
            "CREATE TABLE IF NOT EXISTS arcanetest ( id INT PRIMARY KEY AUTO_INCREMENT, foo VARCHAR(32))",
            "INSERT INTO arcanetest (foo) VALUES ('bar')",
            "INSERT INTO arcanetest (foo) VALUES ('rab')",
            ];

        DB::batch($sqls);

    }

    public static function tearDownAfterClass()
    {
        $sqls = [
            "DROP TABLE IF EXISTS arcanetest",
            ];

        DB::batch($sqls);

    }

}