<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Entity\Stock;

use App\Controller\ApiController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends ApiController
{
    /**
     * @Route("/api/products", methods={"POST"})
     */
    public function createProduct(Request $request) : Response
    {
        $data = $this->getJSON($request);
        if (!$data)
        {
            return $this->getJSONError("invalid product json");
        }

        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();

        try
        {
            $product->setNumber($this->getJSONValue($data, "number"));
            $product->setName($this->getJSONValue($data, "name"));
            $product->setPrice($this->getJSONValue($data, "price"));
            $entityManager->persist($product);
            $entityManager->flush();
        }
        catch (\Throwable $e)
        {
            return $this->getJSONError("invalid product json: {$e->getMessage()}");
        }

        $stock_data = $this->getJSONValue($data, "stock");
        if ($stock_data)
        {
            $stock = new Stock();

            try
            {
                $stock->setProduct($product);
                $product->setStock($stock);

                $stock->setQuantity($this->getJSONValue($stock_data, "quantity"));

                $entityManager->persist($stock);
                $entityManager->flush();
            }
            catch (\Throwable $e)
            {
                // TODO: report error
            }
        }

        return $this->getResponse($product);
    }

    /**
     * @Route("/api/products", methods={"GET"})
     */
    public function getProducts() : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class);
        $products = $products->findAll();

        return $this->getResponse($products);
    }

    /**
     * @Route("/api/products/{product_id}", methods={"GET"})
     */
    public function getProduct(int $product_id) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class);
        $product = $products->find($product_id);

        if ($product)
        {
            return $this->getResponse($product);
        }
        else
        {
            return $this->getJSONError("no such product with id: {$product_id}", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/api/products/{product_id}", methods={"PUT"})
     */
    public function updateProduct(Request $request, int $product_id) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class);

        /** @var Product|null */
        $product = $products->find($product_id);

        if (!$product)
        {
            return $this->getJSONError("no such product with id: {$product_id}", Response::HTTP_NOT_FOUND);
        }

        $data = $this->getJSON($request);
        if (!$data)
        {
            return $this->getJSONError("invalid product json");
        }

        foreach (["number", "name", "price"] as $property)
        {
            $this->setProperty($product, $property, $this->getJSONValue($data, $property));
        }

        $entityManager->persist($product);
        $entityManager->flush();

        $stock_data = $this->getJSONValue($data, "stock");
        if ($stock_data)
        {
            $stocks = $entityManager->getRepository(Stock::class);
            $stock = $stocks->findOneBy(["product_id" => $product->getId()]);

            if ($stock)
            {
                foreach (["quantity"] as $property)
                {
                    $this->setProperty($stock, $property, $this->getJSONValue($stock_data, $property));
                }
            }
            else
            {
                $stock = new Stock();

                try
                {
                    $stock->setProduct($product);
                    $product->setStock($stock);

                    $stock->setQuantity($this->getJSONValue($stock_data, "quantity"));
                }
                catch (\Throwable $e)
                {
                    // TODO: report error
                }
            }

            $entityManager->persist($stock);
            $entityManager->flush();
        }

        return $this->getResponse($product);
    }

    /**
     * @Route("/api/products/{product_id}", methods={"DELETE"})
     */
    public function deleteProduct(int $product_id) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class);
        $product = $products->find($product_id);

        if ($product)
        {
            $entityManager->remove($product);
            $entityManager->flush();

            return $this->getResponse([
                "status" => "deleted",
                "product" => $product,
            ]);
        }
        else
        {
            return $this->getJSONError("no such product with id: {$product_id}", Response::HTTP_NOT_FOUND);
        }
    }
}
