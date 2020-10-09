<?php

namespace Controller;

abstract class Controller
{
/*      public function render(string $file, array $data = [], string $template = 'default')
    {
        extract($data);

        ob_start();
        require_once('./View/'.$file.'.php');
        $content = ob_get_clean();
        require_once('./View/'.$template.'.php');
    } */

    public function render(string $file, array $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader('./View/');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,// '/path/to/compilation_cache',
            'debug' => true
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        
        echo $twig->render($file.'.twig', $data);
    }
}