<?php


namespace App\Subscriber;


use App\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContentLengthSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return ['response' => ['onResponse', -255]];
    }

    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $headers = $response->headers;

        if (!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')) {
            $headers->set('Content-Length', strlen($response->getContent()));
        }
    }
}