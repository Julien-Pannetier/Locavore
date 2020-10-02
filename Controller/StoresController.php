<?php

namespace Controller;

use App\Form;
use Model\Stores;
use Controller\Controller;

class StoresController extends Controller
{
    public function index()
    {
        $stores = new Stores;
        $allStores = $stores->findAll();
        
       $this->render('stores/index', compact('allStores'));
    }

    /**
     * Affiche un point de vente
     *
     * @param integer $id Id du point de vente
     * @return void
     */
    public function read(int $id)
    {
        $stores = new Stores;
        $store = $stores->find($id);

        $this->render('stores/read', compact('store'));
    }

    /**
     * Crée un point de vente
     *
     * @return void
     */
    public function create()
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){

            if(Form::validate($_POST, ['name', 'description'])){
                $name = strip_tags($_POST['name']);
                $description = strip_tags($_POST['description']);

                $store = new Stores;

                $store->setName($name)
                    ->setDescription($description)
                    ->setUserId($_SESSION['user']['id']);

                $store->create();
                $_SESSION['message'] = "Votre point de vente a été ajouté avec succès";
                header('Location : locavore/users/profil');
            } else {
                $_SESSION['error'] = !empty($_POST) ? "Le formulaire est incomplet" : '';
                $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
            }

            $form = new Form;
            $form->startForm()
                ->addLabelFor('name', 'Nom du point de vente')
                ->addInput('text', 'name', [
                    'id' => 'name',
                    'class' => 'form-control',
                    'value' => $name
                ])
                ->addLabelFor('description', 'Description du point de vente')
                ->addTextarea('description', '', [
                    'id' => 'description',
                    'class' => 'form-control',
                    'value' => $description
                ])
                ->addButton('Ajouter', ['class' => 'btn btn-primary'])
                ->endForm();

            $this->render('stores/create', ['form' => $form->create()]);

        } else {
            $_SESSION['error'] = "Vous devez être connecté(e) pour accéder à cette page !";
            header('Location: /locavore/users/login');
            exit;
        }
    }

    /**
     * Modifie un point de vente
     *
     * @param integer $id
     * @return void
     */
    public function update(int $id)
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){

            $stores = new Stores;
            $store = $stores->find($id);

            if(!$store){
                http_response_code(404);
                $_SESSION['error'] = "L'annonce recherchée n'existe pas !";
                header('Location: /locavore/admin');
                exit;
            }
            if($store->user_id !== $_SESSION['user']['id']){
                if($_SESSION['user']['role'] !== 'admin'){
                    $_SESSION['error'] = "Vous n'avez pas accès à cette page !";
                    header('Location: /locavore/admin');
                    exit;
                }
            }

            if(Form::validate($_POST, ['name', 'description'])){
                $name = strip_tags($_POST['name']);
                $description = strip_tags($_POST['description']);

                $updateStore = new Stores;

                $updateStore->setId($store->id)
                    ->setName($name)
                    ->setDescription($description);

                $updateStore->update();

                $_SESSION['message'] = "Votre point de vente a été modifié avec succès";
                header('Location : /locavore/admin');

            } else {
                $_SESSION['error'] = !empty($_POST) ? "Le formulaire est incomplet" : '';
                $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
            }

            $form = new Form;
            $form->startForm()
                ->addLabelFor('name', 'Nom du point de vente')
                ->addInput('text', 'name', [
                    'id' => 'name',
                    'class' => 'form-control',
                    'value' => $store->name
                ])
                ->addLabelFor('description', 'Description du point de vente')
                ->addTextarea('description', $store->description, [
                    'id' => 'description',
                    'class' => 'form-control'
                ])
                ->addButton('Modifier', ['class' => 'btn btn-primary'])
                ->endForm();

            $this->render('stores/update', ['form' => $form->create()]);

        } else {
            $_SESSION['error'] = "Vous devez être connecté(e) pour accéder à cette page !";
            header('Location: /locavore/users/login');
            exit;
        }
    }

    /**
     * Supprime un point de vente
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $store = new Stores;
        $store->delete($id);
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}