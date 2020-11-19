<?php

namespace Controller;

abstract class Controller
{

    public function render(string $file, array $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader('./View/');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,// '/path/to/compilation_cache',
            'debug' => true
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);
        
        echo $twig->render($file.'.twig', $data);
    }
}