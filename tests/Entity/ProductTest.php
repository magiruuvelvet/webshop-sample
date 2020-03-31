<?php

namespace App\Tests;

use App\Entity\Product;
use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var int */
    private static $product_id = null;

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
     * Get product by id from database
     */
    private function getProduct(int $id) : ?Product
    {
        return $this->entityManager
            ->getRepository(Product::class)
            ->find($id);
    }

    /**
     * Get stock by id from database
     */
    private function getStock(int $id) : ?Stock
    {
        return $this->entityManager
            ->getRepository(Stock::class)
            ->find($id);
    }

    /**
     * Test product creation
     */
    public function testCreate() : void
    {
        $product = new Product();
        $product->setName("Laptop");
        $product->setNumber("0000-0000000");
        $product->setPrice("4200");

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $stock = new Stock();
        $stock->setQuantity(30);
        $stock->setProduct($product);

        $this->entityManager->persist($stock);
        $this->entityManager->flush();

        self::$product_id = $product->getId();
        $product = $this->getProduct(self::$product_id);

        $stock = $this->getStock($stock->getId());

        $this->assertNotNull($product);
        $this->assertTrue($product->getId() == self::$product_id);
        $this->assertTrue($product->getName() == "Laptop");
        $this->assertTrue($product->getNumber() == "0000-0000000");
        $this->assertTrue($product->getPrice() == "4200");

        $this->assertTrue($stock->getQuantity() == 30);
        $this->assertTrue($stock->getProduct()->getName() == "Laptop");
    }

    /**
     * Test product updating
     *
     * @depends testCreate
     */
    public function testUpdate() : void
    {
        $product = $this->getProduct(self::$product_id);
        $product->setPrice("4100");

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->assertNotNull($product);
        $this->assertTrue($product->getId() == self::$product_id);
        $this->assertTrue($product->getName() == "Laptop");
        $this->assertTrue($product->getNumber() == "0000-0000000");
        $this->assertTrue($product->getPrice() == "4100");
    }

    /**
     * Test product deletion
     *
     * @depends testUpdate
     */
    public function testDelete() : void
    {
        $product = $this->getProduct(self::$product_id);
        $this->assertNotNull($product);

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        $product = $this->getProduct(self::$product_id);

        $this->assertNull($product);
    }
}
