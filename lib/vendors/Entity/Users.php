<?php
/* lib/vendors/Entity/Users.php */
namespace Entity;
 
use \SER\BSPA\Entity;
 
class Users extends Entity
{
  protected $login,
            $password,
            $email,
            $lastVisitDate,
            $inscriptionDate,
            $level,
            $state;
 
  const INVALID_LOGIN = 1;
  const INVALID_PASSWORD = 2;
  const INVALID_EMAIL = 3;

  // SETTERS //
 
  public function setLogin($login)
  {
    if (!is_string($login) || empty($login))
    {
      $this->errors[] = self::INVALID_LOGIN;
    }
 
    $this->login = $login;
  }
 
  public function setPassword($password)
  {
    if (!is_string($password) || empty($password))
    {
      $this->errors[] = self::INVALID_PASSWORD;
    }
 
    $this->password = sha1('ser', $password);
  }
 
  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      $this->errors[] = self::INVALID_EMAIL;
    }
 
    $this->email = $email;
  }
 
  public function setLastVisitDate(\DateTime $visitDate)
  {
    $this->lastVisitDate = $visitDate;
  }
 
  public function setInscriptionDate(\DateTime $inscriptionDate)
  {
    $this->inscriptionDate = $inscriptionDate;
  }

  public function setLevel($level)
  {
    $this->level = (int)$level;
  }

  public function setState($state)
  {
    $this->state = (int)$state;
  }
 
  // GETTERS //
 
  public function getLogin()
  {
    return $this->login;
  }
 
  public function getPassword()
  {
    return $this->password;
  }
 
  public function getEmail()
  {
    return $this->email;
  }
 
  public function getLastVisitDate()
  {
    return $this->lastVisitDate;
  }
 
  public function getInscriptionDate()
  {
    return $this->inscriptionDate;
  }

  public function getLevel()
  {
    return $this->level;
  }

  public function getState()
  {
    return $this->state;
  }
}
