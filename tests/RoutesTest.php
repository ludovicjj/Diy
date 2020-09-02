<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouteCollection;

class RoutesTest extends TestCase
{
    public function testInstanceOf()
    {
        $routes = include __DIR__.'/../src/routes.php';
        $this->assertInstanceOf(RouteCollection::class, $routes);
    }

    public function testCount()
    {
        /** @var RouteCollection $routes */
        $routes = include __DIR__.'/../src/routes.php';
        $this->assertCount(3, $routes->all());
    }

    public function testArrayKey()
    {
        /** @var RouteCollection $routes */
        $routes = include __DIR__.'/../src/routes.php';
        $this->assertArrayHasKey('hello', $routes->all());
        $this->assertArrayHasKey('bye', $routes->all());
        $this->assertArrayHasKey('leap-year', $routes->all());
    }
}