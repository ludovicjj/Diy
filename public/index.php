<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

// Init request
$request = Request::createFromGlobals();
// Get RouteCollection
$routes = include __DIR__ . '/../src/routes.php';

$context = new RequestContext();
$context->fromRequest($request);
$urlMatcher = new UrlMatcher($routes, $context);

try {
    extract($urlMatcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    /**
     * @var $_route string
     * @noinspection PhpIncludeInspection
     */
    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
    $response = new Response(ob_get_clean());
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Page not found', 404);
} catch (Exception $exception) {
    $response = new Response('Oops something is broken', 500);
}

$response->send();

