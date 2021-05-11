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

    /**
     * Récupère un point de vente en fonction de son identifiant
     *
     * @param [int] $id
     * @return object
     */
    public function findOneById(int $id)
    {
        $store = null;
        $query = "SELECT id, user_id, name, description, type, products, address, postal_code, city, country, ST_AsText(lng_lat) as lng_lat, phone, email, website, facebook, twitter, instagram, monday, tuesday, wednesday, thursday, friday, saturday, sunday, status
                FROM stores
                WHERE id = :id";
        $req = $this->db->prepare($query);
        $req->bindParam("id", $id, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $store = new Store($data);
        }
        return $store;
    }

    /**
     * Récupère tous les points de vente
     *
     * @param [int] $offset
     * @param [int] $limit
     * @return object
     */
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

    /**
     * Récupère tous les points de vente d'un utilisateur
     *
     * @param [int] $userId
     * @param [int] $offset
     * @param [int] $limit
     * @return object
     */
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

    /**
     * Récupère tous les points de vente en fonction du statut du point de vente
     *
     * @param [string] $status
     * @param [int] $offset
     * @param [int] $limit
     * @return object
     */
    public function findAllByStatus($status, $offset, $limit)
    {
        $stores = [];
        $query = 'SELECT * FROM stores WHERE status = :status ORDER BY creation_at DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
        $req->bindParam("status", $status, PDO::PARAM_STR);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $stores[] = new Store($data);
        }
        return $stores;
    }

    /**
     * Récupère tous les points de vente d'un utilisateur en fonction du statut du point de vente
     *
     * @param [int] $userId
     * @param [string] $status
     * @param [int] $offset
     * @param [int] $limit
     * @return object
     */
    public function findAllByUserIdAndStatus($userId, $status, $offset, $limit)
    {
        $stores = [];
        $query = 'SELECT * FROM stores WHERE user_id = :userId AND status = :status ORDER BY creation_at DESC LIMIT :offset, :limit';
        $req = $this->db->prepare($query);
        $req->bindParam("userId", $userId, PDO::PARAM_INT);
        $req->bindParam("status", $status, PDO::PARAM_STR);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $stores[] = new Store($data);
        }
        return $stores;
    }

    /**
     * Récupère les points de vente approuvés par un administrateur
     *
     * @param [int] $offset
     * @param [int] $limit
     * @return object
     */
    public function findAllAjax($offset, $limit)
    {
        $stores = [];
        $query = "SELECT id, user_id, name, description, type, products, address, postal_code, city, country, ST_AsText(lng_lat) as lng_lat, phone, email, website, facebook, twitter, instagram, monday, tuesday, wednesday, thursday, friday, saturday, sunday
                FROM stores
                WHERE status = 'approuvé'
                ORDER BY creation_at DESC 
                LIMIT :offset, :limit";
        $req = $this->db->prepare($query);
        $req->bindParam("offset", $offset, PDO::PARAM_INT);
        $req->bindParam("limit", $limit, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch()) {
            $stores[] = $data;
        }
        return $stores;
    }

    /**
     * Crée un nouveau point de vente
     *
     * @param [id] $userId
     * @param [string] $name
     * @param [string] $description
     * @param [string] $type
     * @param [string] $products
     * @param [string] $address
     * @param [string] $postalCode
     * @param [string] $city
     * @param [string] $country
     * @param [string] $lng
     * @param [string] $lat
     * @param [string] $phone
     * @param [string] $email
     * @param [string] $website
     * @param [string] $facebook
     * @param [string] $twitter
     * @param [string] $instagram
     * @param [string] $monday
     * @param [string] $tuesday
     * @param [string] $wednesday
     * @param [string] $thursday
     * @param [string] $friday
     * @param [string] $saturday
     * @param [string] $sunday
     * @param [string] $status
     * @return boolean
     */
    public function create($userId, $name, $description, $type, $products, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $status)
    {
        $wkt = "POINT(".$lng." ".$lat.")";
        $query = "INSERT INTO stores(user_id, name, description, type, products, address, postal_code, city, country, lng_lat, phone, email, website, facebook, twitter, instagram, monday, tuesday, wednesday, thursday, friday, saturday, sunday, status, creation_at) VALUES (:userId, :name, :description, :type, :products, :address, :postalCode, :city, :country, ST_GeomFromText(:wkt), :phone, :email, :website, :facebook, :twitter, :instagram, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday, :status, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("userId", $userId, PDO::PARAM_INT);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("type", $type, PDO::PARAM_STR);
        $stmt->bindParam("products", $products, PDO::PARAM_STR);
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
        $stmt->bindParam("monday", $monday, PDO::PARAM_STR);
        $stmt->bindParam("tuesday", $tuesday, PDO::PARAM_STR);
        $stmt->bindParam("wednesday", $wednesday, PDO::PARAM_STR);
        $stmt->bindParam("thursday", $thursday, PDO::PARAM_STR);
        $stmt->bindParam("friday", $friday, PDO::PARAM_STR);
        $stmt->bindParam("saturday", $saturday, PDO::PARAM_STR);
        $stmt->bindParam("sunday", $sunday, PDO::PARAM_STR);
        $stmt->bindParam("status", $status, PDO::PARAM_STR);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Modifie un point de vente
     *
     * @param [int] $id
     * @param [string] $name
     * @param [string] $description
     * @param [string] $type
     * @param [string] $products
     * @param [string] $address
     * @param [string] $postalCode
     * @param [string] $city
     * @param [string] $country
     * @param [string] $lng
     * @param [string] $lat
     * @param [string] $phone
     * @param [string] $email
     * @param [string] $website
     * @param [string] $facebook
     * @param [string] $twitter
     * @param [string] $instagram
     * @param [string] $monday
     * @param [string] $tuesday
     * @param [string] $wednesday
     * @param [string] $thursday
     * @param [string] $friday
     * @param [string] $saturday
     * @param [string] $sunday
     * @param [string] $status
     * @return boolean
     */
    public function update($id, $name, $description, $type, $products, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $status) 
    {
        $wkt = "POINT(".$lng." ".$lat.")";
        $query = "UPDATE stores SET name = :name, description = :description, type = :type, products = :products, address = :address, postal_code = :postalCode, city = :city, country = :country, lng_lat = ST_GeomFromText(:wkt), phone = :phone, email = :email, website = :website, facebook = :facebook, twitter = :twitter, instagram = :instagram, monday = :monday, tuesday = :tuesday, wednesday = :wednesday, thursday = :thursday, friday = :friday, saturday = :saturday, sunday = :sunday, status = :status, update_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("name", $name, PDO::PARAM_STR);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("type", $type, PDO::PARAM_STR);
        $stmt->bindParam("products", $products, PDO::PARAM_STR);
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
        $stmt->bindParam("monday", $monday, PDO::PARAM_STR);
        $stmt->bindParam("tuesday", $tuesday, PDO::PARAM_STR);
        $stmt->bindParam("wednesday", $wednesday, PDO::PARAM_STR);
        $stmt->bindParam("thursday", $thursday, PDO::PARAM_STR);
        $stmt->bindParam("friday", $friday, PDO::PARAM_STR);
        $stmt->bindParam("saturday", $saturday, PDO::PARAM_STR);
        $stmt->bindParam("sunday", $sunday, PDO::PARAM_STR);
        $stmt->bindParam("status", $status, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Supprime un point de vente
     *
     * @param [int] $id
     * @return boolean
     */
    public function delete(int $id)
    {
        $query = 'DELETE FROM stores WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }
}