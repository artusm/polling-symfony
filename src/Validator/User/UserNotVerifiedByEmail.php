<?php

namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UserNotVerifiedByEmail extends Constraint
{
    public string $message = 'The user with the email "{{ string }}" is already verified.';
}
