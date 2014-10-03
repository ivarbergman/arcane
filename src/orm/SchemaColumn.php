<?php

namespace arcane\orm;

class SchemaColumn
{

    use \arcane\config\DI;
    use \arcane\db\DI;
    use \arcane\log\DI;

    public $Field;
    public $Type;
    public $Null;
    public $Default;
    public $Key;
    public $Extra;

    public function __construct($row)
    {
        foreach ($row as $name => $value)
        {
            if (property_exists($this, $name))
            {
                $this->{$name} = $value;
            }
        }
    }
    public function getName($firstupper = false)
    {
        return SchemaTable::toCamelCase($this->Field, $firstupper);
    }

    public function getType()
    {
        $type = preg_split('/[\(\)]/', $this->Type);
        return $type[0];
    }

    public function isAutoIncrement()
    {
        return strpos($this->Extra, "auto_increment") !== false;
    }

    public function isOnUpdate()
    {
        $this->log()->dbg("isOnUpdate {$this->Extra}");
        return strpos($this->Extra, "on update") !== false;
    }

    public function isAuto()
    {
        return $this->isOnUpdate() || $this->isAutoIncrement();
    }

    public function __toString()
    {
        $str = "";
        foreach ($this as $name => $value)
        {
            $str .= "$name: $value, ";
        }
        return $str;
    }

    public function toAttribute()
    {
        $a = new Attribute($this->getName());
        $a->type = $this->getType();
        $a->precision = $this->getTypePrecision();
        $a->null = $this->Null;
        $a->key = $this->Key;
        return $a;
    }

    public function getTypePrecision()
    {
        $type = preg_split('/[\(\)]/', $this->Type);
        if (isset($type[1]))
        {
            return $type[1];
        }
        return null;
    }
}