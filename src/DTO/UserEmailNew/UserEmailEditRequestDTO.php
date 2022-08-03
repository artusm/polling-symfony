<?php

namespace App\DTO\UserEmailNew;

use App\Interface\DTO\RequestDTOInterface;
use App\Validator\User as UserAssert;
use Symfony\Component\HttpFoundation\Request;

class UserEmailEditRequestDTO implements RequestDTOInterface
{
    #[UserAssert\UserEmailAvailable]
    private ?string $email;

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->email = $data['email'] ?? null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
