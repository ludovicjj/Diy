<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();
$routes->add(
    'hello',
    new Route(
        '/hello/{name}',
        [
            'name' => 'World',
            '_controller' => 'defaultController'
        ]
    )
);
$routes->add(
    'bye',
    new Route(
        '/bye',
        [
            '_controller' => 'defaultController'
        ]
    )
);

return $routes;