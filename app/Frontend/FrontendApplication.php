<?php
namespace App\Frontend;
 
use \SER\BSPA\Application;
 
class FrontendApplication extends Application
{
  public function __construct()
  {
    parent::__construct();
 
    $this->name = 'Frontend';
  }
 
  public function run()
  {
    if ($this->httpRequest->cookieExists('login'))
    {
      $login = $_COOKIE['login'];
      $password = $_COOKIE['password'];
      // Check connexion
      
    }
    $controller = $this->getController();
    $controller->execute();
 
    $this->httpResponse->setPage($controller->page());
    $this->httpResponse->send();
  }
}
