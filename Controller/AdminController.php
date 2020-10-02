<?php

namespace Controller;

use Model\Stores;

class AdminController extends Controller
{
    public function index()
    {
        if($this->isAdmin()){
            $this->render('admin/index', [], 'admin');
        }
    }

    /**
     * Affiche la liste des points de vente sous forme de tableau
     *
     * @return void
     */
    public function stores()
    {
        if($this->isAdmin()){
            $stores = new Stores;
            $allStores = $stores->findAll();
            
           $this->render('admin/stores', compact('allStores'), 'admin');
        }
    }

    private function isAdmin()
    {
        if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'){
            return true;
        } else {
            $_SESSION['error'] = "Vous n'avez pas les droits nécessaires pour effectuer cette opération !";
            header('Location: /locavore/index.php?p=');
            exit;
        }
    }
}