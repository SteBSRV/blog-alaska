<?php
/* App/Frontend/Modules/Episodes/EpisodesController.php */
namespace App\Frontend\Modules\Episodes;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
use \Entity\Comment;
 
class EpisodesController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $nombreEpisodes = $this->app->config()->get('nombre_episodes');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
 
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreEpisodes.' derniers épisodes');
 
    // On récupère le manager des news.
    $manager = $this->managers->getManagerOf('Episodes');
 
    $listeEpisodes = $manager->getList(0, $nombreEpisodes);
 
    foreach ($listeEpisodes as $episodes)
    {
      if (strlen($episodes->getContent()) > $nombreCaracteres)
      {
        $debut = substr($episodes->getContent(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
 
        $episodes->setContent($debut);
      }
    }
    // On ajoute la variable $listeEpisodes à la vue.
    $this->page->addVar('listeEpisodes', $listeEpisodes);
  }
 
  public function executeShow(HTTPRequest $request)
  {
    $episodes = $this->managers->getManagerOf('Episodes')->getUnique($request->getData('id'));
 
    if (empty($episodes))
    {
      $this->app->httpResponse()->redirect404();
    }
 
    $this->page->addVar('title', $episodes->getTitle());
    $this->page->addVar('episodes', $episodes);
    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($episodes->id()));
  }
 
  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'episodes' => $request->getData('episodes'),
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
 
      $this->app->httpResponse()->redirect('episodes-'.$request->getData('episodes').'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }
}
