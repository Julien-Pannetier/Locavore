<?php

namespace Controller;

abstract class Controller
{
     public function render(string $file, array $data = [], string $template = 'default')
    {
        extract($data);

        ob_start();
        require_once('./View/'.$file.'.php');
        $content = ob_get_clean();
        require_once('./View/'.$template.'.php');
    }
}