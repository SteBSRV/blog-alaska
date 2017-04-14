<?php
namespace FormBuilder;
 
use \SER\BSPA\Form\FormBuilder;
use \SER\BSPA\Form\StringField;
use \SER\BSPA\Form\TextField;
use \SER\BSPA\Form\EmailValidator;
use \SER\BSPA\Form\MaxLengthValidator;
use \SER\BSPA\Form\NotNullValidator;
 
class ContactFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'label' => 'Auteur',
        'name' => 'author',
        'value' => $_SESSION['pseudo'],
        'maxLength' => 40,
        'validators' => [
          new MaxLengthValidator('Le nom spécifié est trop long (40 caractères maximum)', 40),
          new NotNullValidator('Merci de spécifier votre nom'),
        ],
       ]))
       ->add(new StringField([
        'label' => 'Adresse email',
        'name' => 'mail',
        'validators' => [
          new EmailValidator('L\'adresse mail saisie n\'est pas valide, merci de respecter le format "adresse@mail.extension"'),
          new NotNullValidator('Merci de spécifier votre adresse mail'),
        ],
       ]))
       ->add(new StringField([
        'label' => 'Sujet',
        'name' => 'title',
        'validators' => [
          new MaxLengthValidator('Le sujet spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier un sujet'),
        ],
       ]))
       ->add(new TextField([
        'label' => 'Message',
        'name' => 'message',
        'rows' => 8,
        'cols' => 60,
        'validators' => [
          new NotNullValidator('Merci de rédiger votre message'),
        ],
       ]));
  }
}
