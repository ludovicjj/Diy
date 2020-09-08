<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(Request $request): Response
    {
        ob_start();
        include __DIR__.'/../pages/home.html';
        $content = ob_get_clean();
        return new Response($content);
    }
}