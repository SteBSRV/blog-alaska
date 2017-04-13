<?php
namespace App\Frontend\Modules\Informations;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class InformationsController extends BackController
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

  public function executeContact(HTTPRequest $request)
  {
    $this->loadData();

    $this->page->addVar('title', 'Contact');
  }

  public function executeAbout(HTTPRequest $request)
  {
    $this->loadData();
  
    $this->page->addVar('title', 'A propos');
  }
}
