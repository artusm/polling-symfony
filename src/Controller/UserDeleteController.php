<?php

namespace App\Controller;

use App\DTO\Email\EmailVerifyRequestDTO;
use App\DTO\UserDelete\UserDeleteRequestDTO;
use App\Service\UserDelete\UserDeleteService;
use App\Service\UserDelete\UserSendDeleteVerificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDeleteController extends AbstractController
{
    private UserSendDeleteVerificationService $userSendDeleteVerificationService;
    private UserDeleteService $userDeleteService;

    public function __construct(
        UserSendDeleteVerificationService $userSendDeleteVerificationService,
        UserDeleteService $userDeleteService
    ) {
        $this->userSendDeleteVerificationService = $userSendDeleteVerificationService;
        $this->userDeleteService = $userDeleteService;
    }

    #[Route('/user/delete', name: 'user_delete', methods: ['DELETE'])]
    public function userDelete(UserDeleteRequestDTO $userDeleteRequest): Response
    {
        $this->userSendDeleteVerificationService->sendUserDeleteVerification(
            $userDeleteRequest,
            $this->getUser()
        );

        return $this->redirect(
            $this->generateUrl('settings', ['success' => 'Email verification sent successfully.'])
        );
    }

    #[Route('/user/delete/verify', name: 'user_delete_verify', methods: ['GET'])]
    public function userDeleteVerify(EmailVerifyRequestDTO $emailVerifyRequest): Response
    {
        $this->userDeleteService->deleteUser($emailVerifyRequest);

        return $this->redirect($this->generateUrl('login', ['success' => 'User deleted successfully.']));
    }
}
