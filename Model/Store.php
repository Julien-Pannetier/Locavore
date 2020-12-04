<?php

namespace Model;

class Store extends Model
{
    protected $id;
    protected $userId;
    protected $name;
    protected $description;
    protected $type;
    protected $address;
    protected $postalCode;
    protected $city;
    protected $country;
    protected $lngLat;
    protected $phone;
    protected $email;
    protected $website;
    protected $facebook;
    protected $twitter;
    protected $instagram;
    protected $monday;
    protected $tuesday;
    protected $wednesday;
    protected $thursday;
    protected $friday;
    protected $saturday;
    protected $sunday;
    protected $status;
    protected $creationAt;
    protected $updateAt;

    /**
     * Constructor
     *
     * @param [type] $store
     */
    public function __construct($store) {
        $this->hydrate($store);
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
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of postalCode
     */ 
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set the value of postalCode
     *
     * @return  self
     */ 
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of latLong
     */ 
    public function getLngLat()
    {
        return $this->lngLat;
    }

    /**
     * Set the value of latLong
     *
     * @return  self
     */ 
    public function setLngLat($lngLat)
    {
        $this->lngLat = $lngLat;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of website
     */ 
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set the value of website
     *
     * @return  self
     */ 
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get the value of facebook
     */ 
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set the value of facebook
     *
     * @return  self
     */ 
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get the value of twitter
     */ 
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set the value of twitter
     *
     * @return  self
     */ 
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get the value of instagram
     */ 
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set the value of instagram
     *
     * @return  self
     */ 
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

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

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of creationAt
     */ 
    public function getCreationAt()
    {
        return $this->creationAt;
    }

    /**
     * Set the value of creationAt
     *
     * @return  self
     */ 
    public function setCreationAt($creationAt)
    {
        $this->creationAt = $creationAt;

        return $this;
    }

    /**
     * Get the value of updateAt
     */ 
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set the value of updateAt
     *
     * @return  self
     */ 
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}