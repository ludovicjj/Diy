<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

$request = Request::createFromGlobals();
$response = new Response();
$routeCollection = require_once __DIR__ . '/../src/routes.php';
$pathInfo = $request->getPathInfo();

$context = new RequestContext();
$context->fromRequest($request);
$urlMatcher = new UrlMatcher($routeCollection, $context);


try {
    extract($urlMatcher->match($pathInfo), EXTR_SKIP);
    ob_start();
    /**
     * @var $_route string
     * @noinspection PhpIncludeInspection
     */
    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
    $response->setContent(ob_get_clean());
} catch (ResourceNotFoundException $exception) {
    $response
        ->setContent('Page not found')
        ->setStatusCode(404);
} catch (Exception $exception) {
    $response
        ->setContent('Oops something is broken')
        ->setStatusCode(500);
}

$response->send();

