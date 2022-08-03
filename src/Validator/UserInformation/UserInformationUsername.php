<?php

namespace App\Validator\UserInformation;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UserInformationUsername extends Constraint
{
    public string $message = 'The username is not valid.';
}
