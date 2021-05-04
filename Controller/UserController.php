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
     *  @return void
     */
    public function register()
    { 
        $errors = array();
        if(!empty($_POST)){
            $this->validator->isText('lastName', "Veuillez saisir votre nom.");
            $this->validator->isText('firstName', "Veuillez saisir votre prénom.");
            $this->validator->isEmail('email', "Veuillez saisir une adresse électronique valide.");
            if($this->validator->isValid()){
                $user = $this->userManager->findOneByEmail(htmlspecialchars($_POST['email']));
                $this->validator->isUniq('email', $user, "Cette adresse de messagerie est déjà utilisée.");           
            }
            $this->validator->isPassword('password', "Veuillez saisir un mot de passe valide.");

            if($this->validator->isValid()){
                $lastName = htmlspecialchars($_POST['lastName']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $email = htmlspecialchars($_POST['email']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $user = $this->userManager->create($lastName, $firstName, $email, $password);
                $this->session->setFlash("success", "Votre compte a bien été créé.");
                header('Location: /user/login');
                exit;
            } else {
                $errors = $this->validator->getErrors();
            }
        }
        $this->render('/user/register', compact('errors'));
    }

    /**
     * Connexion des utilisateurs
     *
     * @param [string] $email
     * @param [string] $password
     * @return void
     */
    public function login() 
    {
        $errors = array();
        if(!empty($_POST)){
            $this->validator->isEmail('email', "Veuillez saisir une adresse électronique valide.");
            $this->validator->isPassword('password', "Veuillez saisir un mot de passe valide.");
            if($this->validator->isValid()){
                $user = $this->userManager->findOneByEmail(htmlspecialchars($_POST['email']));
                if($user AND password_verify(htmlspecialchars($_POST['password']), $user->getPassword())) {
                    $this->session->setUser($user);
                    header('Location: /user/dashboard');
                    exit();
                } else {
                    $this->session->setFlash("error", "Identifiant / mot de passe incorrect.");
                    header('Location: /user/login');
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
     * Déconnexion des utilisateurs
     *
     * @return void
     */
    public function logout()
    {
        $this->session->unsetUser();
        $this->redirect->logout();
    }

    /**
     * Modification des informations de l'utilisateur
     *
     * @return void
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
                $this->validator->isUniq('email', $user, "Cette adresse de messagerie est déjà utilisée.");
                $this->render('/user/dashboard', []);
                exit();      
            }

            if($this->validator->isValid()){
                $userId = $_SESSION['user']['id'];
                $lastName = htmlspecialchars($_POST['lastName']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $email = htmlspecialchars($_POST['email']);
                $stmt = $this->userManager->update($userId, $lastName, $firstName, $email);
                $this->session->setFlash("success", "Votre compte a bien été modifié.");
                $this->render('/user/dashboard', []);
                exit();
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
     * @return void
     */
    public function updatePassword()
    {
        $errors = array();
        if(!empty($_POST)){
            $this->validator->isPassword('password', "Veuillez saisir un mot de passe valide.");
            $this->validator->isPassword('passwordConfirm', "Veuillez saisir un mot de passe valide.");
            if($this->validator->isValid()){
                if($_POST['password'] != $_POST['passwordConfirm']) {
                    $this->session->setFlash("error", "La confirmation du mot de passe ne correspond pas au mot de passe saisi.");
                    $this->render('/user/dashboard', []);
                    exit;
                } else {
                    $userId = $_SESSION['user']['id'];
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $stmt = $this->userManager->updatePassword($userId, $password);
                    $this->session->setFlash("success", "Votre mot de passe a bien été modifié");
                    $this->render('/user/dashboard', []);
                    exit;
                }
            } else {
                $errors = $this->validator->getErrors();
                $implodeErrors = implode("<br>", $errors);
                $this->session->setFlash("error", $implodeErrors);
                $this->render('/user/dashboard', []);
                exit;
            }
        }
    }

    /**
     * Tableau de bord
     *
     * @return void
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
     * Réinitialisation du mot de passe de l'utilisateur
     *
     * @return void
     */
    public function forgotPassword()
    {
        $this->render('/user/forgotPassword', []);
    }
}