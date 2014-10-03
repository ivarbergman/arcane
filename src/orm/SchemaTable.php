<?
namespace arcane\orm;

class SchemaTable
{

    use \arcane\db\DI;
    use \arcane\log\DI;

    public $name;
    public $columns;
    public $keys;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function all()
    {
        $db = self::db();
        $tables = $db->fetch("SHOW TABLES LIKE 'arcanetest'");
        $result = [];
        foreach ($tables as $table)
        {
            $t = new SchemaTable($table[0]);
            $t->loadColumns();
            $t->loadKeys();
            $result[] = $t;
        }
        return $result;
    }

    public function loadColumns()
    {
        $db = self::db();
        $columns = $db->fetch("SHOW COLUMNS FROM {$this->name} ");
        $this->columns = [];
        foreach ($columns as $column)
        {
            $c = new SchemaColumn($column);
            $this->columns[] = $c;
        }
    }

    public function loadKeys()
    {
        $db = self::db();
        $keys = $db->fetch("SHOW KEYS FROM {$this->name} ");
        $this->keys = [];
        foreach ($keys as $key)
        {
            $c = new SchemaKey($key);
            $this->keys[] = $c;
        }
    }

    public function toClass($ns, $prefix)
    {
        $tpl = file_get_contents(__DIR__.'/entity.tpl');
        $table = $this;
        ob_start();
        eval("?>{$tpl}<?");
        $code = ob_get_contents();
        ob_end_clean();
        return $code;
    }

    public function saveClass($ns, $prefix, $dir)
    {
        $code = $this->toClass($ns, $prefix);
        $filename = $prefix.$this->getName(true).".php";

        file_put_contents($dir . $filename, $code);
    }

    public function getName($firstupper = false)
    {
        return $this->toCamelCase($this->name, $firstupper);
    }

    public function getNamespace($ns)
    {
        if ($ns)
        {
            return "namespace $ns;";
        }
        return "";
    }

    public static function toCamelCase($string, $firstupper = false)
    {

        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$firstupper)
            $str[0] = strtolower($str[0]);

        return $str;
    }


    public function getTable()
    {
        return $this->name;
    }

    public function getPrimaryKey()
    {
        $keys = [];
        foreach ($this->columns as $column)
        {
            if ($column->Key == 'PRI')
            {
                $keys[]= $column;
            }
        }
        return $keys;
    }

    public function sqlPrimaryKeyCondition()
    {
        $keys = $this->getPrimaryKey();
        $this->log()->dbg($keys);
        $sql = [];
        foreach ($keys as $column)
        {
            $sql[] = "{$column->Field} = :$column->Field";
        }
        return implode($sql, " AND ");
    }

    public function sqlFieldsSet()
    {
        $sql = [];
        foreach ($this->columns as $column)
        {
            if ($column->isAuto())
            {

            }
            else
            {
                $sql[] = "{$column->Field} = :{$column->Field}";
            }
        }
        return implode($sql, ", ");
    }

    public function sqlLoad()
    {
        $table = $this->getTable();
        $cond = $this->sqlPrimaryKeyCondition();
        return "SELECT * FROM {$table} WHERE $cond";
    }

    public function sqlDelete()
    {
        $table = $this->getTable();
        $cond = $this->sqlPrimaryKeyCondition();
        return "DELETE FROM {$table} WHERE $cond";
    }

    public function sqlUpdate()
    {
        $table = $this->getTable();
        $cond = $this->sqlPrimaryKeyCondition();
        $set = $this->sqlFieldsSet();
        return "UPDATE {$table} SET $set WHERE $cond";
    }

    public function sqlInsert()
    {
        $table = $this->getTable();
        $set = $this->sqlFieldsSet();
        return "INSERT INTO {$table} SET $set ";
    }

    public function sqlSave()
    {
        $table = $this->getTable();
        $cond = $this->sqlPrimaryKeyCondition();
        $set = $this->sqlFieldsSet();
        return "UPDATE {$table} SET $set WHERE $cond";
    }
}
