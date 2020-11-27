<?php

namespace Model;

use PDO;
use Model\Database;

class TimetableManager extends Database 
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create($storeId, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday)
    {
        $query = "INSERT INTO timetables(store_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday) VALUES (:storeId, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("storeId", $storeId, PDO::PARAM_INT);
        $stmt->bindParam("monday", $monday, PDO::PARAM_STR);
        $stmt->bindParam("tuesday", $tuesday, PDO::PARAM_STR);
        $stmt->bindParam("wednesday", $wednesday, PDO::PARAM_STR);
        $stmt->bindParam("thursday", $thursday, PDO::PARAM_STR);
        $stmt->bindParam("friday", $friday, PDO::PARAM_STR);
        $stmt->bindParam("saturday", $saturday, PDO::PARAM_STR);
        $stmt->bindParam("sunday", $sunday, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
    }

    public function update($id, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday)
    {
        $query = "UPDATE timetables SET monday = :monday, tuesday = :tuesday, wednesday = :wednesday, thursday = :thursday, friday = :friday, saturday = :saturday, sunday = :sunday WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("monday", $monday, PDO::PARAM_STR);
        $stmt->bindParam("tuesday", $tuesday, PDO::PARAM_STR);
        $stmt->bindParam("wednesday", $wednesday, PDO::PARAM_STR);
        $stmt->bindParam("thursday", $thursday, PDO::PARAM_STR);
        $stmt->bindParam("friday", $friday, PDO::PARAM_STR);
        $stmt->bindParam("saturday", $saturday, PDO::PARAM_STR);
        $stmt->bindParam("sunday", $sunday, PDO::PARAM_STR);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function delete($id) 
    {
        $query = 'DELETE FROM timetables WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}