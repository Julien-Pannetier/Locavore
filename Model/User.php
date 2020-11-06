<?php

namespace Model;

class User extends Model
{
    protected $id;
    protected $role;
    protected $firstName;
    protected $lastName;
    protected $phone;    
    protected $email;
    protected $password;
    protected $registrationAt;
    protected $confirmationToken;
    protected $confirmationAt;
    protected $updateToken;
    protected $updateAt;

    /**
     * Constructor
     *
     * @param [type] $user
     */
    public function __construct($user) {
        $this->hydrate($user);
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
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

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
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of registrationAt
     */ 
    public function getRegistrationAt()
    {
        return $this->registrationAt;
    }

    /**
     * Set the value of registrationAt
     *
     * @return  self
     */ 
    public function setRegistrationAt($registrationAt)
    {
        $this->registrationAt = $registrationAt;

        return $this;
    }

    /**
     * Get the value of confirmationToken
     */ 
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set the value of confirmationToken
     *
     * @return  self
     */ 
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get the value of confirmationAt
     */ 
    public function getConfirmationAt()
    {
        return $this->confirmationAt;
    }

    /**
     * Set the value of confirmationAt
     *
     * @return  self
     */ 
    public function setConfirmationAt($confirmationAt)
    {
        $this->confirmationAt = $confirmationAt;

        return $this;
    }

    /**
     * Get the value of updateToken
     */ 
    public function getUpdateToken()
    {
        return $this->updateToken;
    }

    /**
     * Set the value of updateToken
     *
     * @return  self
     */ 
    public function setUpdateToken($updateToken)
    {
        $this->updateToken = $updateToken;

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