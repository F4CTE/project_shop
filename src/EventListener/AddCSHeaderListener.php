<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AddCSHeaderListener
{
    public function AddHeader(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->add([
            'X-DEVELOPED-BY' => 'F4NT0M'
        ]);
    }
}