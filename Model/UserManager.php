<?php

namespace Model;

use PDO;
use Model\Database;

class UserManager extends Database 
{

    /**
     * Récupère un utilisateur à partir de son email
     *
     * @param [type] $email
     * @return void
     */
    public function findUserByEmail($email)
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $db = $this->getInstance();
        $req = $db->prepare($query);
        $req->bindParam("email", $email, PDO::PARAM_STR);
        $req->execute();
        while ($data = $req->fetch()) {
            $user = new User($data);
        }
        return $user;
    }

    /**
     * Récupère tous les utilisateurs
     *
     * @param [type] $offset
     * @param [type] $limit
     * @return void
     */
    public function findAllUsers($offset, $limit) 
    {
        $users = [];
        $query = 'SELECT * FROM users ORDER BY creation_date DESC LIMIT :offset, :limit';
        $db = $this->getInstance();
        $req = $db->prepare($query);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $users[] = new User($data);
        }
        return $users;
    }

    /**
     * Crée un nouvel utilisateur
     *
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function createUser($email, $password) 
    {
        $query = 'INSERT INTO users(email, password, creation_date) VALUES (:email, :password, NOW())';
        $db = $this->getInstance();
        $stmt = $db->prepare($query);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Modifie un utilisateur
     *
     * @param [type] $id
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function updateUser($id, $email, $password) 
    {
        $query = 'UPDATE users SET email = :email, password = :password WHERE id = :id';
        $db = $this->getInstance();
        $stmt = $db->prepare($query);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Supprime un utilisateur
     *
     * @param [type] $id
     * @return void
     */
    public function deleteUser($id) 
    {
        $query = 'DELETE FROM users WHERE id = :id';
        $db = $this->getInstance();
        $stmt = $db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Crée la session de l'utilisateur
     *
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'role' => $this->role,
            'email' => $this->email
        ];
    }
}