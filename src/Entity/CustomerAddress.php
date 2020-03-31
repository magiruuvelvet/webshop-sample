<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerAddressRepository")
 * @ORM\Table(name="customer_addresses")
 */
class CustomerAddress
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
    private $customer_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone_number;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getCustomerId() : ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id) : self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getStreetName() : ?string
    {
        return $this->street_name;
    }

    public function setStreetName(string $street_name) : self
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function getStreetNumber() : ?string
    {
        return $this->street_number;
    }

    public function setStreetNumber(string $street_number) : self
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getPostalCode() : ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code) : self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity() : ?string
    {
        return $this->city;
    }

    public function setCity(string $city) : self
    {
        $this->city = $city;

        return $this;
    }

    public function getDistrict() : ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district) : self
    {
        $this->district = $district;

        return $this;
    }

    public function getCountry() : ?string
    {
        return $this->country;
    }

    public function setCountry(string $country) : self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhoneNumber() : ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number) : self
    {
        $this->phone_number = $phone_number;

        return $this;
    }
}
