<?php


namespace Tests\Core;


use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheTest extends TestCase
{
    public function testIsCacheableWithSetTtl()
    {
        $response = new Response();
        $response->setTtl(10);
        $this->assertTrue($response->isCacheable());
    }

    public function testIsCacheable()
    {
        $response = new Response();
        $this->assertFalse($response->isCacheable());
    }

    public function testSetNotModified()
    {
        $response = new Response();
        $modified = $response->setNotModified();
        $this->assertEquals(304, $modified->getStatusCode());
    }

    public function testIsNotModified()
    {
        $response = new Response();
        $modified = $response->isNotModified(new Request());
        $this->assertFalse($modified);
    }
}