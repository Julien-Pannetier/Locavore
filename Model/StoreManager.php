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

    public function findById($id) 
    {
        $query = 'SELECT * FROM stores WHERE id = :id';
        $req = $this->db->prepare($query);
        $req->bindParam("id", $id, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $store = new Store($data);
        }
        return $store;
    }

    public function findAll($offset, $limit) 
    {
        $stores = [];
        $query = 'SELECT * FROM stores ORDER BY creation_at DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $stores[] = new Store($data);
        }
        return $stores;
    }

    public function findAllAjax($offset, $limit) 
    {
        $stores = [];
        $query = 'SELECT id, name, address, postal_code, city, country, ST_AsText(lng_lat) as wkt FROM stores ORDER BY creation_at DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $stores[] = $data;
        }
        return $stores;
    }

    public function create($name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat)
    {
        $query = "INSERT INTO stores(name, description, type, address, postal_code, city, country, lng_lat, creation_at) VALUES (:name, :description, :type, :address, :postalCode, :city, :country, POINT(:lng, :lat), NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("type", $type, PDO::PARAM_STR);
        $stmt->bindParam("address", $address, PDO::PARAM_STR);
        $stmt->bindParam("postalCode", $postalCode, PDO::PARAM_STR);
        $stmt->bindParam("city", $city, PDO::PARAM_STR);
        $stmt->bindParam("country", $country, PDO::PARAM_STR);
        $stmt->bindParam("lng", $lngLat, PDO::PARAM_STR);
        $stmt->bindParam("lat", $lat, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function update($id, $name, $description) 
    {
        $query = 'UPDATE stores SET name = :name, description = :description WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function delete($id) 
    {
        $query = 'DELETE FROM stores WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}