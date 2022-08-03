<?php

namespace App\DTO\User;

use App\Interface\DTO\RequestDTOInterface;
use App\Validator\User as UserAssert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserSignupRequestDTO implements RequestDTOInterface
{
    #[UserAssert\UserEmailAvailable]
    private ?string $email;

    #[Assert\Length(min: '8', minMessage: 'Password should be at least 8 characters.')]
    #[Assert\NotCompromisedPassword(message: 'This password has been leaked. Please use another password.')]
    private ?string $password;

    #[Assert\EqualTo(propertyPath: 'password', message: 'Passwords do not match.')]
    private ?string $passwordRepeat;

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->passwordRepeat = $data['password-repeat'] ?? null;
    }

    /**
     * @see UserSignupRequestDTOInterface
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @see UserSignupRequestDTOInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @see UserSignupRequestDTOInterface
     */
    public function getPasswordRepeat(): string
    {
        return $this->passwordRepeat;
    }
}
