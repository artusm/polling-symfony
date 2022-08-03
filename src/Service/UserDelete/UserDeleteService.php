<?php

namespace App\Service\UserDelete;

use App\DTO\Email\EmailVerifyRequestDTO;
use App\Repository\UserDeleteRepository;
use App\Repository\UserRepository;
use App\Service\Email\EmailVerifyService;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserDeleteService
{
    private UserDeleteRepository $userDeleteRepository;
    private UserRepository $userRepository;
    private EmailVerifyService $emailVerifyService;
    private TokenStorageInterface $tokenStorage;

    public function __construct(
        UserDeleteRepository $userDeleteRepository,
        UserRepository $userRepository,
        EmailVerifyService $emailVerifyService,
        TokenStorageInterface $tokenStorage
    ) {
        $this->userDeleteRepository = $userDeleteRepository;
        $this->userRepository = $userRepository;
        $this->emailVerifyService = $emailVerifyService;
        $this->tokenStorage = $tokenStorage;
    }

    public function deleteUser(EmailVerifyRequestDTO $emailVerifyRequest)
    {
        $user = $this->emailVerifyService->verifyEmail($emailVerifyRequest);

        $userDelete = $this->userDeleteRepository->findOneBy(['user' => $user]);

        $this->userDeleteRepository->remove($userDelete, true);

        $this->userRepository->remove($user, true);

        $this->tokenStorage->setToken(null);
    }
}
