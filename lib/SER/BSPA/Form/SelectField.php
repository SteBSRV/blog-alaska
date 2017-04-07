<?php
namespace SER\BSPA\Form;
 
class SelectField extends Field
{
  public function buildWidget()
  {
    $widget = '';
 
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
 
    $widget .= '<label>'.$this->label.'</label><select name="'.$this->name.'" class="form-control">';
 
    if (!empty($this->selects))
    {
      foreach ($this->selects as $state => $option) {
        $widget .= '<option value="'.htmlspecialchars($state).'"';
        if ($this->value == $state)
        {
          $widget .= ' selected>'.$option.'</option>';
        } else {
          $widget .= '>'.$option.'</option>';
        }
      }
    }
 
    return $widget .= '</select>';
  }
}
