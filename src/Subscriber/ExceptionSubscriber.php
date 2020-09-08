<?php


namespace App\Subscriber;


use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Exception\AccessDeniedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [KernelEvents::EXCEPTION => 'onProcessException'];
    }

    public function onProcessException(ExceptionEvent $event)
    {
        switch (get_class($event->getThrowable())) {
            case AccessDeniedException::class:
                $this->onAccessDeniedException($event);
                break;
        }
    }

    private function onAccessDeniedException(ExceptionEvent $event)
    {
        /** @var AccessDeniedException $exception */
        $exception = $event->getThrowable();
        $event->setResponse(
            new Response($exception->getMessage(), $exception->getStatusCode())
        );
    }
}
