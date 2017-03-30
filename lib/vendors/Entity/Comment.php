<?php
namespace Entity;
 
use \SER\BSPA\Entity;
 
class Comment extends Entity
{
  protected $episode,
            $author,
            $message,
            $date;
 
  const INVALID_AUTHOR = 1;
  const INVALID_CONTENT = 2;
 
  public function isValid()
  {
    return !(empty($this->author) || empty($this->message));
  }
 
  public function setEpisode($episode)
  {
    $this->episode = (int) $episode;
  }
 
  public function setAuthor($author)
  {
    if (!is_string($author) || empty($author))
    {
      $this->errors[] = self::INVALID_AUTHOR;
    }
 
    $this->author = $author;
  }
 
  public function setMessage($message)
  {
    if (!is_string($message) || empty($message))
    {
      $this->errors[] = self::INVALID_CONTENT;
    }
 
    $this->message = $message;
  }
 
  public function setDate(\DateTime $date)
  {
    $this->date = $date;
  }
 
  public function getEpisode()
  {
    return $this->episode;
  }
 
  public function getAuthor()
  {
    return $this->author;
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