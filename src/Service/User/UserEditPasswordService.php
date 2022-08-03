<?php

namespace App\Service\User;

use App\DTO\User\UserEditPasswordRequestDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEditPasswordService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function editUserPassword(UserEditPasswordRequestDTO $userEditPasswordRequest, User $user): User
    {
        $user = $this->setUserProperties($userEditPasswordRequest, $user);

        $this->userRepository->add($user, true);

        return $user;
    }

    private function setUserProperties(UserEditPasswordRequestDTO $userEditPasswordRequest, User $user): User
    {
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $userEditPasswordRequest->getPasswordNew()
            )
        );

        return $user;
    }
}
