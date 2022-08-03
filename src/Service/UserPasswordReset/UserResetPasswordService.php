<?php

namespace App\Service\UserPasswordReset;

use App\DTO\Email\EmailVerifyRequestDTO;
use App\Entity\User;
use App\Entity\UserPasswordReset;
use App\Repository\UserPasswordResetRepository;
use App\Repository\UserRepository;
use App\Service\Email\EmailVerifyService;

class UserResetPasswordService
{
    private UserPasswordResetRepository $userPasswordResetRepository;
    private UserRepository $userRepository;
    private EmailVerifyService $emailVerifyService;

    public function __construct(
        UserPasswordResetRepository $userPasswordResetRepository,
        UserRepository $userRepository,
        EmailVerifyService $emailVerifyService
    ) {
        $this->userPasswordResetRepository = $userPasswordResetRepository;
        $this->userRepository = $userRepository;
        $this->emailVerifyService = $emailVerifyService;
    }

    public function resetUserPassword(EmailVerifyRequestDTO $emailVerifyRequest): User
    {
        $user = $this->emailVerifyService->verifyEmail($emailVerifyRequest);

        $userPasswordReset = $this->userPasswordResetRepository->findOneBy(['user' => $user]);

        $user = $this->setUserProperties($userPasswordReset, $user);

        $this->userRepository->add($user, true);

        $this->userPasswordResetRepository->remove($userPasswordReset, true);

        return $user;
    }

    private function setUserProperties(UserPasswordReset $userPasswordReset, User $user): User
    {
        $user->setPassword($userPasswordReset->getPasswordNew());

        return $user;
    }
}
