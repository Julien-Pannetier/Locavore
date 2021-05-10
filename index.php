<?php

use App\Main;
use Helper\NotFoundException;

//On importe l'autoloader
require 'vendor/autoload.php';

// On instancie Main (le routeur)
$app = new Main();

try {
    // On demarre l'application
    $app->start();
} catch (NotFoundException $e){
    return $e->error404();
}