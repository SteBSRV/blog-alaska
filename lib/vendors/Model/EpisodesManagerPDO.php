<?php
/* lib/vendors/Model/EpisodesManagerPDO.php */
namespace Model;
 
use \Entity\Episodes;
 
class EpisodesManagerPDO extends EpisodesManager
{
  protected function add(Episodes $episodes)
  {
    $requete = $this->dao->prepare('INSERT INTO episodes SET author = :author, title = :title, content = :content, addDate = NOW(), modDate = NOW(), state = 2');
 
    $requete->bindValue(':title', $episodes->getTitle());
    $requete->bindValue(':author', $episodes->getAuthor());
    $requete->bindValue(':content', $episodes->getContent());
 
    $requete->execute();
  }
 
  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM episodes WHERE state = 2')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM episodes WHERE id = '.(int) $id);
  }
 
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, title, author, content, addDate, modDate, state FROM episodes WHERE state = 2 ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Episodes');
 
    $listeEpisodes = $requete->fetchAll();
 
    foreach ($listeEpisodes as $episodes)
    {
      $episodes->setAddDate(new \DateTime($episodes->getAddDate()));
      $episodes->setModDate(new \DateTime($episodes->getModDate()));
    }
 
    $requete->closeCursor();
 
    return $listeEpisodes;
  }
 
  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, title, author, content, addDate, modDate, state FROM episodes WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();
 
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Episodes');
 
    if ($episodes = $requete->fetch())
    {
      $episodes->setAddDate(new \DateTime($episodes->getAddDate()));
      $episodes->setModDate(new \DateTime($episodes->getModDate()));
 
      return $episodes;
    }
 
    return null;
  }
 
  protected function modify(Episodes $episodes)
  {
    $requete = $this->dao->prepare('UPDATE episodes SET author = :author, title = :title, content = :content, modDate = NOW() WHERE id = :id');
 
    $requete->bindValue(':title', $episodes->getTitle());
    $requete->bindValue(':author', $episodes->getAuthor());
    $requete->bindValue(':content', $episodes->getContent());
    $requete->bindValue(':id', $episodes->getId(), \PDO::PARAM_INT);
 
    $requete->execute();
  }
}