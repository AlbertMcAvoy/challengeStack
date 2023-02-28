<?php
namespace App\EventSubscriber;

use App\Controller\I_TokenAuthenticationController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class TokenSubscriber implements EventSubscriberInterface
{
    private $tokens;

    public function __construct($tokens) {
        $this->tokens = $tokens;
    }

    public function onKernelController(ControllerEvent $event) 
    {
        $controller = $event->getController();

        if(is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof I_TokenAuthenticationController) {
            $token = $event->getRequest()->query->get('token');
            if (!in_array($token, $this->tokens)) {
                throw new AccessDeniedHttpException('This action needs a valid token');
            }
        }
    }

    public function onKernelResponse(ResponseEvent $event) {
        if(!$token = $event->getRequest()->get('auth_token')) {
            return;
        }

        $response = $event->getResponse();

        $hash = sha1($response->getContent().$token);
        $response->headers->set('X-CONTENT-HASH', $hash);

    }

    public static function getSubscribedEvents()
    {
        return [
            kernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}

?>