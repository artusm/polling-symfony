<?php

namespace App\Service\Email;

use App\DTO\Email\EmailVerifyRequestDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifyService
{
    private UserRepository $userRepository;
    private VerifyEmailHelperInterface $verifyEmailHelper;

    public function __construct(
        UserRepository $userRepository,
        VerifyEmailHelperInterface $verifyEmailHelper
    ) {
        $this->userRepository = $userRepository;
        $this->verifyEmailHelper = $verifyEmailHelper;
    }

    public function verifyEmail(EmailVerifyRequestDTO $emailVerifyRequest): User
    {
        $user = $this->userRepository->find($emailVerifyRequest->getUserId());

        $this->verifyEmailHelper->validateEmailConfirmation(
            $emailVerifyRequest->getRequestUri(),
            $user->getId(),
            $user->getEmail()
        );

        return $user;
    }
}
