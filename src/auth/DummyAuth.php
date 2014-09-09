<?php

namespace arcane\auth;

class DummyAuth  implements Auth 
{

  use \arcane\log\DI;


  public function __construct($user = null)
  {
  }

  public function authorize(Authorizable $user)
  {
    if ($user->getAuthName() && $user->getAuthPasswd())
      {
	return true;
      }
    return false;
  }

  public function login(Authorizable $user)
  {
    $file = $this->getFile($user);
    file_put_contents($file, $user->getAuthPasswd());
    $this->log()->dbg("DummyAuth::login {$file}");
    return true;
  }

  public function logout(Authorizable $user)
  {
    $file = $this->getFile($user);
    unlink($file);
    $this->log()->dbg("DummyAuth::logout {$file}");
    return true;
  }

  public function isLoggedin(Authorizable $user)
  {
    $file = $this->getFile($user);
    return file_exists($this->file);
  }

  private function getFile(Authorizable $user)
  {
    return '/tmp/dummy_'.$user->getAuthName();
  }

}