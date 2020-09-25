<?php

use App\Main;

// On définit une constance contenant le dossier racine du projet
//define('ROOT', dirname(__DIR__));

//On importe l'autoloader
//require_once ROOT.'/vendor/autoload.php';
require 'vendor/autoload.php';

// On instancie Main (le routeur)
$app = new Main();

// On demarre l'application
$app->start();