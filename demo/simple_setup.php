<?php

include('../bootstrap.php');

use arcane\DI;
use arcane\Config;
use arcane\Log;
use arcane\DB;

use arcane\Config\ConfigArray;
use arcane\Log\FileLog;
use arcane\Log\StdoutLog;
use arcane\DB\MySqlDB;


$cfg = [
  'db' => [
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'database' => 'test',

    'log' => [
      'file' => '/tmp/bump-db.log',
      'level' => E_USER_WARNING
    ]

  ],
  'log' => [
    'file' => '/tmp/bump.log',
    'level' => E_USER_ERROR
  ]
];

// Register a few services in the dependency manager.
DI::register( new ConfigArray($cfg) );
DI::register( new FileLog() );
DI::register( new MySqlDB() );

// Create a db specific log service
$log = new FileLog();
$log->loadConfig( $cfg['db']['log'] );
DB::di()->injectLog( $log );

// Try a few log calls on different levels.
Log::dbg('Tjoho dbg!!!');
Log::log('Tjoho log!!!');
Log::error('Tjoho error!!!');

// Create a STDOUT logger.
$stdout = new StdoutLog();
$stdout->setLevel(E_USER_NOTICE);

// Execute a db statement, response should go into the db log.
$stdout->dbg( DB::fetch('SHOW VARIABLES LIKE "max_connections"')  );
$stdout->dbg( DB::fetch('SHOW SOME SYNTAX ERROR')  );


// Use the STDOUT logger
$stdout->dbg( Config::get('db', 'user') );

// Fetch a Meta class
$cl = DI::classloader();
$m = $cl->getMetaClass('\arcane\log\FileLog');
$stdout->dbg( $m->getName() );
