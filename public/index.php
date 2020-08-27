<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @param Request $request
 * @return Response
 */
function defaultController(Request $request): Response {
    $params = $request->attributes->all();
    extract($params);
    ob_start();
    /**
     * @var $_route string
     * @noinspection PhpIncludeInspection
     */
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);
    return new Response(ob_get_clean());
}

// Init request
$request = Request::createFromGlobals();
// Get RouteCollection
$routes = include __DIR__ . '/../src/routes.php';

$context = new RequestContext();
$context->fromRequest($request);
$urlMatcher = new UrlMatcher($routes, $context);

try {
    // Hydrate ParameterBag with associative array
    $request->attributes->add($urlMatcher->match($request->getPathInfo()));
    // Run callback with hydrated request
    $response = call_user_func($request->attributes->get('_controller'), $request);

} catch (ResourceNotFoundException $e) {
    $response = new Response('Page not found', 404);
} catch (Exception $e) {
    $response = new Response('Oops something is broken', 500);
}
$response->send();
