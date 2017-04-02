<?php
namespace FormBuilder;
 
use \SER\BSPA\Form\FormBuilder;
use \SER\BSPA\Form\StringField;
use \SER\BSPA\Form\TextField;
use \SER\BSPA\Form\MaxLengthValidator;
use \SER\BSPA\Form\NotNullValidator;
 
class EpisodesFormBuilder extends FormBuilder
{
  public function build()
  {
    $this->form->add(new StringField([
        'label' => 'Auteur',
        'name' => 'author',
        'maxLength' => 20,
        'validators' => [
          new MaxLengthValidator('L\'auteur spécifié est trop long (20 caractères maximum)', 20),
          new NotNullValidator('Merci de spécifier l\'auteur de l\'épisode'),
        ],
       ]))
       ->add(new StringField([
        'label' => 'Titre',
        'name' => 'title',
        'maxLength' => 100,
        'validators' => [
          new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
          new NotNullValidator('Merci de spécifier le titre de l\'épisode'),
        ],
       ]))
       ->add(new TextField([
        'label' => 'Contenu',
        'name' => 'content',
        'rows' => 8,
        'cols' => 60,
        'validators' => [
          new NotNullValidator('Merci de spécifier le contenu de l\'épisode'),
        ],
       ]));
  }
}