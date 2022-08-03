<?php

namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UserEmailAvailable extends Constraint
{
    public string $message = 'The email "{{ string }}" is not available.';
}
