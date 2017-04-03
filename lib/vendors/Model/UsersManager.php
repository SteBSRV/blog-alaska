<?php
/* lib/vendors/Model/UsersManager.php */
namespace Model;
 
use \SER\BSPA\Manager;
use \Entity\Users;
 
abstract class UsersManager extends Manager
{
	/**
   * Méthode retournant une liste d'épisodes demandés.
   * @param $debut int Le premièr episode à sélectionner
   * @param $limite int Le nombre d'épisodes à sélectionner
   * @return array La liste des episodes. Chaque entrée est une instance de Episodes.
   */
  abstract public function getAll();  
}
