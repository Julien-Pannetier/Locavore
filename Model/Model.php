<?php

namespace Model;

use Model\Database;

class Model extends Database 
{
    protected $table;

    private $database;


    public function findAll()
    {
        $query = $this->query('SELECT * FROM '. $this->table);
        return $query->fetchAll();
    }


    public function findBy(array $criteria)
    {
        $fields = [];
        $values = [];

        foreach($criteria as $field => $value){
            $fields[] = "$field = ?";
            $values[] = $value;
        }
        
        $fields_list = implode(' AND ', $fields);
        return $this->query('SELECT * FROM '.$this->table.' WHERE '.$fields_list, $values)->fetchAll();
    }


    public function find(int $id)
    {
        return $this->query("SELECT * FROM $this->table WHERE id = $id")->fetch();
    }


    public function create(Model $model)
    {
        $fields = [];
        $interrogation_point = [];
        $values = [];
        

        foreach($model as $field => $value){
            if($value !== null && $field != 'database' && $field !='table'){
                $fields[] = $field;
                $interrogation_point [] = "?";
                $values[] = $value;
            }
        }
        
        $fields_list = implode(', ', $fields);
        $interrogation_point_list = implode(', ', $interrogation_point);
        return $this->query('INSERT INTO '.$this->table.' ('.$fields_list.') VALUES ('.$interrogation_point_list.') ', $values);
    }


    public function update(int $id, Model $model)
    {
        $fields = [];
        $values = [];

        foreach($model as $field => $value){
            if($value !== null && $field != 'database' && $field !='table'){
                $fields[] = "$field = ?";
                $values[] = $value;
            }
        }

        $values[] = $id;
        $fields_list = implode(', ', $fields);
        return $this->query('UPDATE '.$this->table.' SET '.$fields_list.' WHERE id = ?', $values);
    }


    public function delete(int $id)
    {
        return $this->query('DELETE FROM '.$this->table.' WHERE id = ?', [$id]);
    }


    public function query(string $sql, array $attributs = null)
    {
        $this->database = Database::getInstance();

        if($attributs !== null){
            $query = $this->database->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            return $this->database->query($sql);
        }
    }


    public function hydrate(array $data) 
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);          
            $method = ucwords("$method", "_");          
            $method = str_replace("_", "", $method);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}