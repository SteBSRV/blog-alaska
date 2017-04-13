<?php
namespace App\Backend\Modules\Episodes;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
use \Entity\Episodes;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\EpisodesFormBuilder;
use \SER\BSPA\Form\FormHandler;
 
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

  public function executeDelete(HTTPRequest $request)
  {
    $this->loadData();
    $episodeId = $request->getData('id');
 
    $this->comManager->deleteFromEpisode($episodeId);
    $this->epiManager->delete($episodeId);
 
    $this->app->user()->setFlash('L\'épisode a bien été supprimée !');
 
    $this->app->httpResponse()->redirect('.');
  }
 
  
 
  public function executeIndex(HTTPRequest $request)
  {
    $this->loadData();
    $this->page->addVar('title', 'Gestion des épisodes');
 
    $this->page->addVar('listeEpisodes', $this->epiManager->getListAdmin());
    $this->page->addVar('nombreEpisodes', $this->epiManager->countAdmin());
  }
 
  public function executeInsert(HTTPRequest $request)
  {
    $this->loadData();
    $this->processForm($request);
 
    $this->page->addVar('title', 'Ajout d\'un épisode');
  }
 
  public function executeUpdate(HTTPRequest $request)
  {
    $this->loadData();
    $this->processForm($request);
 
    $this->page->addVar('title', 'Modification d\'un épisode');
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