<?php

namespace Model;

use PDO;
use Model\Database;

class StoresProductsFamilyManager extends Database 
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Crée une nouvelle liaison entre la table stores et la table products_family
     *
     * @param [int] $storeId
     * @param [int] $productFamilyId
     * @return boolean
     */
    public function create($storeId, $productFamilyId)
    {
        $query = 'INSERT INTO stores_products_family(store_id, product_family_id) VALUES (:storeId, :productFamilyId)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("storeId", $storeId, PDO::PARAM_INT);
        $stmt->bindParam("productFamilyId", $productFamilyId, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }

    /**
     * Supprime les liaisons entre la table stores et la table products_family en fonction de l'id du point de vente 
     *
     * @param [int] $storeId
     * @return boolean
     */
    public function delete($storeId)
    {
        $query = 'DELETE FROM stores_products_family WHERE store_id = :storeId';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("storeId", $storeId, PDO::PARAM_INT);
        $isSuccess = $stmt->execute();
        return $isSuccess;
    }
}