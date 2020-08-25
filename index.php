<?php

require_once __DIR__. '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$request = Request::createFromGlobals();
$name = $request->query->get('name', 'World');
$content = sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));

$response = new Response();
$response->headers->set('Content-Type', 'text/html; charset=utf-8');
$response->setContent($content);
$response->send();