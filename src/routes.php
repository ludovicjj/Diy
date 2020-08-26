<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routeCollection = new RouteCollection();
$routeCollection->add('hello', new Route('/hello/{name}', ['name' => 'World']));
$routeCollection->add('bye', new Route('/bye'));

return $routeCollection;