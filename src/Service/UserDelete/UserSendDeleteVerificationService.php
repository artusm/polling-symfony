<?php

namespace App\Service\UserDelete;

use App\DTO\UserDelete\UserDeleteRequestDTO;
use App\Entity\User;
use App\Entity\UserDelete;
use App\Repository\UserDeleteRepository;
use App\Service\Email\EmailCheckSpamService;
use App\Service\Email\EmailSendVerificationService;

class UserSendDeleteVerificationService
{
    private UserDeleteRepository $userDeleteRepository;
    private EmailCheckSpamService $emailCheckSpamService;
    private EmailSendVerificationService $emailSendVerificationService;

    public function __construct(
        UserDeleteRepository $userDeleteRepository,
        EmailCheckSpamService $emailCheckSpamService,
        EmailSendVerificationService $emailSendVerificationService
    ) {
        $this->userDeleteRepository = $userDeleteRepository;
        $this->emailCheckSpamService = $emailCheckSpamService;
        $this->emailSendVerificationService = $emailSendVerificationService;
    }

    public function sendUserDeleteVerification(UserDeleteRequestDTO $userDeleteRequest, User $user): UserDelete
    {
        if ($userDelete = $this->userDeleteRepository->findOneBy(['user' => $user])) {
            $this->emailCheckSpamService->checkEmailSpam($userDelete);

            $this->userDeleteRepository->remove($userDelete, true);
        }

        $this->emailSendVerificationService->sendEmailVerification($user, 'user_delete_verify');

        $userDelete = $this->setUserDeleteProperties(new UserDelete(), $user);

        $this->userDeleteRepository->add($userDelete, true);

        return $userDelete;
    }

    private function setUserDeleteProperties(UserDelete $userDelete, User $user): UserDelete
    {
        $userDelete->setUser($user);

        return $userDelete;
    }
}
