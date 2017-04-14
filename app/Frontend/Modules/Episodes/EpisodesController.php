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
  protected $epiManager,
            $comManager,
            $nbReport,
            $listEpisodes;

  public function loadData()
  {
    $this->epiManager = $this->managers->getManagerOf('Episodes');
    $this->comManager = $this->managers->getManagerOf('Comments');
    $this->nbReport = $this->comManager->countReport();
    $this->listEpisodes = $this->epiManager->getList();

    $this->page->addVar('listeEpisodesMenu', $this->listEpisodes);
    $this->page->addVar('nbReport', $this->nbReport);
  }

  public function executeIndex(HTTPRequest $request)
  {
    $this->loadData();
    $nombreEpisodes = $this->app->config()->get('nombre_episodes');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');
 
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreEpisodes.' derniers épisodes');

    // Pagination automatique :
    $page = $request->getData('page');
    $nbrPages = ceil($this->epiManager->count() / $nombreEpisodes);
    if (is_null($page)) $page = 1;
    $listStart = ($page - 1) * $nombreEpisodes;
 
    $listeEpisodes = $this->epiManager->getList($listStart, $nombreEpisodes);
 
    // "Lire la suite[...]"
    foreach ($listeEpisodes as $episode)
    {
      if (strlen($episode->getContent()) > $nombreCaracteres)
      {
        $debut = substr($episode->getContent(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
 
        $episode->setContent($debut);
      }
    }

    // On ajoute les informations relatives au flux RSS
    $rss = '<link rel="alternate" type="application/rss+xml" href="http://bspa.dev/flux.xml" />';
    // On ajoute les variables à la vue.
    $this->page->addVar('rss', $rss);
    $this->page->addVar('listeEpisodes', $listeEpisodes);
    $this->page->addVar('nbrPages', $nbrPages);
    $this->page->addVar('page', $page);
  }
 
  public function executeShow(HTTPRequest $request)
  {
    $this->loadData();
    
    $episodes = $this->epiManager->getUnique($request->getData('id'));
 
    if (empty($episodes))
    {
      $this->app->httpResponse()->redirect404();
    }

    $comments = $this->comManager->getListOf($episodes->getId());
 
    $this->page->addVar('title', $episodes->getTitle());
    $this->page->addVar('episodes', $episodes);
    $this->page->addVar('nbrComments', $this->epiManager->countComments($episodes->getId()));
    $this->page->addVar('comments', $comments);
  }
 
  public function executeInsertComment(HTTPRequest $request)
  {
    $this->loadData();
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
 
    $formHandler = new FormHandler($form, $this->comManager, $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
 
      $this->app->httpResponse()->redirect('episode-'.$request->getData('episodes').'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }

  public function executeResponseComment(HTTPRequest $request)
  {
    $this->loadData();
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
    $episodeId = $this->comManager->get($parentId)->getEpisodeId();
    $comment->setEpisodeId($episodeId);

    $level = ($this->comManager->get($parentId)->getLevel()) + 1;
    $comment->setLevel($level);
 
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $this->comManager, $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
 
      $this->app->httpResponse()->redirect('episode-'.$episodeId.'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }

  public function executeReportComment(HTTPRequest $request)
  {
    $this->loadData();
    $commentId = $request->getData('comment');

    $comment = $this->comManager->get($commentId);
    $parentComment = $this->comManager->get($comment->getParentId());
    $episode = $this->epiManager->getUnique($comment->getEpisodeId());

    $comment->setReport(($comment->getReport()) + 1);
    $this->comManager->save($comment);

    $mail = new SERMailer('ebizetsteve@gmail.com', 'Signalement d\'un commentaire', 'admin_notif_comment');
    $mail->addVar('comment', $comment);
    $mail->addVar('parentComment', $parentComment);
    $mail->addVar('episode', $episode);
    $mail->generateContent();
    $mail->send();
    
    $this->app->user()->setFlash('Commentaire signalé.');
    $this->app->httpResponse()->redirect('/episode-'.$episode->getId().'.html');
  }

  public function executeRss(HTTPRequest $request)
  {
    $listeEpisodes = $this->managers->getManagerOf('Episodes')->getList();

    $rss = new RSSParser($listeEpisodes);

    $this->app->httpResponse()->redirect($rss->getRss());
  }
}
