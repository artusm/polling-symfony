<?php

namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UserEmail extends Constraint
{
    public string $message = 'The email "{{ string }}" is not registered.';
}
