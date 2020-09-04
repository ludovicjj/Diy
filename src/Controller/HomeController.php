<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(Request $request)
    {
        $response = new Response("Home Page! ");
        $response
            ->setPublic()
            ->setEtag(md5($response->getContent()));
        return $response;
    }
}