<?php
namespace Entity;
 
use \SER\BSPA\Entity;
 
class Comment extends Entity
{
  protected $author,
            $message,
            $date,
            $state,
            $parentId = NULL,
            $level = 1,
            $episodeId,
            $report = 0;
 
  const INVALID_AUTHOR = 1;
  const INVALID_MESSAGE = 2;
  const INVALID_LEVEL = 3;

  // METHODS //
 
  public function isValid()
  {
    return !(empty($this->author) || empty($this->message));
  }

  // SETTERS //
 
  public function setEpisodeId($episode)
  {
    $this->episodeId = $episode;
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
      $this->errors[] = self::INVALID_MESSAGE;
    }
 
    $this->message = $message;
  }
 
  public function setDate(\DateTime $date)
  {
    $this->date = $date;
  }

  public function setState($state)
  {
    $this->state = $state;
  }

  public function setParentId($parent)
  {
    $this->parentId = $parent;
  }

  public function setLevel($level)
  {
    if ($level > 3)
    {
      throw new \RuntimeException('Vous ne pouvez pas répondre sur plus de 3 niveaux', self::INVALID_LEVEL);
    } else {
      $this->level = $level;
    }
  }

  public function setReport($report)
  {
    $this->report = $report;
  }
 
  // GETTERS //

  public function getEpisodeId()
  {
    return $this->episodeId;
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

  public function getState()
  {
    return $this->state;
  }

  public function getParentId()
  {
    return $this->parentId;
  }

  public function getLevel()
  {
    return $this->level;
  }

  public function getReport()
  {
    if ($this->report == 0) {
      return false;
    }
    return $this->report;
  }
}
