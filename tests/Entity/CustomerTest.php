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
     * Get customer address by id from database
     */
    private function getCustomerAddress(int $id) : ?CustomerAddress
    {
        return $this->entityManager
            ->getRepository(CustomerAddress::class)
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
     * Test customer address creation and deletion
     * Deletion should be automatic by doctrine due to orphan removal
     */
    public function testAddress() : void
    {
        $customer = $this->getCustomer(self::$customer_id);
        $address = new CustomerAddress();
        $address->setStreetName("some street");
        $address->setStreetNumber("1");
        $address->setPostalCode("1234");
        $address->setCity("somewhere");
        $address->setCountry("--");
        $address->setPhoneNumber("0123456789");
        $customer->addAddress($address);
        $this->entityManager->persist($address);
        $this->entityManager->flush();

        $address = $this->getCustomerAddress($address->getId());
        $this->assertTrue($address->getStreetName() == "some street");
        $this->assertTrue($address->getStreetNumber() == "1");
        $this->assertTrue($address->getPostalCode() == "1234");
        $this->assertTrue($address->getCity() == "somewhere");
        $this->assertTrue($address->getDistrict() == null);
        $this->assertTrue($address->getCountry() == "--");
        $this->assertTrue($address->getPhoneNumber() == "0123456789");

        $this->assertTrue($customer->getAddresses()->first()->getStreetName() == "some street");

        $this->assertTrue($address->getCustomer()->getFirstname() == "firstname");
    }

    /**
     * Test customer updating
     *
     * @depends testCreate
     * @depends testAddress
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
     * @depends testAddress
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
