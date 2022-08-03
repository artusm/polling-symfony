<?php

namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UserVerifiedByEmail extends Constraint
{
    public string $message = 'The user with the email "{{ string }}" is not verified.';
}
