<?

include('./vendor/autoload.php');

use arcane\DI;
use arcane\Config;
use arcane\Log;
use arcane\DB;

use arcane\Config\ConfigArray;
use arcane\Log\FileLog;
use arcane\DB\MySqlDB;


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

$db = new MySqlDB();
$log = new FileLog();
$log->loadConfig( $cfg['db']['log'] );
$db->injectLog( $log );
DI::register( $db );

Log::dbg('Tjoho!!!');
echo Config::get('test', 'foo') .PHP_EOL;
print_r( DB::fetch('SHOW VARIABLES LIKE "max_connections"') );

$cl = DI::classloader();
$m = $cl->getMetaClass('\arcane\log\FileLog');
echo ($m->getName());