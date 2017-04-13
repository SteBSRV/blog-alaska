<?php
namespace App\Backend\Modules\Connexion;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
 
class ConnexionController extends BackController
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

  public function executeLogin(HTTPRequest $request)
  {
    $this->loadData();
    $this->page->addVar('title', 'Connexion');

    $manager = $this->managers->getManagerOf('Users');
 
    if ($request->postExists('login'))
    {
      $login = $request->postData('login');
      $password = $request->postData('password');
 
      if ($manager->checkConnexion($login, sha1($password)))
      {
        $this->app->user()->setAuthenticated();
        $this->app->user()->setAttribute('pseudo', $login);
        $this->app->user()->setFlash('Connexion réussi, bonne visite '.$login.'.');
        $this->app->httpResponse()->setCookie('login', $login, time()+60*60*24*10, '/');
        $this->app->httpResponse()->setCookie('password', sha1($password), time()+60*60*24*10, '/');
        $this->app->httpResponse()->redirect('/admin/');
      }
      else
      {
        $this->app->user()->setFlash('Le pseudo ou le mot de passe est incorrect.');
      }
    }
  }

  public function executeLogout(HTTPRequest $request)
  {
    $this->loadData();
    $this->page->addVar('title', 'Déconnexion');
 
    if ($this->app->user()->isAuthenticated() === true)
    {
        $this->app->user()->setFlash('Vous êtes bien déconnecté, à bientot.');
        $this->app->user()->setAuthenticated(false);
        $this->app->httpResponse()->redirect('/');
    }
    else
    {
      $this->app->user()->setFlash('Déconnexion impossible, vous n\'êtes pas connecté.');
    }
  }
}
