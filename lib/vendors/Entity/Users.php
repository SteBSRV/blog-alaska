<?php
/* lib/vendors/Entity/Users.php */
namespace Entity;
 
use \SER\BSPA\Entity;
use \Model\UsersManagerPDO;

session_start();
 
class Users extends Entity
{
  protected $login,
            $password,
            $email,
            $lastVisitDate,
            $inscriptionDate,
            $state;
 
  const INVALID_LOGIN = 1;
  const INVALID_PASSWORD = 2;
  const INVALID_EMAIL = 3;

  // METHODS //

  public function getAttribute($attr)
  {
    return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
  }
 
  public function getFlash()
  {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
 
    return $flash;
  }
 
  public function hasFlash()
  {
    return isset($_SESSION['flash']);
  }
 
  public function isAuthenticated()
  {
    return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
  }
 
  public function setAttribute($attr, $value)
  {
    $_SESSION[$attr] = $value;
  }
 
  public function setAuthenticated($authenticated = true)
  {
    if (!is_bool($authenticated))
    {
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
    }
 
    $_SESSION['auth'] = $authenticated;

    /*if (!$authenticated) {
      $_SESSION = [];
      session_destroy();
      // Cookie
    }*/
  }
 
  public function setFlash($value)
  {
    $_SESSION['flash'] = $value;
  }

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
 
    $this->password = sha1($password);
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

  public function getState()
  {
    return $this->state;
  }
}
