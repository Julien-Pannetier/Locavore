<?php

namespace Controller;

use App\Form;
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
    }

    /**
     * Inscription des utilisateurs
     * 
     *  @return void
     */
    public function register()
    {
        if(!empty($_POST)){
            $errors = array();

            if(empty($_POST['lastName'])){
                $errors['lastName'] = "Veuillez entrer votre nom.";
            }
            if(empty($_POST['firstName'])){
                $errors['firstName'] = "Veuillez entrer votre prénom.";
            }
            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = "Veuillez entrer une adresse de messagerie valide.";
            } else {
                $email = strip_tags($_POST['email']);
                $user = $this->userManager->findByEmail($email);
                if($user){
                    $errors['email'] = "Cette adresse de messagerie est déjà utilisée.";
                }
            }
            if(empty($_POST['password']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors['password'] = "Veuillez entrer un mot de passe valide.";
            }

            if(empty($errors)){
                $lastName = strip_tags($_POST['lastName']);
                $firstName = strip_tags($_POST['firstName']);
                $email = strip_tags($_POST['email']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $user = $this->userManager->create($lastName, $firstName, $email, $password);

                $_SESSION['flash']['success'] = "Votre compte a bien été créé.";
                $this->render('user/login', []);
            }
        }
        $this->render('user/register', []);
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
        if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
            $user = $this->userManager->login(strip_tags($_POST['email']), strip_tags($_POST['password']));
            if (!$user) {
                $_SESSION['flash']['danger'] = "Identifiant / mot de passe incorrect.";
                $this->render('user/login', []);
            } else {
                $_SESSION['flash']['success'] = "Vous êtes bien connecté.";
                $this->render('dashboard/index', []);
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
            $this->render('dashbord/index', []);
        }
    }


    public function forgotPassword()
    {
        $this->render('user/forgotPassword', []);
    }
}