<?php

namespace Model;

class StoresProductsFamily extends Model
{
    protected $id;
    protected $storeId;
    protected $productFamilyId;    

    /**
     * Constructor
     *
     * @param [object] $user
     */
    public function __construct($StoresProductsFamily) {
        $this->hydrate($StoresProductsFamily);
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
     * Get the value of productFamilyId
     */ 
    public function getProductFamilyId()
    {
        return $this->productFamilyId;
    }

    /**
     * Set the value of productFamilyId
     *
     * @return  self
     */ 
    public function setProductFamilyId($productFamilyId)
    {
        $this->productFamilyId = $productFamilyId;

        return $this;
    }
}