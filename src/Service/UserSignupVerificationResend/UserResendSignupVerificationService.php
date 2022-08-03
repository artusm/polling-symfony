<?php

namespace App\Service\UserSignupVerificationResend;

use App\DTO\UserSignupVerificationResend\UserResendSignupVerificationRequestDTO;
use App\Entity\User;
use App\Entity\UserSignupVerificationResend;
use App\Repository\UserRepository;
use App\Repository\UserSignupVerificationResendRepository;
use App\Service\Email\EmailCheckSpamService;
use App\Service\Email\EmailSendVerificationService;

class UserResendSignupVerificationService
{
    private UserRepository $userRepository;
    private UserSignupVerificationResendRepository $userSignupVerificationResendRepository;
    private EmailCheckSpamService $emailCheckSpamService;
    private EmailSendVerificationService $emailSendVerificationService;

    public function __construct(
        UserRepository $userRepository,
        UserSignupVerificationResendRepository $userSignupVerificationResendRepository,
        EmailCheckSpamService $emailCheckSpamService,
        EmailSendVerificationService $emailSendVerificationService
    ) {
        $this->userRepository = $userRepository;
        $this->userSignupVerificationResendRepository = $userSignupVerificationResendRepository;
        $this->emailCheckSpamService = $emailCheckSpamService;
        $this->emailSendVerificationService = $emailSendVerificationService;
    }

    public function sendUserResendSignupVerification(
        UserResendSignupVerificationRequestDTO $userResendSignupVerificationRequest
    ): UserSignupVerificationResend {
        $user = $this->userRepository->findOneBy(['email' => $userResendSignupVerificationRequest->getEmail()]);

        if (
            $userSignupVerificationResend = $this->userSignupVerificationResendRepository->findOneBy(
                ['user' => $user]
            )
        ) {
            $this->emailCheckSpamService->checkEmailSpam($userSignupVerificationResend);

            $this->userSignupVerificationResendRepository->remove($userSignupVerificationResend, true);
        }

        $this->emailSendVerificationService->sendEmailVerification($user, 'signup_verify');

        $userSignupVerificationResend = $this->setUserSignupVerificationResendProperties(
            new UserSignupVerificationResend(),
            $user
        );

        $this->userSignupVerificationResendRepository->add($userSignupVerificationResend, true);

        return $userSignupVerificationResend;
    }

    private function setUserSignupVerificationResendProperties(
        UserSignupVerificationResend $userSignupVerificationResend,
        User $user
    ): UserSignupVerificationResend {
        $userSignupVerificationResend->setUser($user);

        return $userSignupVerificationResend;
    }
}
