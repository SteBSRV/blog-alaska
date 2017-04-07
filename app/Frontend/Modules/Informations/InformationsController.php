<?php
namespace App\Frontend\Modules\Informations;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class InformationsController extends BackController
{
  public function executeContact(HTTPRequest $request)
  {
  	$listeEpisodesMenu = $this->managers->getManagerOf('Episodes')->getList();

    $this->page->addVar('title', 'Contact');
    $this->page->addVar('listeEpisodesMenu', $listeEpisodesMenu);
  }
}
