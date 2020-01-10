<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagesRepository")
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Products", mappedBy="Images")
     */
    private $products;

    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $route;
    
    function getIdImage() {
        return $this->idImage;
    }

    function getRoute() {
        return $this->route;
    }

    function setIdImage($idImage) {
        $this->idImage = $idImage;
    }

    function setRoute($route) {
        $this->route = $route;
    }
}

