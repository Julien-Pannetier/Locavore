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
     * Connexion des utilisateurs
     *
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function login() 
    {
        if(Form::validate($_POST, ['email', 'password'])){
            $user = $this->userManager->login(strip_tags($_POST['email']), strip_tags($_POST['password']));
            if (!$user) {
                //Functions::flash('Identifiant / mot de passe incorrect !', 'error');
                $this->render('user/login', []);
            } else {
                $this->render('admin/index', []);
            }
        }
        $this->render('user/login', []);


/*      if(Form::validate($_POST, ['email', 'password'])){   
        //$users = new Users;
        $userArray = $this->userManager->findUserByEmail(strip_tags($_POST['email']));

        if(!$userArray){
            $_SESSION['error'] = "Identifiant et/ou mot de passe incorrect !";
            header('Location: /user/login');
            exit;
        }

        $user = $this->userManager->hydrate($userArray);

        if(password_verify($_POST['password'], $user->getPassword())){
            $user->setSession();
            header('location: /user/profil');
            exit;
        } else {
            $_SESSION['error'] = "Identifiant et/ou mot de passe incorrect !";
            header('Location: /user/login');
            exit;
        } */
    }

    /**
     * Inscription des utilisateurs
     * 
     *  @return void
     */
    public function register()
    {
        if(Form::validate($_POST, ['email', 'password'])){
            $email = strip_tags($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $user = $this->userManager->createUser($email, $password);
            $this->render('user/login', []);
        }
        
        $form = new Form;

        $form->startForm()
            ->addLabelFor('email', 'E-mail :')
            ->addInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->addLabelFor('password', 'Mot de passe :')
            ->addInput('password', 'password', ['id' => 'password', 'class' => 'form-control'])
            ->addButton('S\'inscrire', ['class' => 'btn btn-primary'])
            ->endForm();
    
        $this->render('user/register', ['registerForm' => $form->create()]);
    }

    /**
     * Déconnexion des utilisateurs
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        $this->render('main/index', []);
    }

    
    public function forgotPassword()
    {
        $this->render('user/forgotPassword', []);
    }
}