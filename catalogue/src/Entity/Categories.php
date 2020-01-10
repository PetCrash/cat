<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Products", mappedBy="Categories")
     */
    private $products;

    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    function getId() {
        return $this->id;
    }

    function getProducts() {
        return $this->products;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProducts($products) {
        $this->products = $products;
    }

    function setName($name) {
        $this->name = $name;
    }
}

