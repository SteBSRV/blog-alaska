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
    $this->page->addVar('title', 'Gestion des commentaires');

    $this->page->addVar('listeComments', $this->comManager->getReported());
  }

  public function executeDelete(HTTPRequest $request)
  {
    $this->loadData();
    $this->comManager->delete($request->getData('id'));
 
    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');
 
    $this->app->httpResponse()->redirect('.');
  }

  public function executeUpdate(HTTPRequest $request)
  {
    $this->loadData();
    $this->page->addVar('title', 'Modification d\'un commentaire');
 
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'id' => $request->getData('id'),
        'author' => $request->postData('author'),
        'message' => $request->postData('message')
      ]);
    }
    else
    {
      $comment = $this->comManager->get($request->getData('id'));
    }
 
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $this->comManager, $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été modifié');
 
      $this->app->httpResponse()->redirect('/admin/');
    }
 
    $this->page->addVar('form', $form->createView());
  }
 
  public function processForm(HTTPRequest $request)
  {
    $this->loadData();
    if ($request->method() == 'POST')
    {
      $episode = new Episodes([
        'author' => $request->postData('author'),
        'title' => $request->postData('title'),
        'content' => $request->postData('content'),
        'state' => $request->postData('state')
      ]);
 
      if ($request->getExists('id'))
      {
        $episode->setId($request->getData('id'));
      }
    }
    else
    {
      // L'identifiant de l'épisode est transmis si on veut la modifier
      if ($request->getExists('id'))
      {
        $episode = $this->epiManager->getUnique($request->getData('id'));
      }
      else
      {
        $episode = new Episodes;
      }
    }
 
    $formBuilder = new EpisodesFormBuilder($episode);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $this->epiManager, $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash($episode->isNew() ? 'L\'épisode a bien été ajouté !' : 'L\'épisode a bien été modifié !');
 
      $this->app->httpResponse()->redirect('/admin/');
    }
 
    $this->page->addVar('form', $form->createView());
  }
}