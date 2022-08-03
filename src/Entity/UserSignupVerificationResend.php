<?php

namespace App\Entity;

use App\Interface\Entity\TimestampableEntityInterface;
use App\Trait\Entity\TimestampableEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserSignupVerificationResendRepository::class)]
#[UniqueEntity(fields: ['user'], message: 'Invalid user.')]
#[ORM\HasLifecycleCallbacks]
class UserSignupVerificationResend implements TimestampableEntityInterface
{
    use TimestampableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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
