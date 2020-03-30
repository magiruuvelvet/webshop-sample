<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CustomerAddress", mappedBy="customer_id", orphanRemoval=true)
     */
    private $address_ids;

    public function __construct()
    {
        $this->address_ids = new ArrayCollection();
    }

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

    public function getFirstname() : ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname) : self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname() : ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname) : self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword() : ?string
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|CustomerAddress[]
     */
    public function getAddresses() : Collection
    {
        return $this->address_ids;
    }

    public function addAddress(CustomerAddress $address) : self
    {
        if (!$this->address_ids->contains($address))
        {
            $this->address_ids[] = $address;
            $address->setCustomerId($this);
        }

        return $this;
    }

    public function removeAddress(CustomerAddress $address) : self
    {
        if ($this->address_ids->contains($address))
        {
            $this->address_ids->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getCustomerId() === $this)
            {
                $address->setCustomerId(null);
            }
        }

        return $this;
    }
}
