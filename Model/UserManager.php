<?php

namespace Model;

use PDO;
use Model\Database;

class UserManager extends Database 
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupère un utilisateur à partir de son id
     *
     * @param [int] $id
     * @return object
     */
    public function findOneById($id)
    {
        $user = null;
        $query = 'SELECT * FROM users WHERE id = :id';
        $req = $this->db->prepare($query);
        $req->bindParam("id", $id, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $user = new User($data);
        }
        return $user;
    }

    /**
     * Récupère un utilisateur à partir de son email
     *
     * @param [string] $email
     * @return object
     */
    public function findOneByEmail($email)
    {
        $user = null;
        $query = 'SELECT * FROM users WHERE email = :email';
        $req = $this->db->prepare($query);
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
     * @param [int] $offset
     * @param [int] $limit
     * @return object
     */
    public function findAll($offset, $limit) 
    {
        $users = [];
        $query = 'SELECT * FROM users ORDER BY registration_at DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
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
     * @param [string] $lastName
     * @param [string] $firstName
     * @param [string] $email
     * @param [string] $password
     * @return boolean
     */
    public function create($lastName, $firstName, $email, $password) 
    {
        $query = 'INSERT INTO users(last_name, first_name, email, password, registration_at) VALUES (:lastName, :firstName, :email, :password, NOW())';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("lastName", $lastName, PDO::PARAM_STR);
        $stmt->bindParam("firstName", $firstName, PDO::PARAM_STR);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Modifie un utilisateur
     *
     * @param [int] $id
     * @param [string] $lastName
     * @param [string] $firstName
     * @param [string] $email
     * @return boolean
     */
    public function update($id, $lastName, $firstName, $email)
    {
        $query = 'UPDATE users SET last_name = :lastName, first_name = :firstName, email = :email WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("lastName", $lastName, PDO::PARAM_STR);
        $stmt->bindParam("firstName", $firstName, PDO::PARAM_STR);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Modifie le mot de passe d'un utilisateur
     *
     * @param [int] $id
     * @param [string] $password
     * @return boolean
     */
    public function updatePassword($id, $password) 
    {
        $query = 'UPDATE users SET password = :password WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Supprime un utilisateur
     *
     * @param [int] $id
     * @return boolean
     */
    public function delete($id) 
    {
        $query = 'DELETE FROM users WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }
}