<?php


namespace App\Exception;


use Throwable;

class AccessDeniedException extends \Exception
{
    private $statusCode;
    protected $message;

    public function __construct(
        string $message,
        int $statusCode
    )
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}