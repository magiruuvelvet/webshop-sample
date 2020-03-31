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

    protected function getJSONError(string $error) : Response
    {
        return Response::create(json_encode([
            "status" => Response::HTTP_BAD_REQUEST,
            "error" => $error,
        ]),
        Response::HTTP_BAD_REQUEST,
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
