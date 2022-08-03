<?php

namespace App\Interface\Entity;

use DateTime;

interface TimestampableEntityInterface
{
    public function getCreatedAt(): ?DateTime;

    public function setCreatedAt(DateTime $createdAt): self;

    public function getUpdatedAt(): ?DateTime;

    public function setUpdatedAt(DateTime $updatedAt): self;

    public function updatedTimestamps();

    public function assertTimestampModification(string $timeToModify): bool;
}
