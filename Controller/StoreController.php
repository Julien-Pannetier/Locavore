<?php

namespace Controller;

use Helper\Session;
use Helper\Redirect;
use Helper\Validator;
use Model\StoreManager;
use Controller\Controller;
use Helper\NotFoundException;
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
	 * route(/store/findOne/{id})
	 */
	public function findOne(int $id)
	{
		$store = $this->storeManager->findOneById($id);
		if(isset($store)){
			$this->render('/store/findOneById', compact('store'));
		} else {
			throw new NotFoundException("La page que vous recherchez est introuvable.");
		}
	}

	/**
	 * Affiche la liste de tous les points de vente
	 * Affiche la liste de tous les points de vente d'un utilisateur
	 *
	 * route(/store/findAll)
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
	 * route(/store/findAllApproved)
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
	 * route(/store/findAllPending)
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
	 * route(/store/findAllRejected)
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
	 * Crée un point de vente
	 *
	 * route(/store/create)
	 */
	public function create()
	{
		if ($this->validator->isConnected()) {
			$errors = array();
			if (!empty($_POST)) {
				$this->validator->isNotNul('name', "Veuillez entrer un nom de point vente.");
				$this->validator->isNotNul('description', "Veuillez entrer une description.");
				$this->validator->isNotNul('type', "Veuillez entrer un type de point de vente.");
				$this->validator->isNotNul('address', "Veuillez entrer une adresse postale.");
				$this->validator->isPostalCode('postalCode', "Veuillez entrer un code postal valide.");
				$this->validator->isText('city', "Veuillez entrer un nom de ville valide.");
				$this->validator->isText('country', "Veuillez entrer un nom de pays valide.");
				$this->validator->isNumeric('lat', "Veuillez entrer une latitude valide.");
				$this->validator->isNumeric('lng', "Veuillez entrer une longitude valide.");
				$_POST['phone'] != null ? $this->validator->isPhoneNumber('phone', "Veuillez entrer un numéro de téléphone valide.") : false ;
				$_POST['email'] != null ? $this->validator->isEmail('email', "Veuillez entrer une adresse de messagerie valide.") : false ; 
				$_POST['website'] != null ? $this->validator->isUrl('website', "Veuillez entrer une URL valide.") : false ;
				$_POST['facebook'] != null ? $this->validator->isUrl('facebook', "Veuillez entrer une URL valide.") : false ; 
				$_POST['twitter'] != null ? $this->validator->isUrl('twitter', "Veuillez entrer une URL valide.") : false ;
				$_POST['instagram'] != null ? $this->validator->isUrl('instagram', "Veuillez entrer une URL valide.") : false ;
	
				if ($this->validator->isValid()) {
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
					$status = 'En attente';
					if ($this->validator->isAdmin()) {
						$status = htmlspecialchars($_POST['status']);
					}
					$stmt = $this->storeManager->create($userId, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $status);
					if ($stmt === false) {
						$this->session->setFlash("error", "Erreur lors de la création d'un nouveau point de vente.");
						header("Location: /store/create");
						exit;
					} else {
						$storeId = $this->storeManager->lastId();
						$products = $_POST['checkbox'];
						foreach($products as $productId) {
							$this->storesProductsFamilyManager->create( $storeId, $productId);
						}
						$this->session->setFlash("success", "Le point de vente a bien été créé.");
						header("Location: /store/findAll");
						exit;
					}
				} else {
					$errors = $this->validator->getErrors();
					$implodeErrors = implode("<br>", $errors);
					$this->session->setFlash("error", $implodeErrors);
					header("Location: /store/create");
					exit();
				}
			} else {
				$this->render('/store/create', [
					'head' => [
						'description' => 'Description',
						'author' => 'Auteur',
						'title' => 'Titre',
					]
				]);
			}
		} else {
			$this->redirect->notConnected();
		}
	}

	/**
	 * Modifie un point de vente
	 *
	 * @param integer $id Id du point de vente
	 * route(/store/update/{id})
	 */
	public function update(int $id)
	{
		if ($this->validator->isConnected()) {
			$store = $this->storeManager->findOneById($id);
			if ($store) {
				$userId = $_SESSION['user']['id'];
				if (($userId === $store->getUserId()) || ($_SESSION['user']['role'] === 'admin')) {
					$errors = array();
					if(!empty($_POST)) {
						$this->validator->isNotNul('name', "Veuillez entrer un nom de point vente.");
						$this->validator->isNotNul('description', "Veuillez entrer une description.");
						$this->validator->isNotNul('type', "Veuillez entrer un type de point de vente.");
						$this->validator->isNotNul('address', "Veuillez entrer une adresse postale.");
						$this->validator->isPostalCode('postalCode', "Veuillez entrer un code postal valide.");
						$this->validator->isText('city', "Veuillez entrer un nom de ville valide.");
						$this->validator->isText('country', "Veuillez entrer un nom de pays valide.");
						$this->validator->isNumeric('lat', "Veuillez entrer une latitude valide.");
						$this->validator->isNumeric('lng', "Veuillez entrer une longitude valide.");
						$_POST['phone'] != null ? $this->validator->isPhoneNumber('phone', "Veuillez entrer un numéro de téléphone valide.") : false ;
						$_POST['email'] != null ? $this->validator->isEmail('email', "Veuillez entrer une adresse de messagerie valide.") : false ; 
						$_POST['website'] != null ? $this->validator->isUrl('website', "Veuillez entrer une URL valide.") : false ;
						$_POST['facebook'] != null ? $this->validator->isUrl('facebook', "Veuillez entrer une URL valide.") : false ; 
						$_POST['twitter'] != null ? $this->validator->isUrl('twitter', "Veuillez entrer une URL valide.") : false ;
						$_POST['instagram'] != null ? $this->validator->isUrl('instagram', "Veuillez entrer une URL valide.") : false ;
						if ($this->validator->isValid()) {
							$userId = htmlspecialchars($_SESSION['user']['id']);				
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
							$monday = htmlspecialchars($_POST['monday']);
							$tuesday = htmlspecialchars($_POST['tuesday']);
							$wednesday = htmlspecialchars($_POST['wednesday']);
							$thursday = htmlspecialchars($_POST['thursday']);
							$friday = htmlspecialchars($_POST['friday']);
							$saturday = htmlspecialchars($_POST['saturday']);
							$sunday = htmlspecialchars($_POST['sunday']);
							$status = $store->status;
							if ($this->validator->isAdmin()) {
								$status = htmlspecialchars($_POST['status']);
							}

							$stmt = $this->storeManager->update($id, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $status);		

							if ($stmt === false) {
								$this->session->setFlash("error", "Erreur lors de la modification du point de vente.");
								header("Location: /store/update/$id");
								exit();
							} else {
								$this->storesProductsFamilyManager->delete($id);
								$products = $_POST['checkbox'];
								foreach($products as $productId) {
									$this->storesProductsFamilyManager->create($id, $productId);
								}
								$this->session->setFlash("success", "Le point de vente a bien été modifié");
								header("Location: /store/findAll");
								exit();
							}
						} else {
							$errors = $this->validator->getErrors();
							$implodeErrors = implode("<br>", $errors);
							$this->session->setFlash("error", $implodeErrors);
							header("Location: /store/update/$id");
							exit();
						}
					} else {
						$this->render('/store/update', [
							'head' => [
								'description' => 'Description',
								'author' => 'Auteur',
								'title' => 'Titre',
							],
							'store' => $store
						]);
					}
				} else {
					$this->session->setflash("error", "Vous n'avez pas les droits nécessaires pour effectuer cette opération.");
					header("Location: /store/findAll");
					exit();
				}
			} else {
				throw new NotFoundException("La page que vous recherchez est introuvable.");
			}
		} else {
			$this->redirect->notConnected();
		}
	}

	/**
	 * Supprime un point de vente
	 *
	 * @param integer $id Id du point de vente
	 * route(/store/delete/{id})
	 */
	public function delete(int $id)
	{
		if ($this->validator->isConnected()) {
			$store = $this->storeManager->findOneById($id);
			if ($store) {
				$userId = $_SESSION['user']['id'];
				if (($userId === $store->getUserId()) || ($_SESSION['user']['role'] === 'admin')) {
					$this->storesProductsFamilyManager->delete($id);
					$this->storeManager->delete($id);
					$this->session->setFlash("success", "Le point de vente a bien été supprimé.");
					header("Location: /store/findAll");
					exit();
				} else {
					$this->session->setflash("error", "Vous n'avez pas les droits nécessaires pour effectuer cette opération.");
					header("Location: /user/login");
					exit();
				}
			} else {
				throw new NotFoundException("La page que vous recherchez est introuvable.");
			}
		} else {
			$this->redirect->notConnected();
		}
	}
}