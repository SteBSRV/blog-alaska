<?php
namespace Model;
 
use \Entity\Comment;
 
class CommentsManagerPDO extends CommentsManager
{
  protected function add(Comment $comment)
  {
    $q = $this->dao->prepare('INSERT INTO comments SET author = :author, message = :message, date = NOW(), state = 1, parentId = :parent, level = :level, episodeId = :episode ');
 
    $q->bindValue(':episode', $comment->getEpisodeId(), \PDO::PARAM_INT);
    $q->bindValue(':parent', $comment->getParentId(), \PDO::PARAM_INT);
    $q->bindValue(':level', $comment->getLevel(), \PDO::PARAM_INT);
    $q->bindValue(':author', $comment->getAuthor());
    $q->bindValue(':message', $comment->getMessage());
 
    $q->execute();
 
    $comment->setId($this->dao->lastInsertId());
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
  }
 
  public function deleteFromEpisode($episode)
  {
    $this->dao->exec('DELETE FROM comments WHERE episodeId = '.(int) $episode);
  }
 
  public function getListOf($episode)
  {
    if (!ctype_digit($episode))
    {
      throw new \InvalidArgumentException('L\'identifiant de l\'épisode passé doit être un nombre entier valide');
    }
    //SELECT * FROM comments WHERE episodeId = :episode GROUP BY CASE WHEN parentId IS NULL THEN id ELSE parentId END, parentId ASC
    $q = $this->dao->prepare('SELECT * FROM comments WHERE episodeId = :episode ORDER BY COALESCE(parentId, id), parentId IS NOT NULL, id');

    
    $q->bindValue(':episode', $episode, \PDO::PARAM_INT);
    $q->execute();
 
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
 
    $comments = $q->fetchAll();

    $comments = $this->order($comments);
 
    return $comments;
  }
 
  protected function modify(Comment $comment)
  {
    $q = $this->dao->prepare('UPDATE comments SET author = :author, message = :message WHERE id = :id');
 
    $q->bindValue(':author', $comment->getAuthor());
    $q->bindValue(':message', $comment->getMessage());
    $q->bindValue(':id', $comment->getId(), \PDO::PARAM_INT);
 
    $q->execute();
  }
 
  public function get($id)
  {
    $q = $this->dao->prepare('SELECT id, author, message, date, state, parentId, level, episodeId FROM comments WHERE id = :id');
    $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $q->execute();
 
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
 
    return $q->fetch();
  }

  public function order(array $comments)
  {
    $orderedComments = [];
  
    // A AMELIORER, uniquement pour test //
    foreach ($comments as $Pcomment)
    {
      if(is_null($Pcomment->getParentId())) {
        $Pcomment->setDate(new \DateTime($Pcomment->getDate()));
        $orderedComments[] = $Pcomment;
        foreach ($comments as $Ccomment) {
          if ($Ccomment->getParentId() == $Pcomment->getId()) {
            $Ccomment->setDate(new \DateTime($Ccomment->getDate()));
            $orderedComments[] = $Ccomment;
            foreach ($comments as $CCcomment) {
              if ($CCcomment->getParentId() == $Ccomment->getId()) {
                $CCcomment->setDate(new \DateTime($CCcomment->getDate()));
                $orderedComments[] = $CCcomment;
              }
            }
          }
        }
      }
    }

    return $orderedComments;
  }  
}
