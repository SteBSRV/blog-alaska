<?php
/* lib/vendors/Model/EpisodesManager.php */
namespace Model;
 
use \SER\BSPA\Manager;
use \Entity\Episodes;
 
abstract class EpisodesManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un épisode.
   * @param $episodes Episodes L'episode à ajouter
   * @return void
   */
  abstract protected function add(Episodes $episodes);
 
  /**
   * Méthode permettant d'enregistrer un episode.
   * @param $episode Episode l'episode à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
  public function save(Episodes $episodes)
  {
    if ($episodes->isValid())
    {
      $episodes->isNew() ? $this->add($episodes) : $this->modify($episodes);
    }
    else
    {
      throw new \RuntimeException('L\'episode doit être validé pour être enregistrée');
    }
  }
 
  /**
   * Méthode renvoyant le nombre d'épisodes public total.
   * @return int
   */
  abstract public function count();

  /**
   * Méthode renvoyant le nombre d'épisodes total, incluant les épisodes non publics.
   * @return int
   */
  abstract public function countAdmin();

  /**
   * Méthode permettant de connaitre le nombre de commentaires pour un épisode donné.
   * @param $id int L'identifiant de l'episode concerné
   * @return int
   */
  abstract public function countComments($id);
 
  /**
   * Méthode permettant de supprimer un episode.
   * @param $id int L'identifiant de l'episode à supprimer
   * @return void
   */
  abstract public function delete($id);
 
  /**
   * Méthode retournant une liste d'épisodes demandés.
   * @param $debut int Le premièr episode à sélectionner
   * @param $limite int Le nombre d'épisodes à sélectionner
   * @return array La liste des episodes. Chaque entrée est une instance de Episodes.
   */
  abstract public function getList($debut = -1, $limite = -1);

  /**
   * Méthode retournant une liste d'épisodes demandés, incluant les épisodes non publics.
   * @param $debut int Le premièr episode à sélectionner
   * @param $limite int Le nombre d'épisodes à sélectionner
   * @return array La liste des episodes. Chaque entrée est une instance de Episodes.
   */
  abstract public function getListAdmin($debut = -1, $limite = -1);
 
  /**
   * Méthode retournant un episode précis.
   * @param $id int L'identifiant de l'episode à récupérer
   * @return Episodes L'episode demandé
   */
  abstract public function getUnique($id);
 
  /**
   * Méthode permettant de modifier un episode.
   * @param $episodes l'episodes à modifier
   * @return void
   */
  abstract protected function modify(Episodes $episodes);
}
