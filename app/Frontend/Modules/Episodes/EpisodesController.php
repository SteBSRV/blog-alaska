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
    $episodesManager = $this->managers->getManagerOf('Episodes');
    $commentsManager = $this->managers->getManagerOf('Comments');
    $episodes = $episodesManager->getUnique($request->getData('id'));
 
    if (empty($episodes))
    {
      $this->app->httpResponse()->redirect404();
    }

    $comments = $commentsManager->getListOf($episodes->getId());
    /*var_dump($comments);
    die();*/
 
    $this->page->addVar('title', $episodes->getTitle());
    $this->page->addVar('episodes', $episodes);
    $this->page->addVar('nbrComments', $episodesManager->countComments($episodes->getId()));
    $this->page->addVar('comments', $comments);
    $this->page->addVar('listeEpisodesMenu', $episodesManager->getList());
  }
 
  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'episodeId' => $request->getData('episodes'),
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

    $listeEpisodesMenu = $this->managers->getManagerOf('Episodes')->getList();
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
 
      $this->app->httpResponse()->redirect('episode-'.$request->getData('episodes').'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
    $this->page->addVar('listeEpisodesMenu', $listeEpisodesMenu);
  }

  public function executeResponseComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'parentId' => $request->getData('comment'),
        'author' => $request->postData('author'),
        'message' => $request->postData('message')
      ]);
    }
    else
    {
      $comment = new Comment(['parentId' => $request->getData('comment')]);
    }

    $parentId = $request->getData('comment');
    $manager = $this->managers->getManagerOf('Comments');
    $episode = $manager->get($parentId)->getEpisodeId();
    $comment->setEpisodeId($episode);

    $level = ($manager->get($parentId)->getLevel()) + 1;
    $comment->setLevel($level);
 
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $manager, $request);

    $listeEpisodesMenu = $this->managers->getManagerOf('Episodes')->getList();
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
 
      $this->app->httpResponse()->redirect('episode-'.$episode.'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
    $this->page->addVar('listeEpisodesMenu', $listeEpisodesMenu);
  }

  public function executeReportComment(HTTPRequest $request)
  {
    $comment = $request->getData('comment');

    $listeEpisodesMenu = $this->managers->getManagerOf('Episodes')->getList();
    
    $this->page->addVar('comment', $comment);
    $this->page->addVar('title', 'Signalement d\'un commentaire');
    $this->page->addVar('listeEpisodesMenu', $listeEpisodesMenu);
  }
}
