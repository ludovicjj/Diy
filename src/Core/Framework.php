<?php


namespace App\Core;


use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class Framework extends HttpKernel
{
    public function __construct($routes)
    {
        $context = new RequestContext();
        $matcher = new UrlMatcher($routes, $context);
        $requestStack = new RequestStack();

        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();


        $dispatcher = new EventDispatcher();

        $errorHandler = function (FlattenException $exception) {
            $msg = 'Something went wrong! ('.$exception->getMessage().')';

            return new Response($msg, $exception->getStatusCode());
        };

        $dispatcher->addSubscriber(new ErrorListener($errorHandler));
        $dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
        parent::__construct($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
    }
}