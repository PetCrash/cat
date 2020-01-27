<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Categories", inversedBy="Products")
     * @ORM\JoinTable(name="products_categories")
     */
    private $categories;
    
    /**
     * @ORM\Column(type="integer", name="supplier_id")
     */
    private $supplierId;
    
    /**
     * @ORM\Column(type="string", length=255, name="supplier_reference")
     */
    private $supplierReference;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * @ORM\Column(type="float")
     */
    private $price;
    
    /**
     * @ORM\Column(type="string", length=255, name="date_update")
     */
    private $dateUpdate;
    
    /**
     * @ORM\Column(type="float")
     */
    private $height;
    
    /**
     * @ORM\Column(type="float")
     */
    private $width;
    
    /**
     * @ORM\Column(type="float")
     */
    private $length;
    
    public function __construct() {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function addCategories(Categories $category)
    {
        $this->categories[] = $category;
    }
 
    function getId() {
        return $this->id;
    }

    function getCategories() {
        return $this->categories;
    }

    function getSupplierId() {
        return $this->supplierId;
    }

    function getSupplierReference() {
        return $this->supplierReference;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getPrice() {
        return $this->price;
    }

    function getDateUpdate() {
        return $this->dateUpdate;
    }

    function getHeight() {
        return $this->height;
    }

    function getWidth() {
        return $this->width;
    }

    function getLength() {
        return $this->length;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCategories($categories) {
        $this->categories = $categories;
    }

    function setSupplierId($supplierId) {
        $this->supplierId = $supplierId;
    }

    function setSupplierReference($supplierReference) {
        $this->supplierReference = $supplierReference;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDateUpdate($dateUpdate) {
        $this->dateUpdate = $dateUpdate;
    }

    function setHeight($height) {
        $this->height = $height;
    }

    function setWidth($width) {
        $this->width = $width;
    }

    function setLength($length) {
        $this->length = $length;
    }

}
