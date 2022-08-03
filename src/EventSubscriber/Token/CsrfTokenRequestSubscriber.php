<?php

namespace App\EventSubscriber\Token;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CsrfTokenRequestSubscriber implements EventSubscriberInterface
{
    private CsrfTokenManagerInterface $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public static function getSubscribedEvents()
    {
        return [
           RequestEvent::class => ['checkEvent', 10],
       ];
    }

    public function checkEvent(RequestEvent $event)
    {
        if ('GET' === $event->getRequest()->getMethod() || '/admin' == $event->getRequest()->getPathInfo()) {
            return;
        }

        $value = $event->getRequest()->request->get('csrf-token');

        if (empty($value)) {
            $data = json_decode($event->getRequest()->getContent(), true);

            if (empty($data['csrf-token'])) {
                throw new InvalidCsrfTokenException('Invalid CSRF token.');
            }

            $value = $data['csrf-token'];
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $token = new CsrfToken('csrf-token', $value);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException('Invalid CSRF token.');
        }
    }
}
