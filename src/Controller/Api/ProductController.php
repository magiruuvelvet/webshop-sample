<?php

namespace App\Controller\Api;

use App\Entity\Product;

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

        $product = new Product();

        try
        {
            $product->setNumber($this->getJSONValue($data, "number"));
            $product->setName($this->getJSONValue($data, "name"));
            $product->setPrice($this->getJSONValue($data, "price"));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
        }
        catch (\Throwable $e)
        {
            return $this->getJSONError("invalid product json: {$e->getMessage()}");
        }

        return Response::create($product->toJson(), 200, [
            "Content-Type" => "application/json",
        ]);
    }

    /**
     * @Route("/api/products", methods={"GET"})
     */
    public function getProducts() : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class);
        $products = $products->findAll();

        return Response::create(Product::toJsonArray($products), 200, [
            "Content-Type" => "application/json",
        ]);
    }
}