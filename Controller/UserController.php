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
            $this->validator->isText('lastName', "Veuillez entrer votre nom.");
            $this->validator->isText('firstName', "Veuillez entrer votre prénom.");
            $this->validator->isEmail('email', "Veuillez entrer une adresse de messagerie valide.");
            if($this->validator->isValid()){
                $user = $this->userManager->findOneByEmail(htmlspecialchars($_POST['email']));
                $this->validator->isUniq('email', $user, "Cette adresse de messagerie est déjà utilisée.");           
            }
            $this->validator->isPassword('password', "Veuillez entrer un mot de passe valide.");

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
            $this->validator->isEmail('email', "Veuillez entrer une adresse de messagerie valide.");
            $this->validator->isPassword('password', "Veuillez entrer un mot de passe valide.");
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
            }
        }
        $this->render('/user/login', compact('errors'));
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


    public function updatePassword()
    {
        if(empty($_POST['password']) || $_POST['password'] != $_POST['passwordConfirm']){
            $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas.";
        } else {
            $userId = $_SESSION['user']->id;
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt = $this->userManager->updatePassword($userId, $password);
            $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
            $this->render('/user/dashbord', []);
        }
    }

    public function forgotPassword()
    {
        $this->render('/user/forgotPassword', []);
    }

    public function dashboard()
    {
        if($this->validator->isAdmin()){
            // Ecrire le code et corriger le chemin du render
            $this->render('/user/dashboard', []);
        } else if ($this->validator->isConnected()){
            $this->render('/user/dashboard', []);
        } else {
            $this->redirect->notConnected();
        }
    }
}