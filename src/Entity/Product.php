<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity="Stock", mappedBy="product", orphanRemoval=true)
     */
    private $stock;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getNumber() : ?string
    {
        return $this->number;
    }

    public function setNumber(string $number) : self
    {
        $this->number = $number;

        return $this;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice() : ?string
    {
        return $this->price;
    }

    public function setPrice(string $price) : self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock() : ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock) : self
    {
        $this->stock = $stock;

        return $this;
    }

    public function jsonSerialize() : array
    {
        return [
            "id" => $this->id,
            "number" => $this->number,
            "name" => $this->name,
            "price" => $this->price,
            "stock" => $this->stock,
        ];
    }
}
