<?php
namespace FormBuilder;
 
use \SER\BSPA\Form\FormBuilder;
use \SER\BSPA\Form\StringField;
use \SER\BSPA\Form\TextField;
use \SER\BSPA\Form\SelectField;
use \SER\BSPA\Form\MaxLengthValidator;
use \SER\BSPA\Form\NotNullValidator;
 
class AdminCommentFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'label' => 'Auteur',
        'name' => 'author',
        'value' => $_SESSION['pseudo'],
        'maxLength' => 50,
        'disabled' => 'disabled',
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (50 caractères maximum)', 50),
          new NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
        ],
       ]))
       ->add(new TextField([
        'label' => 'Message',
        'name' => 'message',
        'rows' => 7,
        'cols' => 50,
        'validators' => [
          new NotNullValidator('Merci de spécifier votre commentaire'),
        ],
       ]))
       ->add(new SelectField([
        'label' => 'Statut',
        'name' => 'state',
        'selects' => [0 => 'censuré', 1 => 'public'],
      ]));
  }
}
