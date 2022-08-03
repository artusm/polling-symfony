<?php

namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UserId extends Constraint
{
    public string $message = 'The user ID "{{ string }}" is not valid.';
}
