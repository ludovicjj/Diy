<?php


namespace App\Controller;


use App\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordController
{
    public function index(Request $request)
    {
        if ($request->attributes->get('pwd') !== '123') {
            throw new AccessDeniedException(
                "Please provide a correct password",
                Response::HTTP_FORBIDDEN
            );
        }


        return new Response('Welcome to secret page');
    }
}