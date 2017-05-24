<?php
/* lib/vendors/Model/UsersManagerPDO.php */
namespace Model;
 
use \Entity\Users;
 
class UsersManagerPDO extends UsersManager
{
	public function loginExists($login)
	{
		$requete = $this->dao->prepare('SELECT login FROM users WHERE login = "' . $login .'"');
	    $requete->execute();
		
		return $exists = ($requete->fetch()) ? true : false;
	}

	public function checkConnexion($login, $password)
	{
		$requete = $this->dao->prepare('SELECT * FROM users WHERE login = :login AND password = :password');
		$requete->bindValue(':login', $login);
		$requete->bindValue(':password', $password);

	    $requete->execute();
	 
	    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
	 
	    if ($user = $requete->fetch())
	    {
	    	$this->dao->prepare('UPDATE users SET  lastVisitDate = NOW() WHERE login ="'.$login.'"')->execute();
	    	return true;
	    }
	 
	    return false;
	}
}  
