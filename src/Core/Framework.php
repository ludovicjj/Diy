<?php


namespace App\Core;


use App\Subscriber\ExceptionSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
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

        // subscriber
        $dispatcher->addSubscriber(new ErrorListener('App\Controller\ErrorController::exception'));
        $dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
        $dispatcher->addSubscriber(new ResponseListener('UTF-8'));
        // Custom subscriber
        $dispatcher->addSubscriber(new ExceptionSubscriber());

        // test listener
        //$dispatcher->addListener('response', [new GoogleListener(), 'onResponse']);

        // 1. Plus d'access au dispatcher en dehors du cadre.
        // 2. Plus d'access a la request ou la response dans le cadre.
        // 3. Plus difficile a tester
        // 4. Plus difficile de dispatcher des vent en dehors du cadre

        parent::__construct($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
    }
}