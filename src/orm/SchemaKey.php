<?php

namespace arcane\orm;

class SchemaKey
{

    use \arcane\config\DI;
    use \arcane\db\DI;

    public $Table;
    public $Non_unique;
    public $Key_name;
    public $Seq_in_index;
    public $Column_name;
    public $Collation;
    public $Cardinality;
    public $Sub_part;
    public $Packed;
    public $Null;
    public $Index_type;
    public $Comment;
    public $Index_comment;

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


}