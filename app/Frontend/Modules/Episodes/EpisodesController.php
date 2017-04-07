<?php
/* App/Frontend/Modules/Episodes/EpisodesController.php */
namespace App\Frontend\Modules\Episodes;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \SER\BSPA\Form\FormHandler;
 
class EpisodesController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $nombreEpisodes = $this->app->config()->get('nombre_episodes');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
 
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreEpisodes.' derniers épisodes');
 
    // On récupère le manager des épisodes.
    $manager = $this->managers->getManagerOf('Episodes');

    // Pagination automatique :
    $page = $request->getData('page');
    $nbrPages = ceil($manager->count() / $nombreEpisodes);
    if (is_null($page)) $page = 1;
    $listStart = ($page - 1) * $nombreEpisodes;
 
    $listeEpisodes = $manager->getList($listStart, $nombreEpisodes);
 
    // "Lire la suite[...]"
    foreach ($listeEpisodes as $episodes)
    {
      if (strlen($episodes->getContent()) > $nombreCaracteres)
      {
        $debut = substr($episodes->getContent(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
 
        $episodes->setContent($debut);
      }
    }
    // On ajoute les variables à la vue.
    $this->page->addVar('listeEpisodes', $listeEpisodes);
    $this->page->addVar('nbrPages', $nbrPages);
    $this->page->addVar('page', $page);
    $this->page->addVar('listeEpisodesMenu', $manager->getList());
  }
 
  public function executeShow(HTTPRequest $request)
  {
    $manager = $this->managers->getManagerOf('Episodes');
    $episodes = $manager->getUnique($request->getData('id'));
 
    if (empty($episodes))
    {
      $this->app->httpResponse()->redirect404();
    }
 
    $this->page->addVar('title', $episodes->getTitle());
    $this->page->addVar('episodes', $episodes);
    $this->page->addVar('nbrComments', $manager->countComments($episodes->getId()));
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($episodes->getId()));
    $this->page->addVar('listeEpisodesMenu', $manager->getList());
  }
 
  public function executeInsertComment(HTTPRequest $request)
  {
    if ($this->app->user()->isAuthenticated())
    {
      // Si le formulaire a été envoyé.
      if ($request->method() == 'POST')
      {
        $comment = new Comment([
          'episode' => $request->getData('episodes'),
          'author' => $request->postData('author'),
          'message' => $request->postData('message')
        ]);
      }
      else
      {
        $comment = new Comment;
      }
   
      $formBuilder = new CommentFormBuilder($comment);
      $formBuilder->build();
   
      $form = $formBuilder->form();
   
      $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
   
      if ($formHandler->process())
      {
        $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
   
        $this->app->httpResponse()->redirect('episode-'.$request->getData('episodes').'.html');
      }
   
      $this->page->addVar('comment', $comment);
      $this->page->addVar('form', $form->createView());
      $this->page->addVar('title', 'Ajout d\'un commentaire');
    } else {
      $this->app->user()->setFlash('Vous devez vous connecter pour écrire un commentaire.');
        $this->app->httpResponse()->redirect('/episode-'.$request->getData('episodes').'.html');  
      }
  }
}
