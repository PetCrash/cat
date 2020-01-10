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
     * @ORM\ManyToMany(targetEntity="Images", inversedBy="Products")
     * @ORM\JoinTable(name="products_images")
     */
    private $images;
    
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

    function getEntities() {
        return $this->entities;
    }

    function getImages() {
        return $this->images;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getCategories() {
        return $this->categories;
    }

    function getPrice() {
        return $this->price;
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

    function setEntities($entities) {
        $this->entities = $entities;
    }

    function setImages($images) {
        $this->images = $images;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCategories($categories) {
        $this->categories = $categories;
    }

    function setPrice($price) {
        $this->price = $price;
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
