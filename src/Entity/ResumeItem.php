<?php

namespace App\Entity;

use App\Repository\ResumeItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResumeItemRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ResumeItem
{
    public const TYPE_EDUCATION = 'education';
    public const TYPE_EXPERIENCE = 'experience';
    public const TYPE_SUMMARY = 'summary';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $period = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $details = null;

    #[ORM\Column]
    private ?bool $isActive = true;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        if ($this->position === null) {
            $this->position = 999;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(?string $period): static
    {
        $this->period = $period;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function setDetails(?array $details): static
    {
        $this->details = $details;
        return $this;
    }

    public function isActive(): ?bool
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

    public function setPosition(?int $position): static
    {
        $this->position = $position;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
