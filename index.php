<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$pathInfo = $request->getPathInfo();
$response = new Response();

$map = [
    '/hello' => 'hello.php',
    '/bye' => 'bye.php'
];

if (isset($map[$pathInfo])) {
    include __DIR__ . '/src/pages/' . $map[$pathInfo];
} else {
    $response
        ->setStatusCode(404)
        ->setContent('Not found');
}
$response->send();

