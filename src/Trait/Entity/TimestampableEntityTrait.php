<?php

namespace App\Trait\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableEntityTrait
{
    #[ORM\Column(type: 'datetime', nullable: false)]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private $updatedAt;

    public function __construct()
    {
        $this->updatedTimestamps();
    }

    /**
     * @see TimestampableEntityInterface
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @see TimestampableEntityInterface
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @see TimestampableEntityInterface
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @see TimestampableEntityInterface
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @see TimestampableEntityInterface
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedTimestamps()
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if (null === $this->getCreatedAt()) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    /**
     * @see TimestampableEntityInterface
     */
    public function assertTimestampModification(string $timeToModify): bool
    {
        $time = new DateTime('now');
        $time->modify($timeToModify);

        if ($this->getUpdatedAt() < $time) {
            return true;
        }

        return false;
    }
}
