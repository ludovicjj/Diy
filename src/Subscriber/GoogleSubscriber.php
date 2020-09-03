<?php


namespace App\Subscriber;


use App\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GoogleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return ['response' => 'onResponse'];
    }

    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $headers = $response->headers;

        if (
            $response->isRedirection()
            || ($headers->has('Content-Type') && strpos($headers->get('Content-Type'), 'html') === false)
            || $event->getRequest()->getRequestFormat() !== 'html'
        ) {
            return;
        }
        $response->setContent($response->getContent().' GA CODE');
    }
}