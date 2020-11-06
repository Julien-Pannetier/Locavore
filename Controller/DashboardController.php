<?php

namespace Controller;

use Model\StoreManager;

class DashboardController extends Controller
{
    public function index()
    {
        if($this->isAdmin()){
            $this->render('/dashboard/index', [], 'admin');
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
            $storeManager = new StoreManager;
            $allStores = $storeManager->findAll(0, 1000000);
            
           $this->render('/dashboard/stores', compact('allStores'), 'admin');
        }
    }


    private function isAdmin()
    {
        if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'){
            return true;
        } else {
            $_SESSION['error'] = "Vous n'avez pas les droits nécessaires pour effectuer cette opération !";

            $this->render('main/index', []);
        }
    }
}