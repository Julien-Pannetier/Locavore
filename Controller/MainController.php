<?php

namespace Controller;

use Controller\Controller;

class MainController extends Controller
{
    public function index()
    {
        $this->render('/main/index', []);
    }

    public function about()
    {
        $this->render('/main/about', []);
    }

    public function faq()
    {
        $this->render('/main/faq', []);
    }
    
    public function contact()
    {
        $this->render('/main/contact', []);
    }

    public function error()
    {
        $this->render('main/error', []);
    }
}