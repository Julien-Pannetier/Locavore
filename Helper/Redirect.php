<?php

namespace Helper;

use Helper\Session;

class Redirect
{

    public function __construct()
    {
        $this->session = new Session();
    }

    public function notConnected()
    {
        $this->session->setflash("error", "Vous essayez d'accéder à une page réservée aux membres. Veuillez-vous connecter afin d'y accéder.");  
        header('Location: /user/login');
        exit();
    }

    public function notAdmin()
    {
        $this->session->setflash("error", "Vous n'avez pas les droits nécessaires pour effectuer cette opération.");
        header('Location: /user/login');
        exit();
    }

    public function logout()
    {
        $this->session->setflash("success", "Vous êtes maintenant déconnecté.");
        header('Location: /');
        exit();
    }

    public function notFound()
    {
		$this->session->setFlash("error", "La page demandée n'existe pas.");
        header('Location: /');
        exit();
    }
}