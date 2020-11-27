<?php

namespace Controller;

use Controller\Controller;
use Model\UserManager;
use Helper\Validator;

class UserController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userManager = new UserManager;
        $this->validator = new Validator($_POST);
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
                $user = $this->userManager->findOneByEmail(strip_tags($_POST['email']));
                $this->validator->isUniq('email', $user,"Cette adresse de messagerie est déjà utilisée.");           
            }
            $this->validator->isPassword('password', "Veuillez entrer un mot de passe valide.");

            if($this->validator->isValid()){
                $lastName = strip_tags($_POST['lastName']);
                $firstName = strip_tags($_POST['firstName']);
                $email = strip_tags($_POST['email']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $user = $this->userManager->create($lastName, $firstName, $email, $password);

                $_SESSION['flash']['success'] = "Votre compte a bien été créé.";
                $this->render('user/login', []);
            } else {
                $errors = $this->validator->getErrors();
            }
        }
        $this->render('user/register', compact('errors'));
    }

    /**
     * Connexion des utilisateurs
     *
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function login() 
    {
        if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){
            $user = $this->userManager->login(strip_tags($_POST['email']), strip_tags($_POST['password']));
            if (!$user) {
                $_SESSION['flash']['danger'] = "Identifiant / mot de passe incorrect.";
                $this->render('user/login', []);
            } else {
                $_SESSION['flash']['success'] = "Vous êtes bien connecté.";
                $this->render('user/dashboard', []);
            }
        }
        $this->render('user/login', []);
    }

    /**
     * Déconnexion des utilisateurs
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        $_SESSION['flash']['success'] = "Vous avez été déconnecté.";
        $this->render('main/index', []);
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
            $this->render('dashbord', []);
        }
    }


    public function forgotPassword()
    {
        $this->render('user/forgotPassword', []);
    }


    public function dashboard()
    {
        
        $this->render('user/dashboard', []);
    }
}