<?php

namespace Model;

class Timetable extends Model
{
    protected $id;
    protected $storeId;
    protected $monday;
    protected $tuesday;
    protected $wednesday;
    protected $thursday;
    protected $friday;
    protected $saturday;
    protected $sunday;
    
    /**
     * Constructor
     *
     * @param [type] $timetable
     */
    public function __construct($timetable) {
        $this->hydrate($timetable);
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of storeId
     */ 
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Set the value of storeId
     *
     * @return  self
     */ 
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * Get the value of monday
     */ 
    public function getMonday()
    {
        return $this->monday;
    }

    /**
     * Set the value of monday
     *
     * @return  self
     */ 
    public function setMonday($monday)
    {
        $this->monday = $monday;

        return $this;
    }

    /**
     * Get the value of tuesday
     */ 
    public function getTuesday()
    {
        return $this->tuesday;
    }

    /**
     * Set the value of tuesday
     *
     * @return  self
     */ 
    public function setTuesday($tuesday)
    {
        $this->tuesday = $tuesday;

        return $this;
    }

    /**
     * Get the value of wednesday
     */ 
    public function getWednesday()
    {
        return $this->wednesday;
    }

    /**
     * Set the value of wednesday
     *
     * @return  self
     */ 
    public function setWednesday($wednesday)
    {
        $this->wednesday = $wednesday;

        return $this;
    }

    /**
     * Get the value of thursday
     */ 
    public function getThursday()
    {
        return $this->thursday;
    }

    /**
     * Set the value of thursday
     *
     * @return  self
     */ 
    public function setThursday($thursday)
    {
        $this->thursday = $thursday;

        return $this;
    }

    /**
     * Get the value of friday
     */ 
    public function getFriday()
    {
        return $this->friday;
    }

    /**
     * Set the value of friday
     *
     * @return  self
     */ 
    public function setFriday($friday)
    {
        $this->friday = $friday;

        return $this;
    }

    /**
     * Get the value of saturday
     */ 
    public function getSaturday()
    {
        return $this->saturday;
    }

    /**
     * Set the value of saturday
     *
     * @return  self
     */ 
    public function setSaturday($saturday)
    {
        $this->saturday = $saturday;

        return $this;
    }

    /**
     * Get the value of sunday
     */ 
    public function getSunday()
    {
        return $this->sunday;
    }

    /**
     * Set the value of sunday
     *
     * @return  self
     */ 
    public function setSunday($sunday)
    {
        $this->sunday = $sunday;

        return $this;
    }
}