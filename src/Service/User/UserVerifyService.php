<?php

namespace App\Service\User;

use App\DTO\Email\EmailVerifyRequestDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\UserSignupVerificationResendRepository;
use App\Service\Email\EmailVerifyService;

class UserVerifyService
{
    private UserRepository $userRepository;
    private UserSignupVerificationResendRepository $userSignupVerificationResendRepository;
    private EmailVerifyService $emailVerifyService;

    public function __construct(
        UserRepository $userRepository,
        UserSignupVerificationResendRepository $userSignupVerificationResendRepository,
        EmailVerifyService $emailVerifyService
    ) {
        $this->userRepository = $userRepository;
        $this->userSignupVerificationResendRepository = $userSignupVerificationResendRepository;
        $this->emailVerifyService = $emailVerifyService;
    }

    public function verifyUser(EmailVerifyRequestDTO $emailVerifyRequestDTO): User
    {
        $user = $this->emailVerifyService->verifyEmail($emailVerifyRequestDTO);

        $user = $this->setUserProperties($user);

        $this->userRepository->add($user, true);

        if (
            $userSignupVerificationResend = $this->userSignupVerificationResendRepository->findOneBy(
                ['user' => $user]
            )
        ) {
            $this->userSignupVerificationResendRepository->remove($userSignupVerificationResend, true);
        }

        return $user;
    }

    private function setUserProperties(User $user): User
    {
        $user->setIsVerified(true);

        return $user;
    }
}
