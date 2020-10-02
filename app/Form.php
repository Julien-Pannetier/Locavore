<?php

namespace App;

class Form
{
    private $formCode = '';

    /**
     * Génère le formulaire HTML
     *
     * @return string
     */
    public function create()
    {
        return $this->formCode;
    }

    /**
     * Vérifie si tous les champs du formulaire sont remplis
     *
     * @param array $form
     * @param array $fields
     * @return bool
     */
    public static function validate(array $form, array $fields)
    {
        foreach($fields as $field){
            if(!isset($form[$field]) || empty($form[$field])){
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute les attributs envoyés à la balise
     *
     * @param array $attributes
     * @return string
     */
    private function addAttributes(array $attributes): string
    {
        $str = '';
        $shorts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];
        foreach($attributes as $attribute =>$value){
            if(in_array($attribute, $shorts) && $value == true){
                $str .= " $attribute";
            } else {
                $str .= " $attribute=\"$value\"";
            }
        }
        return $str;
    }

    /**
     * Début du formulaire
     *
     * @param string $method
     * @param string $action
     * @param array $attributes
     * @return Form
     */
    public function startForm(string $method = "post", string $action = '#', array $attributes = []): self
    {
        $this->formCode .= "<form action='$action' method='$method'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';
        
        return $this;
    }

    /**
     * Fin du formulaire
     *
     * @return Form
     */
    public function endForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * Ajout d'un label
     *
     * @param string $for
     * @param string $text
     * @param array $attributes
     * @return Form
     */
    public function addLabelFor(string $for, string $text, array $attributes = []): self
    {
        $this->formCode .= "<label for='$for'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        $this->formCode .= ">$text</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributes = []): self
    {
        $this->formCode .= "<input type='$type' name='$name'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';
        
        return $this;
    }

    public function addTextarea(string $name, string $value = '', array $attributes = []): self
    {
        $this->formCode .= "<textarea name='$name'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        $this->formCode .= ">$value</textarea>";

        return $this;
    }

    public function addSelect(string $name, array $options, array $attributes = []): self
    {
        $this->formCode .= "<select name='$name'";
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';
        foreach($options as $value => $text){
            $this->formCode .= "<option value=\"$value\">$text</option>";
        }
        $this->formCode .='</select>';

        return $this;
    }

    public function addButton(string $text, array $attributes = []): self
    {
        $this->formCode .= '<button ';
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';
        $this->formCode .= ">$text</button>";

        return $this;
    }
}