<?php


namespace Tests\Core;


use App\Controller\LeapYearController;
use App\Core\Framework;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;

class FrameworkTest extends TestCase
{
    public function testNotFound(): void
    {
        $response = $this->initFrameworkWithError(new ResourceNotFoundException())->handle(new Request());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testExceptionHandling(): void
    {
        $response = $this->initFrameworkWithError(new \Exception())->handle(new Request());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testResponse(): void
    {
        $urlMatcher = $this->createMock(UrlMatcherInterface::class);
        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();

        $urlMatcher
            ->expects($this->once())
            ->method('getContext')
            ->willReturn($this->createMock(RequestContext::class));

        $urlMatcher
            ->expects($this->once())
            ->method('match')
            ->willReturn([
                "_route" => "/is-leap-year",
                "year" => "2020",
                "_controller" => [new LeapYearController(), 'index']
            ]);

        $framework = new Framework($urlMatcher, $controllerResolver, $argumentResolver);
        $response = $framework->handle(new Request());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Yep, this is a leap year!', $response->getContent());
    }

    /**
     * @param mixed $exception
     * @return Framework
     */
    private function initFrameworkWithError($exception)
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