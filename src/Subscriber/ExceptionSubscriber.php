<?php


namespace App\Subscriber;


use App\Event\ExceptionEvent;
use App\Exception\AccessDeniedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return ['exception' => 'onProcessException'];
    }

    public function onProcessException(ExceptionEvent $event)
    {
        switch (get_class($event->getException())) {
            case AccessDeniedException::class:
                $this->onAccessDeniedException($event);
                break;
            case ResourceNotFoundException::class:
                $this->onResourceNotFoundException($event);
                break;
            default:
                $this->onDefaultException($event);
        }
    }

    private function onAccessDeniedException(ExceptionEvent $event)
    {
        /** @var AccessDeniedException $exception */
        $exception = $event->getException();
        $event->setResponse($exception->getErrorMessage(), $exception->getStatusCode());
    }

    private function onResourceNotFoundException(ExceptionEvent $event)
    {
        /** @var ResourceNotFoundException $exception */
        $exception = $event->getException();
        $event->setResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);
    }

    private function onDefaultException(ExceptionEvent $event)
    {
        $event->setResponse('Oops something is broken', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
