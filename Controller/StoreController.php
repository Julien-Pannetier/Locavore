<?php

namespace Controller;

use Helper\Validator;
use Model\StoreManager;
use Controller\Controller;
use Model\StoresProductsFamilyManager;

class StoreController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->storeManager = new StoreManager();
        $this->storesProductsFamilyManager = new StoresProductsFamilyManager();
        $this->validator = new Validator($_POST);
    }

    /**
     * Affiche un point de vente
     *
     * @param integer $id Id du point de vente
     * @return void
     */
    public function findOneById(int $id)
    {
        $store = $this->storeManager->findOneById($id);

        $this->render('/store/findOneById', compact('store'));
    }

    /**
     * Affiche la liste de tous les points de vente
     *
     * @return void
     */
    public function findAll()
    {
        if($this->validator->isAdmin()){
            $allStores = $this->storeManager->findAll(0, 1000000);
            
            $this->render('/store/findAll', compact('allStores'));

        } else {
            $_SESSION['flash']['danger'] = "Vous n'avez pas les droits nécessaires pour effectuer cette opération.";

            $this->render('/main/index', []);
        }
    }

    /**
     * Affiche la liste de tous les points de vente d'un utilisateur
     *
     * @return void
     */
    public function findAllByUserId()
    {
        if($this->validator->isConnected()){
            $userId = $_SESSION['user']['id'];
            $allStores = $this->storeManager->findAllByUserId($userId, 0, 1000000);
            
            $this->render('/store/findAllByUserId', compact('allStores'));

        } else {
            $_SESSION['flash']['danger'] = "";

            $this->render('/user/login', []);
        }
    }

    /**
     * Affiche tous les points de vente
     *
     * @return void
     */
    public function index()
    {
        $stores =  $this->storeManager->findAll(0, 1000000);
        $this->render('/store/index', compact('stores'));
    }

    /**
     * Supprime un point de vente
     *
     * @param integer $id Id du point de vente
     * @return void
     */
    public function delete(int $id)
    {
        $this->storeManager->delete($id);
        
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    /**
     * Crée un point de vente
     *
     * @return void
     */
    public function create()
    {
        if(!empty($_POST)){
            $name = $_POST['name'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $address = $_POST['address'];
            $postalCode = $_POST['postalCode'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $phone = $_POST['phone'];
            $email = $_POST['email']; 
            $website = $_POST['website'];
            $facebook = $_POST['facebook']; 
            $twitter = $_POST['twitter'];
            $instagram = $_POST['instagram'];
            $userId = $_SESSION['user']['id'];
            $monday = $_POST['monday'];
            $tuesday = $_POST['tuesday'];
            $wednesday = $_POST['wednesday'];
            $thursday = $_POST['thursday'];
            $friday = $_POST['friday'];
            $saturday = $_POST['saturday'];
            $sunday = $_POST['sunday'];

            if (isset($name) && isset($description) && isset($type) && isset($address) && isset($postalCode) && isset($city) && isset($country) && isset($lat) && isset($lng)) {
                $stmt = $this->storeManager->create($userId, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
                $storeId = $this->storeManager->lastInsertId();
                $products = $_POST['checkbox'];
                foreach($products as $productId){
                    $this->storesProductsFamilyManager->create( $storeId, $productId);
                }
                if ($stmt === false) {
                    $this->render('/store/create', []);
                } else {
                    $this->render('/user/dashboard', []);
                }
            } else {
                $this->render('/store/create', []);
            }
        }
        $this->render('/store/create', []);
    }

    /* 
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
                header('Location : /users/profil');
            } else {
                $_SESSION['error'] = !empty($_POST) ? "Le formulaire est incomplet" : '';
                $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
            }

            

            $this->render('dashboard/stores', );

        } else {
            $_SESSION['error'] = "Vous devez être connecté(e) pour accéder à cette page !";
            
            $this->render('user/login', []);
        }
    } */

    /**
     * Modifie un point de vente
     *
     * @param integer $id
     * @return void
     */
    /* public function update(int $id)
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){

            $stores = new Stores;
            $store = $stores->find($id);

            if(!$store){
                http_response_code(404);
                $_SESSION['error'] = "L'annonce recherchée n'existe pas !";
                header('Location: /admin');
                exit;
            }
            if($store->user_id !== $_SESSION['user']['id']){
                if($_SESSION['user']['role'] !== 'admin'){
                    $_SESSION['error'] = "Vous n'avez pas accès à cette page !";
                    header('Location: /admin');
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
                header('Location : /admin');

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
            header('Location: /users/login');
            exit;
        }
    }*/
}