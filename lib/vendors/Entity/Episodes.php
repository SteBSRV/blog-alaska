<?php
/* lib/vendors/Entity/Episodes.php */
namespace Entity;
 
use \SER\BSPA\Entity;
 
class Episodes extends Entity
{
  protected $author,
            $title,
            $content,
            $addDate,
            $modDate;
 
  const INVALID_AUTHOR = 1;
  const INVALID_TITLE = 2;
  const INVALID_CONTENT = 3;
 
  public function isValid()
  {
    return !(empty($this->author) || empty($this->title) || empty($this->content));
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
 
  public function setTitle($title)
  {
    if (!is_string($title) || empty($title))
    {
      $this->errors[] = self::INVALID_TITLE;
    }
 
    $this->title = $title;
  }
 
  public function setContent($content)
  {
    if (!is_string($content) || empty($content))
    {
      $this->errors[] = self::INVALID_CONTENT;
    }
 
    $this->content = $content;
  }
 
  public function setAddDate(\DateTime $addDate)
  {
    $this->addDate = $addDate;
  }
 
  public function setModDate(\DateTime $modDate)
  {
    $this->modDate = $modDate;
  }
 
  // GETTERS //
 
  public function getAuthor()
  {
    return $this->author;
  }
 
  public function getTitle()
  {
    return $this->title;
  }
 
  public function getContent()
  {
    return $this->content;
  }
 
  public function getAddDate()
  {
    return $this->addDate;
  }
 
  public function getModDate()
  {
    return $this->modDate;
  }
}