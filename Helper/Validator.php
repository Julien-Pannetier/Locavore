<?php

namespace Helper;

use Helper\Redirect;

class Validator
{
    
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
        $this->redirect = new Redirect();
    }

    private function getField($field)
    {
        if(!isset($this->data[$field])){
            return null;
        }
        return $this->data[$field];
    }

    public function isConnected()
    {
        if(!isset($_SESSION['user'])){
            $this->redirect->notConnected();
        }
    }

    public function isAdmin()
    {
        $isAdmin = true;
        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
            $isAdmin = false;
        }
        return $isAdmin;
    }
    
    public function isText($field, $errorMsg)
    {
        if(!preg_match("/([ \u00c0-\u01ffa-zA-Z'\-])/", $this->getField($field))){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isNumeric($field, $errorMsg)
    {
        if(!is_numeric($this->getField($field))){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isAlphaNumeric($field, $errorMsg)
    {
        if(!ctype_alnum($this->getField($field))){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isPostalCode($field, $errorMsg)
    {
        if(!preg_match("~^[0-9]{5}$~", $this->getField($field))){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isEmail($field, $errorMsg)
    {
        if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isUrl($field, $errorMsg)
    {
        if(!filter_var($this->getField($field), FILTER_VALIDATE_URL)){
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isPhoneNumber($field, $errorMsg)
    {
        if(!preg_match("#^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$#", $this->getField($field))){
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