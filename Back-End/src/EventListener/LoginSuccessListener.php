<?php

namespace App\EventListener;

use App\Entity\User;
use App\Entity\Role;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class LoginSuccessListener
{
    public function onLoginSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();
        $payload = $event->getData();
        if (!$user instanceof User) {
            return;
        }
        // Add information to user payload
        
        $payload['user'] = [
            "id" => $user->getId(),
            "role" => $user->getRole()->getNamerole(),
        ];
        $event->setData($payload);
    }
}