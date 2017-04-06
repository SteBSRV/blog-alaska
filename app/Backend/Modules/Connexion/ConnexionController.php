<?php
namespace App\Backend\Modules\Connexion;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class ConnexionController extends BackController
{
  public function executeLogin(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Connexion');

    $manager = $this->managers->getManagerOf('Users');
 
    if ($request->postExists('login'))
    {
      $login = $request->postData('login');
      $password = $request->postData('password');
 
      if ($manager->checkConnexion($login, sha1($password))/*$login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass')*/)
      {
        $this->app->user()->setAuthenticated();
        $this->app->user()->setAttribute('pseudo', $login);
        $this->app->user()->setFlash('Connexion réussi, bonne visite '.$login.'.');
        $this->app->httpResponse()->redirect('/');
      }
      else
      {
        $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
      }
    }
  }

  public function executeLogout(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Déconnexion');
 
    if ($this->app->user()->isAuthenticated() === true)
    {
        $this->app->user()->setAuthenticated(false);
        $this->app->httpResponse()->redirect('/');
    }
    else
    {
      $this->app->user()->setFlash('Déconnexion impossible, vous n\'êtes pas connecté.');
    }
  }
}
