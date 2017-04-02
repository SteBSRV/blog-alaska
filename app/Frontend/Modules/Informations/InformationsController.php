<?php
namespace App\Frontend\Modules\Informations;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class InformationsController extends BackController
{
  public function executeContact(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Contact');
  }
}
