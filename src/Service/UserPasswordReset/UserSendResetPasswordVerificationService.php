<?php

namespace App\Service\UserPasswordReset;

use App\DTO\UserPasswordReset\UserSendPasswordResetRequestDTO;
use App\Entity\User;
use App\Entity\UserPasswordReset;
use App\Repository\UserPasswordResetRepository;
use App\Repository\UserRepository;
use App\Service\Email\EmailCheckSpamService;
use App\Service\Email\EmailSendVerificationService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSendResetPasswordVerificationService
{
    private UserPasswordResetRepository $userPasswordResetRepository;
    private UserRepository $userRepository;
    private EmailCheckSpamService $emailCheckSpamService;
    private EmailSendVerificationService $emailSendVerificationService;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        UserPasswordResetRepository $userPasswordResetRepository,
        UserRepository $userRepository,
        EmailCheckSpamService $emailCheckSpamService,
        EmailSendVerificationService $emailSendVerificationService,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->userPasswordResetRepository = $userPasswordResetRepository;
        $this->userRepository = $userRepository;
        $this->emailCheckSpamService = $emailCheckSpamService;
        $this->emailSendVerificationService = $emailSendVerificationService;
        $this->passwordHasher = $passwordHasher;
    }

    public function sendUserResetPasswordVerification(
        UserSendPasswordResetRequestDTO $userSendPasswordResetRequest
    ): UserPasswordReset {
        $user = $this->userRepository->findOneBy(['email' => $userSendPasswordResetRequest->getEmail()]);

        if ($userPasswordReset = $this->userPasswordResetRepository->findOneBy(['user' => $user])) {
            $this->emailCheckSpamService->checkEmailSpam($userPasswordReset);

            $this->userPasswordResetRepository->remove($userPasswordReset, true);
        }

        $this->emailSendVerificationService->sendEmailVerification($user, 'password_verify');

        $userPasswordReset = $this->setUserPasswordResetProperties(
            $userSendPasswordResetRequest,
            new UserPasswordReset(),
            $user
        );

        $this->userPasswordResetRepository->add($userPasswordReset, true);

        return $userPasswordReset;
    }

    private function setUserPasswordResetProperties(
        UserSendPasswordResetRequestDTO $userSendPasswordResetRequest,
        UserPasswordReset $userPasswordReset,
        User $user
    ): UserPasswordReset {
        $userPasswordReset->setUser($user);
        $userPasswordReset->setPasswordNew(
            $this->passwordHasher->hashPassword(
                $user,
                $userSendPasswordResetRequest->getPasswordNew()
            )
        );

        return $userPasswordReset;
    }
}
