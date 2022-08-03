<?php

namespace App\Service\UserInformation;

use App\DTO\UserInformation\UserInformationEditRequestDTO;
use App\Entity\UserInformation;

class IsUserInformationEditableService
{
    private bool $isUsernamePropertyEditable = false;

    public function setIsUserInformationEditableProperties(
        UserInformationEditRequestDTO $userInformationEditRequest,
        UserInformation $userInformation
    ): bool {
        if ($userInformationEditRequest->getUsername() != $userInformation->getUsername()) {
            $this->setIsUsernamePropertyEditable(true);
        }

        return $this->isUserInformationEditable();
    }

    public function isUserInformationEditable(): bool
    {
        return $this->getIsUsernamePropertyEditable();
    }

    public function setIsUsernamePropertyEditable(bool $isUsernamePropertyEditable): bool
    {
        $this->isUsernamePropertyEditable = $isUsernamePropertyEditable;

        return $isUsernamePropertyEditable;
    }

    public function getIsUsernamePropertyEditable(): bool
    {
        return $this->isUsernamePropertyEditable;
    }
}
