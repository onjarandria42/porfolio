<?php

namespace App\Entity;

use App\Repository\TestimonialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestimonialRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Testimonial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $authorName = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $authorRole = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authorImage = null;

    #[ORM\Column(type: 'text')]
    private ?string $content = null;

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

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): static
    {
        $this->authorName = $authorName;
        return $this;
    }

    public function getAuthorRole(): ?string
    {
        return $this->authorRole;
    }

    public function setAuthorRole(?string $authorRole): static
    {
        $this->authorRole = $authorRole;
        return $this;
    }

    public function getAuthorImage(): ?string
    {
        return $this->authorImage;
    }

    public function setAuthorImage(?string $authorImage): static
    {
        $this->authorImage = $authorImage;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
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
        return $this->authorName ?? '';
    }
}
