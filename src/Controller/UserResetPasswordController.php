<?php

namespace App\Controller;

use App\DTO\Captcha\CaptchaRequestDTO;
use App\DTO\Email\EmailVerifyRequestDTO;
use App\DTO\UserPasswordReset\UserSendPasswordResetRequestDTO;
use App\Service\UserPasswordReset\UserResetPasswordService;
use App\Service\UserPasswordReset\UserSendResetPasswordVerificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserResetPasswordController extends AbstractController
{
    private UserResetPasswordService $userResetPasswordService;
    private UserSendResetPasswordVerificationService $userSendResetPasswordVerificationService;

    public function __construct(
        UserResetPasswordService $userResetPasswordService,
        UserSendResetPasswordVerificationService $userSendResetPasswordVerificationService,
    ) {
        $this->userResetPasswordService = $userResetPasswordService;
        $this->userSendResetPasswordVerificationService = $userSendResetPasswordVerificationService;
    }

    #[Route('/password/reset', name: 'password_reset', methods: ['GET'])]
    public function passwordReset(): Response
    {
        return $this->render('auth/password_reset.html.twig');
    }

    #[Route('/password/reset/init', name: 'password_reset_init', methods: ['POST'])]
    public function passwordResetInit(
        CaptchaRequestDTO $captchaRequest,
        UserSendPasswordResetRequestDTO $userSendPasswordResetRequest
    ): Response {
        $this->userSendResetPasswordVerificationService->sendUserResetPasswordVerification(
            $userSendPasswordResetRequest
        );

        return $this->redirect(
            $this->generateUrl('password_reset', ['success' => 'Email sent successfully.'])
        );
    }

    #[Route('/password/verify', name: 'password_verify', methods: ['GET'])]
    public function passwordVerify(EmailVerifyRequestDTO $emailVerifyRequest): Response
    {
        $this->userResetPasswordService->resetUserPassword($emailVerifyRequest);

        return $this->redirectToRoute('login', ['success' => 'Password reset successfully.']);
    }
}
