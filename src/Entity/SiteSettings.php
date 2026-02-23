<?php

namespace App\Entity;

use App\Repository\SiteSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteSettingsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SiteSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteTitle = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $siteDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteLogo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $favicon = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $metaAuthor = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $metaKeywords = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cvFile = null;

    #[ORM\Column]
    private ?bool $maintenanceMode = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(?string $siteName): static
    {
        $this->siteName = $siteName;
        return $this;
    }

    public function getSiteTitle(): ?string
    {
        return $this->siteTitle;
    }

    public function setSiteTitle(?string $siteTitle): static
    {
        $this->siteTitle = $siteTitle;
        return $this;
    }

    public function getSiteDescription(): ?string
    {
        return $this->siteDescription;
    }

    public function setSiteDescription(?string $siteDescription): static
    {
        $this->siteDescription = $siteDescription;
        return $this;
    }

    public function getSiteLogo(): ?string
    {
        return $this->siteLogo;
    }

    public function setSiteLogo(?string $siteLogo): static
    {
        $this->siteLogo = $siteLogo;
        return $this;
    }

    public function getFavicon(): ?string
    {
        return $this->favicon;
    }

    public function setFavicon(?string $favicon): static
    {
        $this->favicon = $favicon;
        return $this;
    }

    public function getMetaAuthor(): ?string
    {
        return $this->metaAuthor;
    }

    public function setMetaAuthor(?string $metaAuthor): static
    {
        $this->metaAuthor = $metaAuthor;
        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(?string $metaKeywords): static
    {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    public function getCvFile(): ?string
    {
        return $this->cvFile;
    }

    public function setCvFile(?string $cvFile): static
    {
        $this->cvFile = $cvFile;
        return $this;
    }

    public function isMaintenanceMode(): ?bool
    {
        return $this->maintenanceMode;
    }

    public function setMaintenanceMode(bool $maintenanceMode): static
    {
        $this->maintenanceMode = $maintenanceMode;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function __toString(): string
    {
        return $this->siteName ?? 'Site Settings';
    }
}
