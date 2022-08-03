<?php

namespace App\Service\User;

use App\DTO\User\UserSignupRequestDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSignupService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function signupUser(UserSignupRequestDTO $userSignupRequest): User
    {
        $user = $this->setUserProperties($userSignupRequest, new User());

        $this->userRepository->add($user, true);

        return $user;
    }

    private function setUserProperties(UserSignupRequestDTO $userSignupRequest, User $user): User
    {
        $user->setEmail($userSignupRequest->getEmail());
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $userSignupRequest->getPassword()
            )
        );

        return $user;
    }
}
