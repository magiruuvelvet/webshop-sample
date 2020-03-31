<?php

namespace App\Tests;

use App\Entity\Customer;
use App\Entity\CustomerAddress;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerTest extends KernelTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var int */
    private static $customer_id = null;

    /**
     * Test case setup
     */
    protected function setUp() : void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get("doctrine")
            ->getManager();
    }

    /**
     * Test case shutdown
     */
    protected function tearDown() : void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * Get customer by id from database
     */
    private function getCustomer(int $id) : ?Customer
    {
        return $this->entityManager
            ->getRepository(Customer::class)
            ->find($id);
    }

    /**
     * Test customer creation
     */
    public function testCreate() : void
    {
        $customer = new Customer();
        $customer->setFirstname("firstname");
        $customer->setLastname("lastname");
        $customer->setNumber("000000000000001");
        $customer->setEmail("firstname.lastname@example.com");
        $customer->setPassword("todosecurity");

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        self::$customer_id = $customer->getId();
        $customer = $this->getCustomer(self::$customer_id);

        $this->assertNotNull($customer);
        $this->assertTrue($customer->getId() == self::$customer_id);
        $this->assertTrue($customer->getFirstname() == "firstname");
        $this->assertTrue($customer->getLastname() == "lastname");
        $this->assertTrue($customer->getEmail() == "firstname.lastname@example.com");
        $this->assertTrue($customer->getPassword() == "todosecurity");
    }

    /**
     * Test customer updating
     *
     * @depends testCreate
     */
    public function testUpdate() : void
    {
        $customer = $this->getCustomer(self::$customer_id);
        $customer->setFirstname("newname");

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $this->assertNotNull($customer);
        $this->assertTrue($customer->getId() == self::$customer_id);
        $this->assertTrue($customer->getFirstname() == "newname");
        $this->assertTrue($customer->getLastname() == "lastname");
    }

    /**
     * Test customer deletion
     *
     * @depends testUpdate
     */
    public function testDelete() : void
    {
        $customer = $this->getCustomer(self::$customer_id);
        $this->assertNotNull($customer);

        $this->entityManager->remove($customer);
        $this->entityManager->flush();

        $customer = $this->getCustomer(self::$customer_id);

        $this->assertNull($customer);
    }
}
