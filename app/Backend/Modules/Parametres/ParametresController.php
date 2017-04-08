<?php
namespace App\Backend\Modules\Parametres;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class ParametresController extends BackController
{
  public function executeConfig(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Configuration');
 
    $episodesManager = $this->managers->getManagerOf('Episodes');
    $commentairesManager = $this->managers->getManagerOf('Comments');

    $this->page->addVar('listeEpisodesMenu', $episodesManager->getList());
  }
}
