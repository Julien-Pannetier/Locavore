<?php

namespace Controller;

use Controller\Controller;
use Model\Stores;

class StoresController extends Controller
{
    public function index()
    {
        $stores = new Stores;
        $storesList = $stores->findAll();
        
        var_dump($storesList);
        
        //include_once('./view/stores/index.php');
    }
}