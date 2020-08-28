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
            '_controller' => 'App\Controller\DefaultController'
        ]
    )
);
$routes->add(
    'bye',
    new Route(
        '/bye',
        [
            '_controller' => 'App\Controller\DefaultController'
        ]
    )
);

$routes->add(
    'leap-year',
    new Route(
        '/is-leap-year/{year}',
        [
            'year' => null,
            '_controller' => 'App\Controller\LeapYearController::index'
        ]
    )
);

return $routes;