<?php

namespace App\Service\UserEmailNew;

use App\DTO\Email\EmailVerifyRequestDTO;
use App\Entity\User;
use App\Entity\UserEmailNew;
use App\Repository\UserEmailNewRepository;
use App\Repository\UserRepository;
use App\Service\Email\EmailVerifyService;

class UserEditEmailService
{
    private UserEmailNewRepository $userEmailNewRepository;
    private UserRepository $userRepository;
    private EmailVerifyService $emailVerifyService;

    public function __construct(
        UserEmailNewRepository $userEmailNewRepository,
        UserRepository $userRepository,
        EmailVerifyService $emailVerifyService,
    ) {
        $this->userEmailNewRepository = $userEmailNewRepository;
        $this->userRepository = $userRepository;
        $this->emailVerifyService = $emailVerifyService;
    }

    public function editUserEmail(EmailVerifyRequestDTO $emailVerifyRequest): User
    {
        $user = $this->emailVerifyService->verifyEmail($emailVerifyRequest);

        $userEmailNew = $this->userEmailNewRepository->findOneBy(['user' => $user]);

        $user = $this->setUserProperties($userEmailNew, $user);

        $this->userRepository->add($user, true);

        $this->userEmailNewRepository->remove($userEmailNew, true);

        return $user;
    }

    private function setUserProperties(UserEmailNew $userEmailNew, User $user): User
    {
        $user->setEmail($userEmailNew->getEmailNew());

        return $user;
    }
}
