<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

/**
 * @param string $year
 * @return bool
 */
function isLeapYear($year) {
    return ($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0;
}

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
            '_controller' => function (Request $request) {
                $year = $request->attributes->get('year') ?? date('Y');
                if (isLeapYear($year)) {
                    return new Response(
                        sprintf("yes %s, this is a leap year", $year)
                    );
                }
                return new Response(
                    sprintf("nop %s, this is not a leap year", $year)
                );
            }
        ]
    )
);

return $routes;