<?php

namespace App\Validator\Captcha;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Captcha extends Constraint
{
    public string $message = 'The captcha is not valid.';
}
