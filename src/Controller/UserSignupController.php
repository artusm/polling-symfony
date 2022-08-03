<?php

namespace App\Controller;

use App\DTO\Captcha\CaptchaRequestDTO;
use App\DTO\Email\EmailVerifyRequestDTO;
use App\DTO\User\UserSignupRequestDTO;
use App\DTO\UserInformation\UserInformationAddRequestDTO;
use App\DTO\UserSignupVerificationResend\UserResendSignupVerificationRequestDTO;
use App\Service\Email\EmailSendVerificationService;
use App\Service\User\UserSignupService;
use App\Service\User\UserVerifyService;
use App\Service\UserInformation\UserInformationAddService;
use App\Service\UserSignupVerificationResend\UserResendSignupVerificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserSignupController extends AbstractController
{
    private EmailSendVerificationService $emailSendVerificationService;
    private UserSignupService $userSignupService;
    private UserVerifyService $userVerifyService;
    private UserInformationAddService $userInformationAddService;
    private UserResendSignupVerificationService $userResendSignupVerificationService;

    public function __construct(
        EmailSendVerificationService $emailSendVerificationService,
        UserSignupService $userSignupService,
        UserVerifyService $userVerifyService,
        UserInformationAddService $userInformationAddService,
        UserResendSignupVerificationService $userResendSignupVerificationService
    ) {
        $this->emailSendVerificationService = $emailSendVerificationService;
        $this->userSignupService = $userSignupService;
        $this->userVerifyService = $userVerifyService;
        $this->userInformationAddService = $userInformationAddService;
        $this->userResendSignupVerificationService = $userResendSignupVerificationService;
    }

    #[Route('/signup', name: 'signup', methods: ['GET'])]
    public function userSignup(): Response
    {
        return $this->render('auth/signup.html.twig');
    }

    #[Route('/signup/init', name: 'signup_init', methods: ['POST'])]
    public function userSignupInit(
        CaptchaRequestDTO $captchaRequest,
        UserSignupRequestDTO $userSignupRequest,
        UserInformationAddRequestDTO $userInformationAddRequest,
    ): Response {
        $user = $this->userSignupService->signupUser($userSignupRequest);

        $userInformation = $this->userInformationAddService->addUserInformation(
            $userInformationAddRequest,
            $user
        );

        $this->emailSendVerificationService->sendEmailVerification($user, 'signup_verify');

        return $this->redirect(
            $this->generateUrl(
                'signup_verification_resend',
                ['success' => 'Email verification sent successfully.']
            )
        );
    }

    #[Route('/signup/verify', name: 'signup_verify', methods: ['GET'])]
    public function signupVerify(EmailVerifyRequestDTO $emailVerifyRequest): Response
    {
        $this->userVerifyService->verifyUser($emailVerifyRequest);

        return $this->redirectToRoute('login', ['success' => 'Email verified successfully.']);
    }

    #[Route('/signup/verification/resend', name: 'signup_verification_resend', methods: ['GET'])]
    public function userResendSignupVerification(): Response
    {
        return $this->render('auth/signup_verification_resend.html.twig');
    }

    #[Route('/signup/verification/resend/init', name: 'signup_verification_resend_init', methods: ['POST'])]
    public function userResendSignupVerificationInit(
        CaptchaRequestDTO $captchaRequest,
        UserResendSignupVerificationRequestDTO $userResendSignupVerificationRequest
    ): Response {
        $this->userResendSignupVerificationService->sendUserResendSignupVerification(
            $userResendSignupVerificationRequest
        );

        return $this->redirect(
            $this->generateUrl(
                'signup_verification_resend',
                ['success' => 'Email verification resent successfully.']
            )
        );
    }
}
