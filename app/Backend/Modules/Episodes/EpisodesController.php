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
  public function executeDelete(HTTPRequest $request)
  {
    $episodeId = $request->getData('id');
 
    $this->managers->getManagerOf('Comments')->deleteFromEpisode($episodeId);
    $this->managers->getManagerOf('Episodes')->delete($episodeId);
 
    $this->app->user()->setFlash('L\'épisode a bien été supprimée !');
 
    $this->app->httpResponse()->redirect('.');
  }
 
  
 
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des épisodes');
 
    $manager = $this->managers->getManagerOf('Episodes');
 
    $this->page->addVar('listeEpisodes', $manager->getListAdmin());
    $this->page->addVar('listeEpisodesMenu', $manager->getList());
    $this->page->addVar('nombreEpisodes', $manager->countAdmin());
  }
 
  public function executeInsert(HTTPRequest $request)
  {
    $this->processForm($request);
 
    $this->page->addVar('title', 'Ajout d\'un épisode');
  }
 
  public function executeUpdate(HTTPRequest $request)
  {
    $this->processForm($request);
 
    $this->page->addVar('title', 'Modification d\'un épisode');
  }
 
  public function processForm(HTTPRequest $request)
  {
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
        $episode = $this->managers->getManagerOf('Episodes')->getUnique($request->getData('id'));
      }
      else
      {
        $episode = new Episodes;
      }
    }
 
    $formBuilder = new EpisodesFormBuilder($episode);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Episodes'), $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash($episode->isNew() ? 'L\'épisode a bien été ajouté !' : 'L\'épisode a bien été modifié !');
 
      $this->app->httpResponse()->redirect('/admin/');
    }
 
    $this->page->addVar('form', $form->createView());
  }
}