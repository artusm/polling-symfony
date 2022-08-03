<?php

namespace App\Service\Email;

use App\Interface\Entity\TimestampableEntityInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EmailCheckSpamService
{
    private string $timeToModify = '-2 minutes';

    public function checkEmailSpam(TimestampableEntityInterface $timestampableEntity)
    {
        if (!$timestampableEntity->assertTimestampModification($this->timeToModify)) {
            throw new BadRequestHttpException('Wait at least 2 minutes before resending the email.');
        }
    }
}
