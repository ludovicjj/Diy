<?php


namespace App\Core;


use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
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
        $dispatcher->addSubscriber(new ErrorListener(
            'App\Controller\ErrorController::exception'
        ));
        $dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
        parent::__construct($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
    }
}