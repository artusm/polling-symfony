<?php

namespace App\Entity;

use App\Repository\UserInformationRepository;
use App\Validator\UserInformation as UserInformationAssert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserInformationRepository::class)]
class UserInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[UserInformationAssert\UserInformationUsername]
    #[ORM\Column(type: 'string', length: 255)]
    private $username;

    public function __toString(): string
    {
        return $this->getId().', '.$this->getUsername();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
