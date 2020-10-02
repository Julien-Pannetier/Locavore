<?php

use App\Main;

//On importe l'autoloader
require 'vendor/autoload.php';

// On instancie Main (le routeur)
$app = new Main();

// On demarre l'application
$app->start();