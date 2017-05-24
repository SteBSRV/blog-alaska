<?php
namespace SER\BSPA;
 
class Parameters
{
  protected $param = [];
 
  public function getDbParam()
  {
    if (empty($this->param))
    {
      $xml = new \DOMDocument;
      $xml->load(__DIR__.'/Parameters/parameters.xml');
 
      $elements = $xml->getElementsByTagName('parameter');
 
      foreach ($elements as $element)
      {
        $this->param[$element->getAttribute('var')] = $element->getAttribute('value');
      }

      return $this->param;
    }
 
    return null;
  }
}