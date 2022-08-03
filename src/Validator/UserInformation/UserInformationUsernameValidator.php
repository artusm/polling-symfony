<?php

namespace App\Validator\UserInformation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UserInformationUsernameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[a-zA-Z0-9_]{1,25}$/', $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
