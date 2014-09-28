<?php

namespace arcane\db;

class MySqlDb implements Db
{

    use \arcane\config\DI;
    use \arcane\log\DI;

    private static $db;

    public function __construct()
    {

    }

    public function connect()
    {
        if ( ! isset(self::$db))
        {

            $this->log()->dbg("MySqlDb connect dsn: ");

            $user = $this->config()->get("db", "user");
            $pass = $this->config()->get("db", "password");
            $host = $this->config()->get("db", "host");
            $database = $this->config()->get("db", "database");

            $dsn = "mysql:host={$host};dbname={$database}";

            try {

                self::$db = new \PDO($dsn, $user, $pass, array(
                                         \PDO::ATTR_PERSISTENT => true
                                         ));
            } catch (Exception $e)
              {
                  $this->log()->dbg("MySqlDb connect error: dsn: " . $dsn);
                  $this->log()->dbg($e);
              }

        }

        return self::$db;
    }


    public function batch($sqls)
    {
        foreach ($sqls as $sql)
        {
            $this->execute($sql);
        }
    }

    public function execute($sql)
    {

        $args = func_get_args();
        $stmt = call_user_func_array(array($this, "prepare"), $args);

        $result = $stmt->execute();
        if (!$result)
        {
            $this->log()->dbg($stmt->errorInfo());
        }
        return $result;
    }

    public function query($sql)
    {

    }

    public function fetch($sql)
    {
        $args = func_get_args();
        $stmt = call_user_func_array(array($this, "prepare"), $args);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!$result)
        {
            $this->log()->dbg($sql);
            $this->log()->dbg($stmt->errorInfo());
        }

        return $result;
    }

    public function prepare($sql)
    {

        $args = func_get_args();

        $sql = array_shift($args);

        $db = $this->connect();

        $stmt = $db->prepare($sql);

        foreach ($args as $name => $value)
        {
            if (is_array($value))
            {
                foreach ($value as $name1 => $value1)
                {
                    $stmt->bindParam(":{$name1}", $value1);
                }
            }
            else if (is_object($value))
            {
                foreach ($value as $name1 => $value1)
                {
                    $stmt->bindParam(":{$name1}", $value1);
                }
            }
            else
            {
                $stmt->bindParam(":$name", $value);
            }
        }

        return $stmt;
    }


    public function uuid()
    {
        $r = $this->fetch("SELECT UUID()");
        return $r ? $r[0][0] : null;
    }

    public function lastInsertId()
    {
        $db = $this->connect();
        return $db->lastInsertId();
    }

}
