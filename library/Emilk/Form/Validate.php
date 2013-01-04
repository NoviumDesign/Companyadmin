<?php
    
class Emilk_Form_Validate {

    // list var
    public $elements = null;
    public $formName = null;
    public $valid = true;

    function __construct($elements, $formName)
    {
        $this->elements = $elements;
        $this->formName = $formName;

        // form identifier
        if($this->parseRequest())
            $this->validate();
    }

    public function parseRequest()
    {
        if(isset($_POST['formIdentifier']) && $_POST['formIdentifier'] == $this->formName) {

            foreach($this->elements as $element) {
                
                if(isset($_POST[$element->name])) {
                    if($_POST[$element->name]) {
                        if(is_array($_POST[$element->name])) {

                            foreach ($_POST[$element->name] as $key => $value) {
                                $_POST[$element->name][$key] = htmlentities(
                                    nl2br($value)
                                    , ENT_QUOTES, "UTF-8");
                            }
                            $element->value = $_POST[$element->name];

                        } else {

                            $element->value = array(htmlentities(
                                nl2br($_POST[$element->name])
                                , ENT_QUOTES, "UTF-8"));

                        }

                    } else {
                        $element->value = array('');
                    }
                }

            }

            return true;
        }
    }

    public function validate()
    {
        foreach($this->elements as $element) {

            foreach ($element->validation as $validation => $error) {
                
                foreach ($element->value as $value) {
                
                    $error = $this->$validation($value, $error);
                    if($error != false) {   // error does not exist

                        $element->error[$validation] = $error;
                        $element->attributes['class'] .= ' error';

                        $this->valid = false;
                    }
                }
            }
        }
    }

    public function integer($value, $error = 'standard integer error message')
    {
        if(preg_match("/^[0-9]+$/", $value) == true) {
             return false;
        }

        return $error;
    }

    public function required($value, $error = 'standard required error message')
    {
        if(trim($value) != null) {
            return false;
        }

        return $error;
    }

    public function mail($value, $error = 'standard mail error message')
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return $error;
    }

}