<?php

namespace App\Service\UserEmailNew;

use App\DTO\UserEmailNew\UserEmailEditRequestDTO;
use App\Entity\User;
use App\Entity\UserEmailNew;
use App\Repository\UserEmailNewRepository;
use App\Service\Email\EmailCheckSpamService;
use App\Service\Email\EmailSendVerificationService;

class UserSendEditEmailVerificationService
{
    private UserEmailNewRepository $userEmailNewRepository;
    private EmailCheckSpamService $emailCheckSpamService;
    private EmailSendVerificationService $emailSendVerificationService;

    public function __construct(
        UserEmailNewRepository $userEmailNewRepository,
        EmailCheckSpamService $emailCheckSpamService,
        EmailSendVerificationService $emailSendVerificationService
    ) {
        $this->userEmailNewRepository = $userEmailNewRepository;
        $this->emailCheckSpamService = $emailCheckSpamService;
        $this->emailSendVerificationService = $emailSendVerificationService;
    }

    public function sendUserEditEmailVerification(
        UserEmailEditRequestDTO $userEmailEditRequest,
        User $user
    ): UserEmailNew {
        if ($userEmailNew = $this->userEmailNewRepository->findOneBy(['user' => $user])) {
            $this->emailCheckSpamService->checkEmailSpam($userEmailNew);

            $this->userEmailNewRepository->remove($userEmailNew, true);
        }

        $this->emailSendVerificationService->sendEmailVerification($user, 'user_edit_email_verify');

        $userEmailNew = $this->setUserEmailNewProperties($userEmailEditRequest, new UserEmailNew(), $user);

        $this->userEmailNewRepository->add($userEmailNew, true);

        return $userEmailNew;
    }

    private function setUserEmailNewProperties(
        UserEmailEditRequestDTO $userEmailEditRequest,
        UserEmailNew $userEmailNew,
        User $user
    ): UserEmailNew {
        $userEmailNew->setEmailNew($userEmailEditRequest->getEmail());
        $userEmailNew->setUser($user);

        return $userEmailNew;
    }
}
