<?php
namespace SER\BSPA\Form;
 
class EmailValidator extends Validator
{
  public function __construct($errorMessage)
  {
    parent::__construct($errorMessage);
  }
 
  public function isValid($value)
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }
}
