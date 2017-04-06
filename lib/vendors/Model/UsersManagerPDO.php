<?php
/* lib/vendors/Model/UsersManagerPDO.php */
namespace Model;
 
use \Entity\Users;
 
class UsersManagerPDO extends UsersManager
{
	public function add(Users $user)
	{
	    $requete = $this->dao->prepare('INSERT INTO users SET login = :login, password = :pass_sha1, email = :email, lastVisitDate = NOW(), inscriptionDate = NOW(), level = 1');
	 
	    $requete->bindValue(':login', $user->getLogin());
	    $requete->bindValue(':pass_sha1', $user->getPassword());
	    $requete->bindValue(':email', $user->getEmail());
	 
	    if($requete->execute())
	    {
	    	return true;
	    }
	    return false;
	}

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

	public function checkConnexion($login, $password)
	{
		$requete = $this->dao->prepare('SELECT login FROM users WHERE login = :login AND password = :password');
		$requete->bindValue(':login', $login);
		$requete->bindValue(':password', $password);

	    $requete->execute();
	 
	    /*$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');*/
	 
	    if ($requete->fetch())
	    {
	    	return true;
	    }
	 
	    return false;
	}
}  
