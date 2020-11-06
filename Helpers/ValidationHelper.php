<?php

namespace Helpers;

class ValidationHelper {

    public static function getId($getArray) {
        $id = null;
        if (array_key_exists('id', $getArray) && !empty($getArray['id']) && is_numeric($getArray['id']) && $getArray['id'] > 0) {
            $id = intval($getArray['id']);
        }
        return $id;
    }

    public static function getName($post) {
        $name = null;
        if (isset($post) && array_key_exists('name', $post) && isset($post['name'])) {
            $name = $post['name'];
        }
        return $name;
    }

    public static function getDescription($post) {
        $description = null;
        if (isset($post) && array_key_exists('description', $post) && isset($post['description'])) {
            $description = $post['description'];
        }
        return $description;
    }

    public static function getEmailInPost($post) {
        $email = null;
        if (isset($post) && array_key_exists('email', $post) && isset($post['email'])) {
            $email = $post['email'];
        }
        return $email;
    }


    


    /* public static function getPage($getArray) {
        $page = null;
        if (array_key_exists('page', $getArray) && !empty($getArray['page']) && is_numeric($getArray['page']) && $getArray['page'] > 0) {
            $page = intval($getArray['page']);
        } else {
            $page = 1;
        }
        return $page;
    }

    public static function checkAuthentication($session) {
        if (!array_key_exists('admin', $session) || !$session['admin']) {
            header('Location: index.php?action=login');
        }
    } */

}