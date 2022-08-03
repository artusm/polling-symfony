<?php

namespace App\DTO\UserDelete;

use App\Interface\DTO\RequestDTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class UserDeleteRequestDTO implements RequestDTOInterface
{
    #[Assert\Length(min: '8', minMessage: 'Password should be at least 8 characters.')]
    #[SecurityAssert\UserPassword(message: 'Invalid password.')]
    private ?string $password;

    #[Assert\EqualTo(propertyPath: 'password', message: 'Passwords do not match.')]
    private ?string $passwordRepeat;

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->password = $data['password'] ?? null;
        $this->passwordRepeat = $data['password-repeat'] ?? null;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordRepeat(): string
    {
        return $this->passwordRepeat;
    }
}
