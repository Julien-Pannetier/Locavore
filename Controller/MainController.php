<?php

namespace Controller;

use Controller\Controller;

class MainController extends Controller
{
    public function index()
    {
        $this->render('main/index', [], 'default');
    }
}