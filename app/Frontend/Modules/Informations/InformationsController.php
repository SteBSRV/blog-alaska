<?php
namespace App\Frontend\Modules\Informations;
 
use \SER\BSPA\BackController;
use \SER\BSPA\HTTPRequest;
use \Entity\Contact;
use \SERMailer\SERMailer;
use \FormBuilder\ContactFormBuilder;
 
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
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $contact = new Contact([
        'author' => $request->postData('author'),
        'mail' => $request->postData('mail'),
        'title' => $request->postData('title'),
        'message' => $request->postData('message'),
        'date' => new \DateTime('now')
      ]);
    }
    else
    {
      $contact = new Contact;
    }
 
    $formBuilder = new ContactFormBuilder($contact);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    if ($request->method() == 'POST' && $form->isValid())
    {
      // Traitement mail
      $mail = new SERMailer($contact->getMail(), $contact->getTitle(), 'contact');
      $mail->addVar('contact', $contact);
      $mail->generateContent();
      $mail->send();

      $this->app->user()->setFlash('Votre message a bien été envoyé, merci !');
 
      $this->app->httpResponse()->redirect('/');
    }
 
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Contact');
  }

  public function executeAbout(HTTPRequest $request)
  {
    $this->loadData();
  
    $this->page->addVar('title', 'A propos');
  }
}
