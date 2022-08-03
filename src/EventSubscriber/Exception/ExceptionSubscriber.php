<?php

namespace App\EventSubscriber\Exception;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\ExpiredSignatureException;
use SymfonyCasts\Bundle\VerifyEmail\Exception\InvalidSignatureException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
           ExceptionEvent::class => ['checkException', 10],
       ];
    }

    public function checkException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse(
                new RedirectResponse(
                    $this->urlGenerator->generate('error', ['error' => '404 Not Found.'])
                )
            );
        }

        if ($exception instanceof InvalidSignatureException || $exception instanceof ExpiredSignatureException) {
            $event->setResponse(
                new RedirectResponse(
                    $this->urlGenerator->generate('error', ['error' => 'Invalid validation token.'])
                )
            );
        }

        if ($exception instanceof BadRequestHttpException) {
            preg_match("/(:\s.+\.)/", $exception->getMessage(), $message);
            if (!$message) {
                preg_match("/(.+\.)/", $exception->getMessage(), $message);

                if (!$message) {
                    return null;
                }
            }

            $message = trim($message[0], ":\n ");

            $event->setResponse(new Response($message));
        }
    }
}
