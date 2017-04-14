<?php
namespace Entity;
 
use \SER\BSPA\Entity;
 
class Contact extends Entity
{
  protected $author,
            $mail,
            $title,
            $message,
            $date;
 
  const INVALID_AUTHOR = 1;
  const INVALID_MAIL = 2;
  const INVALID_TITLE = 3;
  const INVALID_MESSAGE = 4;

  // METHODS //
 
  public function isValid()
  {
    return !(empty($this->author) || empty($this->message));
  }

  // SETTERS //
 
  public function setAuthor($author)
  {
    if (!is_string($author) || empty($author))
    {
      $this->errors[] = self::INVALID_AUTHOR;
    }
 
    $this->author = $author;
  }

  public function setMail($mail)
  {
    if (!is_string($mail) || empty($mail))
    {
      $this->errors[] = self::INVALID_MAIL;
    }
 
    $this->mail = $mail;
  }

  public function setTitle($title)
  {
    if (!is_string($title) || empty($title))
    {
      $this->errors[] = self::INVALID_TITLE;
    }
 
    $this->title = $title;
  }
 
  public function setMessage($message)
  {
    if (!is_string($message) || empty($message))
    {
      $this->errors[] = self::INVALID_MESSAGE;
    }
 
    $this->message = $message;
  }
 
  public function setDate(\DateTime $date)
  {
    $this->date = $date;
  }
 
  // GETTERS //

  public function getAuthor()
  {
    return $this->author;
  }

  public function getMail()
  {
    return $this->mail;
  }

  public function getTitle()
  {
    return $this->title;
  }
 
  public function getMessage()
  {
    return $this->message;
  }
 
  public function getDate()
  {
    return $this->date;
  }
}
