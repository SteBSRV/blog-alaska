<?php
/* lib/vendors/Model/UsersManagerPDO.php */
namespace Model;
 
use \Entity\Users;
 
class UsersManagerPDO extends UsersManager
{
	public function getAll()
	{
	    $requete = $this->dao->query('SELECT id, login, password, email, lastVisitDate, InscriptionDate, level FROM users ORDER BY id DESC');
	    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
	 
	    $listeUsers = $requete->fetchAll();
	 
	 	// Récupération des dates au format DateTime
	    foreach ($listeUsers as $user)
	    {
	      $user->setLastVisitDate(new \DateTime($user->getLastVisitDate()));
	      $user->setInscriptionDate(new \DateTime($user->getInscriptionDate()));
	    }
	 
	    $requete->closeCursor();
	 
	    return $listeUsers;
	}

	public function loginExists($login)
	{
		$requete = $this->dao->prepare('SELECT login FROM users WHERE login = "' . $login .'"');
	    $requete->execute();
		
		return $exists = ($requete->fetch()) ? true : false;
	}

	public function checkConnexion($user)
	{
		$requete = $this->dao->prepare('SELECT login FROM users WHERE login = "' . $login .'"');
	    $requete->execute();
	 
	    /*$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');*/
	 
	    if ($requete->fetch())
	    {
	      return true;
	    }
	 
	    return false;
	}
}  
