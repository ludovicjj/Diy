<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

/** @var RouteCollection $routes */
$routes = include __DIR__ . '/../src/routes.php';
/** @var ContainerBuilder $container */
$container = include __DIR__ . '/../src/container.php';

// Init request
/** @var Request $request */
$request = Request::createFromGlobals();

/** @var Response $response */
$response = $container->get('framework')->handle($request);
$response->send();

