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

    public function findOneById($id)
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

    public function findAllByUserId($userId, $offset, $limit)
    {
        $stores = [];
        $query = 'SELECT * FROM stores WHERE user_id = :userId ORDER BY creation_at DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
        $req->bindParam("userId", $userId, PDO::PARAM_INT);
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
        $query = 'SELECT id, user_id, name, description, type, address, postal_code, city, country, ST_AsText(lng_lat) as wkt, phone, email, website, facebook, twitter, instagram FROM stores ORDER BY creation_at DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $stores[] = $data;
        }
        return $stores;
    }

    public function create($userId, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram)
    {
        $wkt = "POINT(".$lng." ".$lat.")";
        $query = "INSERT INTO stores(user_id, name, description, type, address, postal_code, city, country, lng_lat, phone, email, website, facebook, twitter, instagram, creation_at) VALUES (:userId, :name, :description, :type, :address, :postalCode, :city, :country, ST_GeomFromText(:wkt), :phone, :email, :website, :facebook, :twitter, :instagram, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("userId", $userId, PDO::PARAM_INT);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("type", $type, PDO::PARAM_STR);
        $stmt->bindParam("address", $address, PDO::PARAM_STR);
        $stmt->bindParam("postalCode", $postalCode, PDO::PARAM_STR);
        $stmt->bindParam("city", $city, PDO::PARAM_STR);
        $stmt->bindParam("country", $country, PDO::PARAM_STR);
        $stmt->bindParam("wkt", $wkt, PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone, PDO::PARAM_STR);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("website", $website, PDO::PARAM_STR);        
        $stmt->bindParam("facebook", $facebook, PDO::PARAM_STR);
        $stmt->bindParam("twitter", $twitter, PDO::PARAM_STR);
        $stmt->bindParam("instagram", $instagram, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function update($id, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram) 
    {
        $wkt = "POINT(".$lng." ".$lat.")";
        $query = "UPDATE stores SET name = :name, description = :description, type = :type, address = :address, postal_code = :postalCode, city = :city, country = :country, lng_lat = ST_GeomFromText(:wkt), phone = :phone, email = :email, website = :website, facebook = :facebook, twitter = :twitter, instagram = :instagram, update_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("type", $type, PDO::PARAM_STR);
        $stmt->bindParam("address", $address, PDO::PARAM_STR);
        $stmt->bindParam("postalCode", $postalCode, PDO::PARAM_STR);
        $stmt->bindParam("city", $city, PDO::PARAM_STR);
        $stmt->bindParam("country", $country, PDO::PARAM_STR);
        $stmt->bindParam("wkt", $wkt, PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone, PDO::PARAM_STR);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("website", $website, PDO::PARAM_STR);        
        $stmt->bindParam("facebook", $facebook, PDO::PARAM_STR);
        $stmt->bindParam("twitter", $twitter, PDO::PARAM_STR);
        $stmt->bindParam("instagram", $instagram, PDO::PARAM_STR);
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

    public function lastInsertId($name = null)
    {
        $id = $this->db->lastInsertId();
        return $id;
    }
}