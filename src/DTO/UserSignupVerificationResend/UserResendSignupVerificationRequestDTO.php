<?php

namespace App\DTO\UserSignupVerificationResend;

use App\Interface\DTO\RequestDTOInterface;
use App\Validator\User as UserAssert;
use Symfony\Component\HttpFoundation\Request;

class UserResendSignupVerificationRequestDTO implements RequestDTOInterface
{
    #[UserAssert\UserEmail]
    #[UserAssert\UserNotVerifiedByEmail]
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
