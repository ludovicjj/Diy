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
        $urlMatcher = $this->createMock(UrlMatcherInterface::class);
        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);
        $framework = new Framework($urlMatcher, $controllerResolver, $argumentResolver);

        $urlMatcher
            ->expects($this->once())
            ->method('getContext')
            ->willReturn($this->createMock(RequestContext::class));

        $urlMatcher
            ->expects($this->once())
            ->method('match')
            ->willThrowException(new ResourceNotFoundException());

        $response = $framework->handle(new Request());
        $this->assertEquals(404, $response->getStatusCode());
    }
}