<?php

namespace App\DTO\UserInformation;

use App\Interface\DTO\RequestDTOInterface;
use App\Validator\UserInformation as UserInformationAssert;
use Symfony\Component\HttpFoundation\Request;

class UserInformationEditRequestDTO implements RequestDTOInterface
{
    #[UserInformationAssert\UserInformationUsername]
    private ?string $username;

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->username = $data['username'] ?? null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
}
