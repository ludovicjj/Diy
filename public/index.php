<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouteCollection;

// Init request
/** @var Request $request */
$request = Request::createFromGlobals();

// Get RouteCollection
/** @var RouteCollection $routes */
$routes = include __DIR__ . '/../src/routes.php';

$context = new RequestContext();
$context->fromRequest($request);
$urlMatcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();


try {
    // Hydrate ParameterBag with associative array
    $request->attributes->add($urlMatcher->match($request->getPathInfo()));

    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);

    // Run callback with hydrated request
    $response = call_user_func_array($controller, $arguments);

} catch (ResourceNotFoundException $e) {
    $response = new Response('Page not found', 404);
} catch (Exception $e) {
    $response = new Response('Oops something is broken', 500);
}
$response->send();
