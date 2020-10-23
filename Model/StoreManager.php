<?php

namespace Model;

use PDO;
use Model\Store;
use Model\Database;

class StoreManager extends Database
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findStoreById($id) 
    {
        $query = 'SELECT id, name, description, DATE_FORMAT(creation_date, "%d/%m/%Y") AS date FROM stores WHERE id = :id';
        $req = $this->db->prepare($query);
        $req->bindParam("id", $id, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $store = new Store($data);
        }
        return $store;
    }

    public function findAllStores($offset, $limit) 
    {
        $stores = [];
        $query = 'SELECT id, name, description, DATE_FORMAT(creation_date, "%d/%m/%Y") AS date FROM stores ORDER BY creation_date DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $stores[] = new Store($data);
        }
        return $stores;
    }

    public function createStore($name, $description) 
    {
        $query = 'INSERT INTO stores(name, description, creation_date) VALUES (:name, :description, NOW())';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function updateStore($id, $name, $description) 
    {
        $query = 'UPDATE stores SET name = :name, description = :description WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function deleteStore($id) 
    {
        $query = 'DELETE FROM stores WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}