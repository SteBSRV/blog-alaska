<?php
namespace App\Backend\Modules\Commentaires;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
use \Entity\Episodes;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\EpisodesFormBuilder;
use \SER\BSPA\Form\FormHandler;
 
class CommentairesController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des commentaires');
 
    $episodesManager = $this->managers->getManagerOf('Episodes');
    $commentairesManager = $this->managers->getManagerOf('Comments');

    $this->page->addVar('listeEpisodesMenu', $episodesManager->getList());
  }
}