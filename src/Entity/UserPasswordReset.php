<?php

namespace App\Entity;

use App\Interface\Entity\TimestampableEntityInterface;
use App\Trait\Entity\TimestampableEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserPasswordResetRepository::class)]
#[UniqueEntity(fields: ['user'], message: 'Invalid user.')]
#[ORM\HasLifecycleCallbacks]
class UserPasswordReset implements TimestampableEntityInterface
{
    use TimestampableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[Assert\Length(min: '8', minMessage: 'Password should be at least 8 characters.')]
    #[Assert\NotCompromisedPassword(message: 'This password has been leaked. Please use another password.')]
    #[ORM\Column(type: 'string', length: 1500)]
    private $passwordNew;

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

    public function getPasswordNew(): ?string
    {
        return $this->passwordNew;
    }

    public function setPasswordNew(string $passwordNew): self
    {
        $this->passwordNew = $passwordNew;

        return $this;
    }
}
