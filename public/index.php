<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

$request = Request::createFromGlobals();
$response = new Response();

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'World']));
$routes->add('bye', new Route('/bye'));

$context = new RequestContext();
$context->fromRequest($request);
$urlMatcher = new UrlMatcher($routes, $context);

$pathInfo = $request->getPathInfo();

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

