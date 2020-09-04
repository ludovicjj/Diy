<?php


namespace App\Core;


use App\Event\ExceptionEvent;
use App\Event\ResponseEvent;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework implements HttpKernelInterface
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
     * @param int $type
     * @param bool $catch
     * @return Response
     */
    public function handle(
        Request $request,
        $type = HttpKernelInterface::MASTER_REQUEST,
        $catch = true
    ): Response
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            // Only the controller associated with the matched route is instantiated.
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);
            // Run callable with arguments[]
            $response = call_user_func_array($controller, $arguments);

        } catch (Exception $e) {
            $response = new Response();
            // dispatch a exception event
            $this->dispatcher->dispatch(new ExceptionEvent($request, $response, $e), 'exception');
        }

        // dispatch a response event
        $this->dispatcher->dispatch(new ResponseEvent($request, $response), 'response');
        return $response;
    }
}