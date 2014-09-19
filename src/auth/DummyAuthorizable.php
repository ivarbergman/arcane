<?php

namespace arcane\auth;

class DummyAuthorizable implements Authorizable
{
    var $name = "Dummy";

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getAuthName()
    {
        return $this->name;
    }

    public function getAuthPasswd()
    {
        return $this->name;
    }

}
