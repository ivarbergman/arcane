<?php

namespace arcane\auth;

interface Auth
{

  const DINAME = __CLASS__;

  public function authorize(Authorizable $object);
  public function login(Authorizable $object);
  public function logout(Authorizable $object);
  public function isLoggedin(Authorizable $object);

}