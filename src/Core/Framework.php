<?php


namespace App\Core;


use App\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework
{
    /** @var UrlMatcherInterface $matcher */
    protected $matcher;
    /** @var ControllerResolverInterface $controllerResolver */
    protected $controllerResolver;
    /** @var ArgumentResolverInterface $argumentResolver */
    protected $argumentResolver;
    /** @var EventDispatcher $dispatcher */
    protected $dispatcher;

    /**
     * @param UrlMatcherInterface $matcher
     * @param ControllerResolverInterface $controllerResolver
     * @param ArgumentResolverInterface $argumentResolver
     * @param EventDispatcher $dispatcher
     */
    public function __construct(
        UrlMatcherInterface $matcher,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver,
        EventDispatcher $dispatcher
    )
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            // Only the controller associated with the matched route is instantiated.
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);
            // Run callable with arguments[]
            $response = call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $e) {
            $response = new Response('Page not found', 404);
        } catch (\Exception $e) {
            $response = new Response('Oops something is broken', 500);
        }

        // dispatch a response event
        $this->dispatcher->dispatch(new ResponseEvent($request, $response), 'response');
        return $response;
    }
}