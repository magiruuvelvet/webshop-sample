<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity = 0;

    /**
     * @ORM\OneToOne(targetEntity="Product", inversedBy="stock")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getProductId() : ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id) : self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getQuantity() : ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity) : self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct() : ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product) : self
    {
        $this->product = $product;

        return $this;
    }

    public function jsonSerialize() : array
    {
        return [
            "quantity" => $this->quantity,
        ];
    }
}
