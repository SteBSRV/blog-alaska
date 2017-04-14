<?php
namespace SER\BSPA;
 
class Config extends ApplicationComponent
{
  protected $vars = [];
 
  public function get($var)
  {
    if (!$this->vars)
    {
      $xml = new \DOMDocument;
      $xml->load(__DIR__.'/../../../App/'.$this->app->name().'/Config/app.xml');
 
      $elements = $xml->getElementsByTagName('define');
 
      foreach ($elements as $element)
      {
        $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
      }
    }
 
    if (isset($this->vars[$var]))
    {
      return $this->vars[$var];
    }
 
    return null;
  }

  public function modify($var, $value)
  {
    $xml = new \DOMDocument;
    $xml->load(__DIR__.'/../../../App/Frontend/Config/app.xml');
    //if (in_array($var, $this->vars))
    //{
      $elements = $xml->getElementsByTagName('define');

      foreach ($elements as $element)
      {
        if ($element->getAttribute('var') == $var)
        {
          $element->setAttribute('var', $value);
          var_dump($element->getAttribute($var));
        }
      }
      //TEST//
      ////////
      var_dump($elements);
    //}
  }
}
