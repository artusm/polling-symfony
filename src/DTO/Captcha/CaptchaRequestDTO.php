<?php

namespace App\DTO\Captcha;

use App\Interface\DTO\RequestDTOInterface;
use App\Validator\Captcha as CaptchaAssert;
use Symfony\Component\HttpFoundation\Request;

class CaptchaRequestDTO implements RequestDTOInterface
{
    #[CaptchaAssert\Captcha]
    private ?string $captchaResponse;

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->captchaResponse = $data['h-captcha-response']
            ?? $request->request->get('h-captcha-response')
            ?? null;
    }

    public function getCaptchaResponse(): ?string
    {
        return $this->captchaResponse;
    }
}
