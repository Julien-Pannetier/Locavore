<?php

namespace Controller;

use App\Form;
use Model\Users;
use Controller\Controller;

class UsersController extends Controller
{
    /**
     * Connexion des utilisateurs
     *
     * @return void
     */
    public function login()
    {
        if(Form::validate($_POST, ['email', 'password'])){
            $users = new Users;
            $userArray = $users->findOneByEmail(strip_tags($_POST['email']));

            if(!$userArray){
                $_SESSION['error'] = "Identifiant et/ou mot de passe incorrect !";
                header('Location: /locavore/users/login');
                exit;
            }

            $user = $users->hydrate($userArray);

            if(password_verify($_POST['password'], $user->getPassword())){
                $user->setSession();
                header('location: /locavore/users/profil');
                exit;
            } else {
                $_SESSION['error'] = "Identifiant et/ou mot de passe incorrect !";
                header('Location: /locavore/users/login');
                exit;
            }
        }

        $form = new Form;

        $form->startForm()
            ->addLabelFor('email', 'E-mail :')
            ->addInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->addLabelFor('password', 'Mot de passe :')
            ->addInput('password', 'password', ['id' => 'password', 'class' => 'form-control'])
            ->addButton('Se connecter', ['class' => 'btn btn-primary'])
            ->endForm();

        $this->render('users/login', ['loginForm' => $form->create()]);
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

            $user = new Users;
            $user->setEmail($email)
                ->setPassword($password);
            
            $user->create();
        }
        
        $form = new Form;

        $form->startForm()
            ->addLabelFor('email', 'E-mail :')
            ->addInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->addLabelFor('password', 'Mot de passe :')
            ->addInput('password', 'password', ['id' => 'password', 'class' => 'form-control'])
            ->addButton('S\'inscrire', ['class' => 'btn btn-primary'])
            ->endForm();
    
        $this->render('users/register', ['registerForm' => $form->create()]);
    }

    /**
     * Déconnexion des utilisateurs
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }
}