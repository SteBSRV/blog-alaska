<?php
namespace App\Backend\Modules\Parametres;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class ParametresController extends BackController
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

  public function executeConfig(HTTPRequest $request)
  {
  	$this->loadData();
    $this->page->addVar('title', 'Configuration');
  }
}
