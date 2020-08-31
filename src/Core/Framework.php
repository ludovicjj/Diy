<?php


namespace App\Core;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Framework
{
    /** @var UrlMatcher $matcher */
    protected $matcher;
    /** @var ControllerResolver $controllerResolver */
    protected $controllerResolver;
    /** @var ArgumentResolver $argumentResolver */
    protected $argumentResolver;

    /**
     * @param UrlMatcher $matcher
     * @param ControllerResolver $controllerResolver
     * @param ArgumentResolver $argumentResolver
     */
    public function __construct(
        UrlMatcher $matcher,
        ControllerResolver $controllerResolver,
        ArgumentResolver $argumentResolver
    )
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
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

        return $response;
    }
}