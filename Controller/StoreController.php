<?php

namespace Controller;

use Helper\Session;
use Helper\Redirect;
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
        $this->redirect = new Redirect();
        $this->session = new Session();
    }

    /**
     * Affiche un point de vente
     *
     * @param integer $id Id du point de vente
     * @return void
     */
    public function findOne(int $id)
    {
        $store = $this->storeManager->findOneById($id);
        if(isset($store)){
            $this->render('/store/findOneById', compact('store'));
        } else {
            $this->redirect->notFound();
        }
    }

    /**
     * Affiche la liste de tous les points de vente
     * Affiche la liste de tous les points de vente d'un utilisateur
     *
     * @return void
     */
    public function findAll()
    {
        if($this->validator->isAdmin()){
            $allStores = $this->storeManager->findAll(0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ], 
                'content' => [
                    'title' => 'Tous les points de vente',
                ],
                'allStores' => $allStores
            ]);
        } else if ($this->validator->isConnected()){
            $userId = $_SESSION['user']['id'];
            $allStores = $this->storeManager->findAllByUserId($userId, 0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'content' => [
                    'title' => 'Tous mes points de vente',
                ],
                'allStores' => $allStores
            ]);
        } else {
            $this->redirect->notConnected();
        }
    }
   
    /**
     * Affiche la liste de tous les points de vente approuvés
     * Affiche la liste des points de vente approuvés d'un utilisateur
     *
     * @return void
     */
    public function findAllApproved()
    {
        $status = 'Approuvé';
        if($this->validator->isAdmin()){
            $allStores = $this->storeManager->findAllByStatus($status, 0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'content' => [
                    'title' => 'Tous les points de vente approuvés',
                ],
                'allStores' => $allStores
            ]);
        } else if ($this->validator->isConnected()){
            $userId = $_SESSION['user']['id'];
            $allStores = $this->storeManager->findAllByUserIdAndStatus($userId, $status, 0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'content' => [
                    'title' => 'Tous mes points de vente approuvés',
                ],
                'allStores' => $allStores
            ]);
        } else {
            $this->redirect->notConnected();
        }
    }

    /**
     * Affiche la liste de tous les points de vente en attente de validation
     * Affiche la liste des points de vente en attente de validation d'un utilisateur
     *
     * @return void
     */
    public function findAllPending()
    {
        $status = 'En attente';
        if($this->validator->isAdmin()){
            $allStores = $this->storeManager->findAllByStatus($status, 0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'content' => [
                    'title' => 'Tous les points de vente en attente de validation',
                ],
                'allStores' => $allStores
            ]);
        } else if ($this->validator->isConnected()){
            $userId = $_SESSION['user']['id'];
            $allStores = $this->storeManager->findAllByUserIdAndStatus($userId, $status, 0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'content' => [
                    'title' => 'Tous mes points de vente en attente de validation',
                ],
                'allStores' => $allStores
            ]);
        } else {
            $this->redirect->notConnected();
        }
    }

    /**
     * Affiche la liste de tous les points de vente rejetés
     * Affiche la liste des points de vente rejetés d'un utilisateur
     *
     * @return void
     */
    public function findAllRejected()
    {
        $status = 'Rejeté';
        if($this->validator->isAdmin()){
            $allStores = $this->storeManager->findAllByStatus($status, 0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'content' => [
                    'title' => 'Tous les points de vente rejetés',
                ],
                'allStores' => $allStores
            ]);
        } else if ($this->validator->isConnected()){
            $userId = $_SESSION['user']['id'];
            $allStores = $this->storeManager->findAllByUserIdAndStatus($userId, $status, 0, 1000000);
            $this->render('/store/findAll', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'content' => [
                    'title' => 'Tous mes points de vente rejetés',
                ],
                'allStores' => $allStores
            ]);
        } else {
            $this->redirect->notConnected();
        }
    }

    /**
     * Supprime un point de vente
     *
     * @param integer $id Id du point de vente
     * @return void
     */
    public function delete(int $id)
    {       
        $userId = $_SESSION['user']['id'];
        $this->storesProductsFamilyManager->delete($id);
        $this->storeManager->delete($id, $userId);

        $this->session->setFlash("success", "Le point de vente a bien été supprimé.");
        
        $allStores = $this->storeManager->findAllByUserId($userId, 0, 1000000);

        $this->render('/store/findAllByUserId', compact('allStores'));
    }

    /**
     * Crée un point de vente
     *
     * @return void
     */
    public function create()
    {
        $errors = array();
        if(!empty($_POST)){
            $this->validator->isAlphaNumeric('name', "Veuillez entrer un nom de point vente valide.");
            $this->validator->isAlphaNumeric('description', "Veuillez entrer une description valide.");
            $this->validator->isText('type', "Veuillez entrer un type de point de vente valide.");
            $this->validator->isAlphaNumeric('address', "Veuillez entrer une adresse postale valide.");
            $this->validator->isPostalCode('postalCode', "Veuillez entrer un code postal valide.");
            $this->validator->isText('city', "Veuillez entrer un nom de ville valide.");
            $this->validator->isText('country', "Veuillez entrer un nom de pays valide.");
            $this->validator->isNumeric('lat', "Veuillez entrer une latitude valide.");
            $this->validator->isNumeric('lng', "Veuillez entrer une longitude valide.");
            $this->validator->isPhoneNumber('phone', "Veuillez entrer un numéro de téléphone valide.");
            $this->validator->isEmail('email', "Veuillez entrer une adresse de messagerie valide.");
            $this->validator->isUrl('website', "Veuillez entrer une URL valide.");
            $this->validator->isUrl('facebook', "Veuillez entrer une URL valide.");
            $this->validator->isUrl('twitter', "Veuillez entrer une URL valide.");
            $this->validator->isUrl('instagram', "Veuillez entrer une URL valide.");
            $this->validator->isAlphaNumeric('monday', "Veuillez entrer un champ valide.");
            $this->validator->isAlphaNumeric('tuesday', "Veuillez entrer un champ valide.");
            $this->validator->isAlphaNumeric('wednesday', "Veuillez entrer un champ valide.");
            $this->validator->isAlphaNumeric('thursday', "Veuillez entrer un champ valide.");
            $this->validator->isAlphaNumeric('friday', "Veuillez entrer un champ valide.");
            $this->validator->isAlphaNumeric('saturday', "Veuillez entrer un champ valide.");
            $this->validator->isAlphaNumeric('sunday', "Veuillez entrer un champ valide.");

            if($this->validator->isValid()){
                $name = htmlspecialchars($_POST['name']);
                $description = htmlspecialchars($_POST['description']);
                $type = htmlspecialchars($_POST['type']);
                $address = htmlspecialchars($_POST['address']);
                $postalCode = htmlspecialchars($_POST['postalCode']);
                $city = htmlspecialchars($_POST['city']);
                $country = htmlspecialchars($_POST['country']);
                $lat = htmlspecialchars($_POST['lat']);
                $lng = htmlspecialchars($_POST['lng']);
                $phone = htmlspecialchars($_POST['phone']);
                $email = htmlspecialchars($_POST['email']); 
                $website = htmlspecialchars($_POST['website']);
                $facebook = htmlspecialchars($_POST['facebook']); 
                $twitter = htmlspecialchars($_POST['twitter']);
                $instagram = htmlspecialchars($_POST['instagram']);
                $userId = htmlspecialchars($_SESSION['user']['id']);
                $monday = htmlspecialchars($_POST['monday']);
                $tuesday = htmlspecialchars($_POST['tuesday']);
                $wednesday = htmlspecialchars($_POST['wednesday']);
                $thursday = htmlspecialchars($_POST['thursday']);
                $friday = htmlspecialchars($_POST['friday']);
                $saturday = htmlspecialchars($_POST['saturday']);
                $sunday = htmlspecialchars($_POST['sunday']);

            //if (isset($name) && isset($description) && isset($type) && isset($address) && isset($postalCode) && isset($city) && isset($country) && isset($lat) && isset($lng)) {
                $stmt = $this->storeManager->create($userId, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
                $storeId = $this->storeManager->lastId();
                $products = $_POST['checkbox'];
                foreach($products as $productId){
                    $this->storesProductsFamilyManager->create( $storeId, $productId);
                }
                if ($stmt === false) {
                    $this->render('/store/create', [
                        'head' => [
                            'description' => 'Description',
                            'author' => 'Auteur',
                            'title' => 'Titre',
                        ]
                    ]);
                } else {
                    $this->render('/user/dashboard', [
                        'head' => [
                            'description' => 'Description',
                            'author' => 'Auteur',
                            'title' => 'Titre',
                        ]
                    ]);
                }
            } else {
                $errors = $this->validator->getErrors();
            }
        }
        $this->render('/store/create', [
            'head' => [
                'description' => 'Description',
                'author' => 'Auteur',
                'title' => 'Titre',
            ],
            'errors' => $errors
        ]);
    }

    /**
     * Modifie un point de vente
     *
     * @param integer $id Id du point de vente
     * @return void
     */
    public function update(int $id)
    {
        $store = $this->storeManager->findOneById($id);
        if(isset($store)){
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
                    $storeId = $this->storeManager->lastId();
                    $products = $_POST['checkbox'];
                    foreach($products as $productId){
                        $this->storesProductsFamilyManager->create( $storeId, $productId);
                    }
                    if ($stmt === false) {
                        $this->render('/store/update', [
                            'head' => [
                                'description' => 'Description',
                                'author' => 'Auteur',
                                'title' => 'Titre',
                            ]
                        ]);
                    } else {
                        $this->session->setFlash("success", "Votre point de vente a été modifié avec succès");
                        $this->render('/user/dashboard', [
                            'head' => [
                                'description' => 'Description',
                                'author' => 'Auteur',
                                'title' => 'Titre',
                            ]
                        ]);
                    }
                } else {
                    $this->render('/store/update', [
                        'head' => [
                            'description' => 'Description',
                            'author' => 'Auteur',
                            'title' => 'Titre',
                        ]
                    ]);
                }
            }
            $this->render('/store/update', [
                'head' => [
                    'description' => 'Description',
                    'author' => 'Auteur',
                    'title' => 'Titre',
                ],
                'store' => $store
            ]);
        } else {
            $this->redirect->notFound();
        }
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