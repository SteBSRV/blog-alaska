<?php
namespace SER\BSPA\Form;
 
class NotNullValidator extends Validator
{
  public function isValid($value)
  {
    return $value != '';
  }
}
