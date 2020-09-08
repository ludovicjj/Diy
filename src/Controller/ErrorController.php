<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
    public function exception(Request $request)
    {
        $exception = $request->attributes->get('exception');
        return new Response($exception->getMessage(), $exception->getStatusCode());
    }
}