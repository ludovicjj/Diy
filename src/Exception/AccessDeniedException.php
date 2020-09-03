<?php


namespace App\Exception;


use Throwable;

class AccessDeniedException extends \Exception
{
    private $statusCode;
    private $errorMessage;

    public function __construct(
        int $statusCode,
        string $errorMessage
    )
    {
        $this->statusCode = $statusCode;
        $this->errorMessage = $errorMessage;
        parent::__construct();
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}