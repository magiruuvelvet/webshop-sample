<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    /**
     * Decodes the JSON request into a PHP array.
     */
    protected function getJSON(Request $request) : ?array
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * Builds a JSON response for the API.
     *
     * @param mixed $object
     */
    protected function getResponse($object) : Response
    {
        return Response::create(json_encode($object), 200, [
            "Content-Type" => "application/json",
        ]);
    }

    /**
     * Builds a JSON error response for the API.
     */
    protected function getJSONError(string $error, int $status = Response::HTTP_BAD_REQUEST) : Response
    {
        return Response::create(json_encode([
            "status" => $status,
            "error" => $error,
        ]),
        $status,
        [
            "Content-Type" => "application/json",
        ]);
    }

    /**
     * Returns the value for the given key or `null` if the key
     * was not found.
     *
     * @return mixed
     */
    protected function getJSONValue(array &$data, string $key)
    {
        if (isset($data[$key]))
        {
            return $data[$key];
        }
        else
        {
            return null;
        }
    }

    /**
     * @param mixed $object
     * @param mixed $value
     */
    protected function setProperty(&$object, string $name, $value) : void
    {
        if (is_null($value))
        {
            return;
        }

        $reflection = new \ReflectionClass($object);

        try
        {
            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $property->setValue($object, $value);
        }
        catch (\Throwable $e)
        {
            // ignore
        }
    }
}
