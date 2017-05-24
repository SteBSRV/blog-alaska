<?php
/* lib/vendors/Model/UsersManager.php */
namespace Model;
 
use \SER\BSPA\Manager;
use \Entity\Users;
 
abstract class UsersManager extends Manager
{
  /**
   * Méthode permettant de vérifier si le login demandé existe bien.
   * @param
   * @return bool
   */
  abstract public function loginExists($login); 

  /**
   * Méthode permettant de vérifier l'authenticité de l'utilisateur.
   * @param $login Le login de l'utilisateur à vérifier.
   * @param $password Le mot de passe de l'utilsiateur à vérifier.
   * @return bool
   */
  abstract public function checkConnexion($login, $password); 
}
