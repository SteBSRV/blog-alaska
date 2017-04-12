<?php
/* App/Frontend/Modules/Episodes/EpisodesController.php */
namespace App\Frontend\Modules\Episodes;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
use \Entity\Comment;
use \SERMailer\SERMailer;
use \FormBuilder\CommentFormBuilder;
use \SER\BSPA\Form\FormHandler;
use \RSSParser\RSSParser;
 
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

    // On ajoute les informations relatives au flux RSS
    $rss = '<link rel="alternate" type="application/rss+xml" href="http://bspa.dev/flux.xml" />';
    // On ajoute les variables à la vue.
    $this->page->addVar('rss', $rss);
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
    $commentId = $request->getData('comment');

    $episodesManager = $this->managers->getManagerOf('Episodes');
    $commentsManager = $this->managers->getManagerOf('Comments');
    $listeEpisodesMenu = $episodesManager->getList();

    $comment = $commentsManager->get($commentId);
    $parentComment = $commentsManager->get($comment->getParentId());
    $episode = $episodesManager->getUnique($comment->getEpisodeId());

    $comment->setReport(($comment->getReport()) + 1);
    $commentsManager->save($comment);

    /*
    $message_mail = '<h1>Signalement du commentaire de <strong>'.$comment->getAuthor().'</strong></h1>';
    if ($parentComment != false) {
    $message_mail .= '<h2><em>En réponse au commentaire de '.$parentComment->getAuthor().'</em></h2>';
    }
    $message_mail .= '';
    $message_mail .= '<p>Contenu du commentaire :';
    $message_mail .= '';
    $message_mail .= '"<em>'.$comment->getMessage().'</em>"</p>';
    $message_mail .= '<span>Le '.$comment->getDate().'.</span>';
    $message_mail .= '';
    $message_mail .= '<p>Episode concerné : '.$episode->getTitle().'.</p>';
    $message_mail .= '';
    $message_mail .= '<p>Censurer le commentaire : <a href="bspa.dev/admin/>Censurer</a></p>';

    $mail = new SERMailer('ebizetsteve@gmail.com', 'Signalement d\'un commentaire', $message_mail);
    $mail->send();*/
    
    $this->page->addVar('comment', $commentId);
    $this->page->addVar('title', 'Signalement d\'un commentaire');
    $this->page->addVar('listeEpisodesMenu', $listeEpisodesMenu);
  }

  public function executeRss(HTTPRequest $request)
  {
    $listeEpisodes = $this->managers->getManagerOf('Episodes')->getList();

    $this->page->addVar('listeEpisodesMenu', $listeEpisodes);

    $rss = new RSSParser($listeEpisodes);

    $this->app->httpResponse()->redirect($rss->getRss());
  }
}
