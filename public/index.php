<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;


// Init request
/** @var Request $request */
$request = Request::createFromGlobals();

// Get RouteCollection
/** @var RouteCollection $routes */
$routes = include __DIR__ . '/../src/routes.php';

$framework = new Framework($routes);
$framework->handle($request)->send();
