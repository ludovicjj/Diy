<?php


namespace App\Event;


use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

class ExceptionEvent extends Event
{
    /** @var Request $request */
    private $request;

    /** @var Response $response */
    private $response;

    /** @var Exception $exception */
    private $exception;

    public function __construct(
        Request $request,
        Response $response,
        Exception $exception
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->exception = $exception;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getException(): Exception
    {
        return $this->exception;
    }

    /**
     * @param string|null $content
     * @param int $statusCode
     */
    public function setResponse(?string $content = null, int $statusCode = 400)
    {
        $this->response->setContent($content);
        $this->response->setStatusCode($statusCode);
    }
}