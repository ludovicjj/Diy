<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Framework;
use App\Subscriber\ExceptionSubscriber;
use App\Subscriber\ContentLengthSubscriber;
use App\Subscriber\GoogleSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
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

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();
$dispatcher = new EventDispatcher();

// Add Listener
$dispatcher->addSubscriber(new ContentLengthSubscriber());
$dispatcher->addSubscriber(new GoogleSubscriber());
$dispatcher->addSubscriber(new ExceptionSubscriber());

$framework = new Framework($urlMatcher, $controllerResolver, $argumentResolver, $dispatcher);
$framework = new HttpCache($framework, new Store(__DIR__.'/../cache'));
$framework->handle($request)->send();

