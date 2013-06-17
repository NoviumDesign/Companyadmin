<?php

class Emilk_Form_Element_Select extends Emilk_Form_Element_Element
{
  public $options = array();

  public function addOption($option)
  {
    if (is_array($option)) {
      $option = array_values($option);

      $this->options[] = array('value' => $option[0], 'text' => $option[1]);
    } else {
      $this->options[] = array('value' => $option, 'text' => $option);
    }

    return $this;
  }

  public function addOptions($array)
  {
    foreach ($array as $option) {
      $option = array_values($option);

      if (is_array($option)) {
        $this->options[] = array('value' => $option[0], 'text' => $option[1]);
      } else {
        $this->options[] = array('value' => $option, 'text' => $option);
      }
    }

    return $this;
  }

  public function render()
  {

    $html = '<select name="' . $this->name . '" ';
    foreach($this->attributes as $key => $value) {
      $html .= $key . '="' . $value . '" >';
    }
    
    foreach ($this->options as $option) {
      $html .= '<option value="' . $option['value'] . '" ' . ($option['value'] == $this->value[0] ? 'selected' : '') . ' >' .
      $option['text'] .
      '</option>';
    }
    
    $html .= '</select>';

    echo $html;
  }
}