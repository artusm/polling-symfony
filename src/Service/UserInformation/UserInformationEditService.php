<?php

namespace App\Service\UserInformation;

use App\DTO\UserInformation\UserInformationEditRequestDTO;
use App\Entity\UserInformation;
use App\Repository\UserInformationRepository;

class UserInformationEditService
{
    private UserInformationRepository $userInformationRepository;
    private IsUserInformationEditableService $isUserInformationEditableService;

    public function __construct(
        UserInformationRepository $userInformationRepository,
        IsUserInformationEditableService $isUserInformationEditableService,
    ) {
        $this->userInformationRepository = $userInformationRepository;
        $this->isUserInformationEditableService = $isUserInformationEditableService;
    }

    public function editUserInformation(
        UserInformationEditRequestDTO $userInformationEditRequest,
        UserInformation $userInformation
    ): UserInformation {
        if (
            $this->isUserInformationEditableService->setIsUserInformationEditableProperties(
                $userInformationEditRequest,
                $userInformation
            )
        ) {
            $userInformation = $this->setUserInformationProperties(
                $userInformationEditRequest,
                $userInformation
            );

            $this->userInformationRepository->add($userInformation, true);
        }

        return $userInformation;
    }

    private function setUserInformationProperties(
        UserInformationEditRequestDTO $userInformationEditRequest,
        UserInformation $userInformation
    ): UserInformation {
        if ($this->isUserInformationEditableService->getIsUsernamePropertyEditable()) {
            $userInformation->setUsername($userInformationEditRequest->getUsername());
        }

        return $userInformation;
    }
}
