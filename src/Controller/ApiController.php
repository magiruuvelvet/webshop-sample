<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    protected function getJSON(Request $request) : ?array
    {
        return json_decode($request->getContent(), true);
    }

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

    protected function getJSONValue(array &$data, string $value)
    {
        if (isset($data[$value]))
        {
            return $data[$value];
        }
        else
        {
            return null;
        }
    }
}
