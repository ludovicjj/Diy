<?php


namespace App\Event;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

class ResponseEvent extends Event
{
    /** @var Request $request */
    protected $request;

    /** @var Response $response */
    protected $response;

    public function __construct(
        Request $request,
        Response $response
    )
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}