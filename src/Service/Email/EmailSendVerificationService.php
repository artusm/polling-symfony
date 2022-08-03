<?php

namespace App\Service\Email;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailSendVerificationService
{
    private MailerInterface $mailer;
    private VerifyEmailHelperInterface $verifyEmailHelper;

    public function __construct(MailerInterface $mailer, VerifyEmailHelperInterface $verifyEmailHelper)
    {
        $this->mailer = $mailer;
        $this->verifyEmailHelper = $verifyEmailHelper;
    }

    public function sendEmailVerification(User $user, string $route)
    {
        $this->mailer->send(
            $this->getEmail(
                $this->getEmailVerificationSignature($user, $route)
            )
        );
    }

    private function getEmailVerificationSignature(User $user, string $route): VerifyEmailSignatureComponents
    {
        return $this->verifyEmailHelper->generateSignature(
            $route,
            $user->getId(),
            $user->getEmail(),
            ['user-id' => $user->getId()]
        );
    }

    private function getEmail(VerifyEmailSignatureComponents $signatureComponents): Email
    {
        return (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->text($signatureComponents->getSignedUrl());
    }
}
