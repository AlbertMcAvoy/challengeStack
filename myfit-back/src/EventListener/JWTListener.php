<?php

namespace App\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class JWTListener implements EventSubscriberInterface {

    public function onKernelRequest(RequestEvent $event)
    {
        $jwt = $event->getRequest()->headers->get('jwt-x-token');

        $jwtAllPieces = preg_split('.', $jwt);

        $jwtReconstitution =  $jwtAllPieces[0] + $jwtAllPieces[1];

        if ($jwtAllPieces[2] != $jwtReconstitution) {
            $event->setResponse(new JsonResponse(['message' => 'NON']));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest'
        ];
    }
}