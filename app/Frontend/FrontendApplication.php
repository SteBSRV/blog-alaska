<?php
namespace App\Frontend;
 
use \SER\BSPA\Application;
use \Model\UsersManagerPDO;
 
class FrontendApplication extends Application
{
  public function __construct()
  {
    parent::__construct();
 
    $this->name = 'Frontend';
  }
 
  public function run()
  {
    $controller = $this->getController();
    $controller->execute();
 
    $this->httpResponse->setPage($controller->page());
    $this->httpResponse->send();
  }
}
