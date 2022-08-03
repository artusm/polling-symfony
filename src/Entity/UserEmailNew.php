<?php

namespace App\Entity;

use App\Interface\Entity\TimestampableEntityInterface;
use App\Trait\Entity\TimestampableEntityTrait;
use App\Validator\User as UserAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserEmailNewRepository::class)]
#[UniqueEntity(fields: ['user'], message: 'Invalid user.')]
#[ORM\HasLifecycleCallbacks]
class UserEmailNew implements TimestampableEntityInterface
{
    use TimestampableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[UserAssert\UserEmailAvailable]
    #[ORM\Column(type: 'string', length: 255)]
    private $emailNew;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailNew(): string
    {
        return $this->emailNew;
    }

    public function setEmailNew(string $emailNew): self
    {
        $this->emailNew = $emailNew;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
