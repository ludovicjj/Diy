<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Framework;
use App\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\EventDispatcher\EventDispatcher;

// Init request
/** @var Request $request */
$request = Request::createFromGlobals();

// Get RouteCollection
/** @var RouteCollection $routes */
$routes = include __DIR__ . '/../src/routes.php';

$context = new RequestContext();
$urlMatcher = new UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$dispatcher->addListener('response', function (ResponseEvent $event) {
    $response = $event->getResponse();
    $headers = $response->headers;

    if (!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')) {
        $headers->set('Content-Length', strlen($response->getContent()));
    }
}, -255);
$dispatcher->addListener('response', function (ResponseEvent $event) {
    $response = $event->getResponse();
    $headers = $response->headers;

    if (
        $response->isRedirection()
        || ($headers->has('Content-Type') && strpos($headers->get('Content-Type'), 'html') === false)
        || $event->getRequest()->getRequestFormat() !== 'html'
    ) {
        return;
    }
    $response->setContent($response->getContent().' GA CODE');
});

$framework = new Framework($urlMatcher, $controllerResolver, $argumentResolver, $dispatcher);
$response = $framework->handle($request);
$response->send();
