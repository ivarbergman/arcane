<?php

namespace arcane\auth;

interface Authorizable
{

  public function getAuthName();
  public function getAuthPasswd();

}