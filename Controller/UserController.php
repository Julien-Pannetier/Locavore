<?php

namespace Controller;

use Helper\Session;
use Helper\Redirect;
use Helper\Validator;
use Model\UserManager;
use Controller\Controller;

class UserController extends Controller
{

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->userManager = new UserManager;
		$this->validator = new Validator($_POST);
		$this->redirect = new Redirect();
		$this->session = new Session();
	}

	/**
	 * Inscription des utilisateurs
	 * 
	 *  route(/user/register)
	 */
	public function register()
	{ 
		$errors = array();
		if (!empty($_POST)) {
			$this->validator->isText('lastName', "Veuillez saisir votre nom.");
			$this->validator->isText('firstName', "Veuillez saisir votre prénom.");
			$this->validator->isEmail('email', "Veuillez saisir une adresse électronique valide.");
			$this->validator->isPassword('password', "Veuillez saisir un mot de passe valide.");
			if ($this->validator->isValid()) {
				$user = $this->userManager->findOneByEmail(htmlspecialchars($_POST['email']));
				if (!$user) {
					$lastName = htmlspecialchars($_POST['lastName']);
					$firstName = htmlspecialchars($_POST['firstName']);
					$email = htmlspecialchars($_POST['email']);
					$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
					$stmt = $this->userManager->create($lastName, $firstName, $email, $password);
					if($stmt) {
						$this->session->setFlash("success", "Votre compte a bien été créé.");
						header("Location: /user/login");
						exit;
					} else {
						$this->session->setFlash("error", "Votre compte n'a pas été créé.");
						header("Location: /user/register");
						exit;
					}
				} else {
					$this->session->setFlash("error", "Cette adresse de messagerie est déjà utilisée.");
					header("Location: /user/register");
					exit();
				}
			} else {
				$errors = $this->validator->getErrors();
				$implodeErrors = implode("<br>", $errors);
				$this->session->setFlash("error", $implodeErrors);
			}
		}
		$this->render('/user/register', []);
	}

	/**
	 * Connexion de l'utilisateur
	 *
	 * route(/user/login)
	 */
	public function login() 
	{
		$errors = array();
		if (!empty($_POST)) {
			$this->validator->isEmail('email', "Veuillez saisir une adresse électronique valide.");
			$this->validator->isPassword('password', "Veuillez saisir un mot de passe valide.");
			if ($this->validator->isValid()) {
				$user = $this->userManager->findOneByEmail(htmlspecialchars($_POST['email']));
				if ($user AND password_verify(htmlspecialchars($_POST['password']), $user->getPassword())) {
					$this->session->setUser($user);
					header("Location: /user/dashboard");
					exit();
				} else {
					$this->session->setFlash("error", "Identifiant / mot de passe incorrect.");
					header("Location: /user/login");
					exit();
				}
			} else {
				$errors = $this->validator->getErrors();
				$implodeErrors = implode("<br>", $errors);
				$this->session->setFlash("error", $implodeErrors);
			}
		}
		$this->render('/user/login', []);
	}

	/**
	 * Affichage du tableau de bord de l'utilisateur
	 *
	 * route(/user/dashboard)
	 */
	public function dashboard()
	{
		if($this->validator->isAdmin()) {
			header("location: /store/findAllPending");
			exit;
		} else if ($this->validator->isConnected()) {
			$userId = $_SESSION['user']['id'];
			$user = $this->userManager->findOneById($userId);
			$this->render('/user/dashboard', compact('user'));
		} else {
			$this->redirect->notConnected();
		}
	}

	/**
	 * Modification des informations de l'utilisateur
	 *
	 * route(/user/update)
	 */
	public function update()
	{
		$errors = array();
		if(!empty($_POST)){
			$this->validator->isText('lastName', "Veuillez saisir votre nom.");
			$this->validator->isText('firstName', "Veuillez saisir votre prénom.");
			$this->validator->isEmail('email', "Veuillez saisir une adresse électronique valide.");
			if($this->validator->isValid()){
				$user = $this->userManager->findOneByEmail(htmlspecialchars($_POST['email']));
				$userId = $_SESSION['user']['id'];
				if ((!$user) || ($user->getId() === $userId)) {
					$lastName = htmlspecialchars($_POST['lastName']);
					$firstName = htmlspecialchars($_POST['firstName']);
					$email = htmlspecialchars($_POST['email']);
					$stmt = $this->userManager->update($userId, $lastName, $firstName, $email);
					if($stmt) {
						$this->session->setFlash("success", "Votre compte a bien été modifié.");
						header("Location: /user/dashboard");
						exit;
					} else {
						$this->session->setFlash("error", "Votre compte n'a pas été modifié");
						header("Location: /user/dashboard");
						exit;
					}
				} else {
					$this->session->setFlash("error", "Cette adresse de messagerie est déjà utilisée.");
					header("Location: /user/dashboard");
					exit();
				}
			} else {
				$errors = $this->validator->getErrors();
				$implodeErrors = implode("<br>", $errors);
				$this->session->setFlash("error", $implodeErrors);
				$this->render('/user/dashboard', []);
				exit();
			}
		}
	}

	/**
	 * Modification du mot de passe de l'utilisateur
	 *
	 * route(/user/updatePassword)
	 */
	public function updatePassword()
	{
		$errors = array();
		if(!empty($_POST)){
			$this->validator->isPassword('password', "Veuillez saisir un mot de passe valide.");
			$this->validator->isPassword('passwordConfirm', "Veuillez confirmer votre mot de passe.");
			if($this->validator->isValid()){
				if($_POST['password'] != $_POST['passwordConfirm']) {
					$this->session->setFlash("error", "La confirmation du mot de passe ne correspond pas au mot de passe saisi.");
					header("Location: /user/dashboard");
					exit;
				} else {
					$userId = $_SESSION['user']['id'];
					$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
					$stmt = $this->userManager->updatePassword($userId, $password);
					if($stmt) {
						$this->session->setFlash("success", "Votre mot de passe a bien été modifié");
						header("Location: /user/dashboard");
						exit;
					} else {
						$this->session->setFlash("error", "Votre mot de passe n'a pas été modifié");
						header("Location: /user/dashboard");
						exit;
					}
				}
			} else {
				$errors = $this->validator->getErrors();
				$implodeErrors = implode("<br>", $errors);
				$this->session->setFlash("error", $implodeErrors);
				header("Location: /user/dashboard");
				exit;
			}
		}
	}

	/**
	 * Déconnexion des utilisateurs
	 *
	 * route(/user/logout)
	 */
	public function logout()
	{
		$this->session->unsetUser();
		$this->redirect->logout();
	}
}