<?php


namespace Tests;


use App\Core\Framework;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;

class FrameworkTest extends TestCase
{
    public function testNotFound()
    {
        $response = $this->initFrameworkError(new ResourceNotFoundException())->handle(new Request());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testExceptionHandling()
    {
        $response = $this->initFrameworkError(new \Exception())->handle(new Request());
        $this->assertEquals(500, $response->getStatusCode());
    }

    /**
     * @param mixed $exception
     * @return Framework
     */
    private function initFrameworkError($exception)
    {
        $urlMatcher = $this->createMock(UrlMatcherInterface::class);
        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);

        $urlMatcher
            ->expects($this->once())
            ->method('getContext')
            ->willReturn($this->createMock(RequestContext::class));

        $urlMatcher
            ->expects($this->once())
            ->method('match')
            ->willThrowException($exception);

        return new Framework($urlMatcher, $controllerResolver, $argumentResolver);
    }
}