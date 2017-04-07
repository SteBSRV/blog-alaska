<?php
/* lib/vendors/Model/UsersManager.php */
namespace Model;
 
use \SER\BSPA\Manager;
use \Entity\Users;
 
abstract class UsersManager extends Manager
{
  /*
   *
   */
  abstract public function checkConnexion($login, $password); 
}
