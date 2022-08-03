<?php

namespace App\DTO\UserPasswordReset;

use App\Interface\DTO\RequestDTOInterface;
use App\Validator\User as UserAssert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserSendPasswordResetRequestDTO implements RequestDTOInterface
{
    #[UserAssert\UserEmail]
    #[UserAssert\UserVerifiedByEmail]
    private ?string $email;

    #[Assert\Length(min: '8', minMessage: 'Password should be at least 8 characters.')]
    #[Assert\NotCompromisedPassword(message: 'This password has been leaked. Please use another password.')]
    private ?string $passwordNew;

    #[Assert\EqualTo(propertyPath: 'passwordNew', message: 'Passwords do not match.')]
    private ?string $passwordNewRepeat;

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->email = $data['email'] ?? null;
        $this->passwordNew = $data['password-new'] ?? null;
        $this->passwordNewRepeat = $data['password-new-repeat'] ?? null;
    }

    public function getEmail(): string
    {
        return $this->email;
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
