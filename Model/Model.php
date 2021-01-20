<?php

namespace Model;

abstract class Model
{
    public function hydrate($data) 
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);          
            $method = ucwords("$method", "_");          
            $method = str_replace("_", "", $method);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}