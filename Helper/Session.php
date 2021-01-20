<?php

namespace Helper;

class Session
{

    public function setUser($user)
    {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'lastName' => $user->getLastName(),
            'firstName' => $user->getFirstName(),
            'role' => $user->getRole(),
            'email' => $user->getEmail()
        ];
    }

    public function unsetUser()
    {
        unset($_SESSION['user']);
    }

    public function setFlash($type, $message)
    {
        $_SESSION['flash'] = array(
            'type' => $type,
            'message' => $message
        );
    }

    public function getFlash()
    {
        $flash = null;
        if(array_key_exists('flash', $_SESSION)){
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);            
        }
        return $flash;
    }
}