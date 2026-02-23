<?php

namespace App\Entity;

use App\Repository\HeroJobRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeroJobRepository::class)]
#[ORM\HasLifecycleCallbacks]
class HeroJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\ManyToOne(inversedBy: 'heroJobs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hero $hero = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // --------------------
    // LIFECYCLE CALLBACKS
    // --------------------

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        // Date de création automatique
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }

        // Position automatique (à la fin)
        if ($this->position === null) {
            $this->position = 999;
        }
    }

    // --------------------
    // GETTERS / SETTERS
    // --------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    // optionnel : garder le setter si plus tard drag & drop
    public function setPosition(?int $position): static
    {
        $this->position = $position;
        return $this;
    }

    public function getHero(): ?Hero
    {
        return $this->hero;
    }

    public function setHero(?Hero $hero): static
    {
        $this->hero = $hero;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function __toString(): string
    {
    return (string) $this->title;
    }
}
