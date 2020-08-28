<?php

use App\Controller\LeapYearController;
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

$routes->add(
    'leap-year',
    new Route(
        '/is-leap-year/{year}',
        [
            'year' => null,
            '_controller' => [new LeapYearController(), 'index']
        ]
    )
);

return $routes;