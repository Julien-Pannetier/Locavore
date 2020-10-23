<?php

namespace Controller;

use Model\StoreManager;

class AjaxController extends Controller
{

    public function __construct()
    {
        $this->storeManager = new StoreManager();
    }

    public function getStores()
    {
        $stores =  $this->storeManager->findAllStores(0, 1000000);
        echo(json_encode($stores));
    }
}