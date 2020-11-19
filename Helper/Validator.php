<?php

namespace Helper;

class Validator
{
    
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    private function getField($field)
    {
        if(!isset($this->data[$field])){
            return null;
        }
        return $this->data[$field];
    }
    
    public function isText($field, $errorMsg)
    {
        if(!preg_match("/([ \u00c0-\u01ffa-zA-Z'\-])/", $this->getField($field))){
            $this->errors[$field] = $errorMsg;

            //^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]{1,30})+$
            //^([ \u00c0-\u01ffa-zA-Z'\-])+$
            //([ \u00c0-\u01ffa-zA-Z'\-])
            //^[a-zA-Z0-9_]+$
        }
    }

    public function isEmail($field, $errorMsg)
    {
        if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isUniq($field, $record, $errorMsg)
    {
        if($record){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isPassword($field, $errorMsg)
    {
        $value = $this->getField($field);
        if(empty($value)){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}