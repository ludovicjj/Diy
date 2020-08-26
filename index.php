<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$pathInfo = $request->getPathInfo();
$response = new Response();

$map = [
    '/hello' => __DIR__ . '/src/pages/hello.php',
    '/bye' => __DIR__ . '/src/pages/bye.php'
];

if (isset($map[$pathInfo])) {
    ob_start();
    include $map[$pathInfo];
    $response->setContent(ob_get_clean());
} else {
    $response
        ->setStatusCode(404)
        ->setContent('Not found');
}
$response->send();

