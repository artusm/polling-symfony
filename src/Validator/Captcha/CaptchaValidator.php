<?php

namespace App\Validator\Captcha;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CaptchaValidator extends ConstraintValidator
{
    private string $captchaSecret;

    public function __construct()
    {
        $this->captchaSecret = $_ENV['CAPTCHA_SECRET'];
    }

    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $data = [
            'secret' => $this->captchaSecret,
            'response' => $value,
        ];

        $verify = curl_init();

        curl_setopt($verify, CURLOPT_URL, 'https://hcaptcha.com/siteverify');
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($verify);
        $responseData = json_decode($response);

        if (!$responseData->success) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
