<?php

namespace App\DTO\User;

use App\Interface\DTO\RequestDTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class UserEditPasswordRequestDTO implements RequestDTOInterface
{
    #[Assert\Length(min: '8', minMessage: 'Password should be at least 8 characters.')]
    #[SecurityAssert\UserPassword(message: 'Invalid old password.')]
    private ?string $passwordOld;

    #[Assert\Length(min: '8', minMessage: 'Password should be at least 8 characters.')]
    #[Assert\NotCompromisedPassword(message: 'This password has been leaked. Please use another password.')]
    private ?string $passwordNew;

    #[Assert\EqualTo(propertyPath: 'passwordNew', message: 'Passwords do not match.')]
    private ?string $passwordNewRepeat;

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->passwordOld = $data['password-old'] ?? null;
        $this->passwordNew = $data['password-new'] ?? null;
        $this->passwordNewRepeat = $data['password-new-repeat'] ?? null;
    }

    public function getPasswordOld(): string
    {
        return $this->passwordOld;
    }

    public function getPasswordNew(): string
    {
        return $this->passwordNew;
    }

    public function getPasswordNewRepeat(): string
    {
        return $this->passwordNewRepeat;
    }
}
