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
     * Récupère un utilisateur à partir de son email
     *
     * @param [type] $email
     * @return void
     */
    public function findByEmail($email)
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $req = $this->db->prepare($query);
        $req->bindParam("email", $email, PDO::PARAM_STR);
        $req->execute();
/*         while ($data = $req->fetch()) {
            $user = new User($data);
        } */
        $user = $req->fetch();        
        return $user;
    }

    /**
     * Récupère tous les utilisateurs
     *
     * @param [type] $offset
     * @param [type] $limit
     * @return void
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
     * @param [type] $lastName
     * @param [type] $firstName
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function create($lastName, $firstName, $email, $password) 
    {
        $query = 'INSERT INTO users(last_name, first_name, email, password, registration_at) VALUES (:lastName, :firstName, :email, :password, NOW())';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("lastName", $lastName, PDO::PARAM_STR);
        $stmt->bindParam("firstName", $firstName, PDO::PARAM_STR);
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
    public function update($id, $email, $password) 
    {
        $query = 'UPDATE users SET email = :email, password = :password WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Modifie le mot de passe d'un utilisateur
     *
     * @param [type] $id
     * @param [type] $password
     * @return void
     */
    public function updatePassword($id, $password) 
    {
        $query = 'UPDATE users SET password = :password WHERE id = :id';
        $stmt = $this->db->prepare($query);
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
    public function delete($id) 
    {
        $query = 'DELETE FROM users WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }


    public function login($email, $password) 
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $req = $this->db->prepare($query);
        $req->bindParam("email", $email, PDO::PARAM_STR);
        $req->execute();
        $user = $req->fetch();
        if($user AND password_verify($password, $user->password)) {
            $_SESSION['user'] = [
                        'id' => $user->id,
                        'role' => $user->role,
                        'email' => $user->email
                    ];
            return $user;
        } else {
            return false;
        }
    }
}