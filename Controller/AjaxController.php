<?php

namespace Controller;

use Helper\Session;
use Model\StoreManager;

class AjaxController extends Controller
{

    public function __construct()
    {
        $this->storeManager = new StoreManager();
        $this->session = new Session();
    }

    public function getStores()
    {
        $stores =  $this->storeManager->findAllAjax(0, 1000000);
        echo(json_encode($stores));
    }

    public function getFlash()
    {
        $flash = $this->session->getFlash();
        echo(json_encode($flash));
    }
}