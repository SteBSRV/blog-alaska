<?php
namespace App\Frontend\Modules\Inscription;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class InscriptionController extends BackController
{
  public function executeSignin(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Inscription');

    $manager = $this->managers->getManagerOf('Users');
 
    if ($request->postExists('login'))
    {
      if (!$manager->loginExists($request->postData('login')))
      {
        $login = $request->postData('login');
        $email = $request->postData('email');

        if ($request->postData('password') == $request->postData('password-check'))
        {
          $password = $request->postData('password');
          if (isset($password))
          {
            $this->app->user()->setAuthenticated(true);
            $this->app->user()->setAttribute('pseudo', $login);
            $this->app->user()->setFlash('Inscription réussi, bonne lecture ' . $login . '.');
            $this->app->httpResponse()->redirect('/');
          } else {
            $this->app->user()->setFlash('Le formulaire n\'est pas complet.');
          }
        } else {
          $this->app->user()->setFlash('Le mot de passe ne correspond pas.');
        }
      } else {
        $this->app->user()->setFlash('Ce pseudo existe déja.');  
      }
    }
  }
}
