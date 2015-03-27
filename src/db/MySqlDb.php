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

            $user = $this->config()->get("db", "user");
            $pass = $this->config()->get("db", "password");
            $host = $this->config()->get("db", "host");
            $database = $this->config()->get("db", "database");

            $dsn = "mysql:host={$host};dbname={$database}";

            try {

                self::$db = new \PDO($dsn, $user, $pass, array(
                                         \PDO::ATTR_PERSISTENT => true
                                         ));

                self::$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

            } catch (Exception $e)
              {
                  $this->log()->log("MySqlDb connect error: dsn: " . $dsn);
                  $this->log()->log($e);
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
            $this->log()->log("execute($sql)");
            $this->log()->log($args);
            $this->log()->log($stmt->errorInfo());
        }
        return $result;
    }

    public function query($sql)
    {

    }

    public function get($sql)
    {
        $args = func_get_args();
        $stmt = call_user_func_array(array($this, "prepare"), $args);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\arcane\orm\ResultClass');
        $stmt->execute();
        if (!$stmt->errorCode() > 0)
        {
            $this->log()->log($sql);
            $this->log()->log($stmt->errorCode());
            $this->log()->log($stmt->errorInfo());
        }

        return $stmt;
    }

    public function fetch($sql)
    {
        $args = func_get_args();
        $stmt = call_user_func_array(array($this, "prepare"), $args);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        if (!$result)
        {
            $this->log()->log($sql);
            $this->log()->log($stmt->errorInfo());
        }

        return $result;
    }

    public function fetchArray($sql)
    {
        $args = func_get_args();
        $stmt = call_user_func_array(array($this, "prepare"), $args);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_BOTH);
        if (!$result)
        {
            $this->log()->log($sql);
            $this->log()->log($stmt->errorInfo());
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
                    if ($this->testParameterName($sql, $name1))
                    {
                        $stmt->bindParam(":{$name1}", $value1);
                    }
                }
            }
            else if ($value instanceof \arcane\orm\IEntity)
            {
                foreach ($value as $name1 => $value1)
                {
                    if ($this->testParameterName($sql, $name1))
                    {
                        $v = $value1->value();
                        $stmt->bindParam(":{$name1}", $v);
                    }
                }
            }
            else if (is_object($value))
            {
                foreach ($value as $name1 => $value1)
                {
                    if ($this->testParameterName($sql, $name1))
                    {
                        $stmt->bindParam(":{$name1}", $value1);
                    }
                }
            }
            else
            {
                $stmt->bindParam(":$name", $value);
            }
        }

        return $stmt;
    }

    private function testParameterName($sql, $name)
    {
        $result = preg_match("/:{$name}[^a-z0-9_]?/", $sql);
        return $result;
    }

    public function uuid()
    {
        $r = $this->fetch("SELECT UUID() AS UUID");
        return $r ? $r[0]->UUID : null;
    }

    public function lastInsertId()
    {
        $db = $this->connect();
        return $db->lastInsertId();
    }

}
