<?php


namespace App\Listener;


use App\Event\ResponseEvent;

class GoogleListener
{
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