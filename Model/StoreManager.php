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
    public function findOneById($id)
    {
        $store = null;
        $query = "SELECT s.id, s.user_id, s.name, s.description, s.type, s.address, s.postal_code, s.city, s.country, ST_AsText(s.lng_lat) as wkt, s.phone, s.email, s.website, s.facebook, s.twitter, s.instagram, s.monday, s.tuesday, s.wednesday, s.thursday, s.friday, s.saturday, s.sunday,
                    (SELECT GROUP_CONCAT(pf.family_name SEPARATOR ', ') AS fn
                    FROM products_family pf
                    INNER JOIN stores_products_family spf ON spf.product_family_id = pf.id
                    WHERE spf.store_id = s.id
                    GROUP BY spf.store_id) AS family_name 
                FROM stores s
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
        $query = "SELECT s.id, s.user_id, s.name, s.description, s.type, s.address, s.postal_code, s.city, s.country, ST_AsText(s.lng_lat) as wkt, s.phone, s.email, s.website, s.facebook, s.twitter, s.instagram, s.monday, s.tuesday, s.wednesday, s.thursday, s.friday, s.saturday, s.sunday,
                    (SELECT GROUP_CONCAT(pf.family_name SEPARATOR ', ') AS fn
                    FROM products_family pf
                    INNER JOIN stores_products_family spf ON spf.product_family_id = pf.id
                    WHERE spf.store_id = s.id
                    GROUP BY spf.store_id) AS family_name 
                FROM stores s
                WHERE status = 'approuvé'
                ORDER BY s.creation_at DESC 
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
     * @return boolean
     */
    public function create($userId, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday)
    {
        $wkt = "POINT(".$lng." ".$lat.")";
        $query = "INSERT INTO stores(user_id, name, description, type, address, postal_code, city, country, lng_lat, phone, email, website, facebook, twitter, instagram, monday, tuesday, wednesday, thursday, friday, saturday, sunday, creation_at) VALUES (:userId, :name, :description, :type, :address, :postalCode, :city, :country, ST_GeomFromText(:wkt), :phone, :email, :website, :facebook, :twitter, :instagram, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday, NOW())";
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
        $stmt->bindParam("monday", $monday, PDO::PARAM_STR);
        $stmt->bindParam("tuesday", $tuesday, PDO::PARAM_STR);
        $stmt->bindParam("wednesday", $wednesday, PDO::PARAM_STR);
        $stmt->bindParam("thursday", $thursday, PDO::PARAM_STR);
        $stmt->bindParam("friday", $friday, PDO::PARAM_STR);
        $stmt->bindParam("saturday", $saturday, PDO::PARAM_STR);
        $stmt->bindParam("sunday", $sunday, PDO::PARAM_STR);
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
     * @return boolean
     */
    public function update($id, $name, $description, $type, $address, $postalCode, $city, $country, $lng, $lat, $phone, $email, $website, $facebook, $twitter, $instagram, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday) 
    {
        $wkt = "POINT(".$lng." ".$lat.")";
        $query = "UPDATE stores SET name = :name, description = :description, type = :type, address = :address, postal_code = :postalCode, city = :city, country = :country, lng_lat = ST_GeomFromText(:wkt), phone = :phone, email = :email, website = :website, facebook = :facebook, twitter = :twitter, instagram = :instagram, monday = :monday, tuesday = :tuesday, wednesday = :wednesday, thursday = :thursday, friday = :friday, saturday = :saturday, sunday = :sunday, update_at = NOW() WHERE id = :id";
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
        $stmt->bindParam("monday", $monday, PDO::PARAM_STR);
        $stmt->bindParam("tuesday", $tuesday, PDO::PARAM_STR);
        $stmt->bindParam("wednesday", $wednesday, PDO::PARAM_STR);
        $stmt->bindParam("thursday", $thursday, PDO::PARAM_STR);
        $stmt->bindParam("friday", $friday, PDO::PARAM_STR);
        $stmt->bindParam("saturday", $saturday, PDO::PARAM_STR);
        $stmt->bindParam("sunday", $sunday, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Supprime un point de vente
     *
     * @param [int] $id
     * @param [int] $userId
     * @return boolean
     */
    public function delete($id, $userId) 
    {
        $query = 'DELETE s.*
                FROM stores s
                WHERE id = :id 
                AND (
                    s.user_id = :userId
                    OR (
                        SELECT COUNT(*)
                        FROM users u
                        WHERE u.id = :userId
                        AND u.role = "admin"
                    ) > 0
                )';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->bindParam("userId", $userId, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Retourne l'identifiant de la dernière ligne insérée
     *
     * @return int
     */
    public function lastId()
    {
        $id = $this->db->lastInsertId();
        return $id;
    }
}