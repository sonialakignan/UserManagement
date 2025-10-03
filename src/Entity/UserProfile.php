<?php

namespace App\Entity;

use App\Repository\UserProfileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToOne(targetEntity: User::class, inversedBy: "profile", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $bio = null;

     #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\Url(message: "L’URL de l’avatar doit être valide.")]
    private ?string $avatar = null;

    #[ORM\Column(type: "date", nullable: true)]
    #[Assert\LessThan("today", message: "La date de naissance doit être dans le passé.")]
    private ?\DateTimeInterface $dateOfBirth = null;


   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getUser(): ?User 
    { 
        return $this->user; 
    
    }
    public function setUser(User $user): self 
    { 
        $this->user = $user; return $this; 
    }

    public function getAvatar(): ?string { 
        return $this->avatar; 
    }
    public function setAvatar(?string $avatar): self { 
        $this->avatar = $avatar; return $this; 
    }

    public function getDateOfBirth(): ?\DateTimeInterface 
    { 
        return $this->dateOfBirth; 
    }
    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self 
    { 
        $this->dateOfBirth = $dateOfBirth; return $this; 
    }
}
