<?php


namespace App\Controller;


use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
    public function exception(FlattenException $exception)
    {
        $content = 'Something went wrong! ('.$exception->getMessage().')';
        return new Response($content, $exception->getStatusCode());
    }
}