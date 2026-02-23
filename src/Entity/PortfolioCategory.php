<?php

namespace App\Entity;

use App\Repository\PortfolioCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioCategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PortfolioCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $isActive = true;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, PortfolioItem>
     */
    #[ORM\OneToMany(targetEntity: PortfolioItem::class, mappedBy: 'category')]
    private Collection $portfolioItems;

    public function __construct()
    {
        $this->portfolioItems = new ArrayCollection();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;
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

    /**
     * @return Collection<int, PortfolioItem>
     */
    public function getPortfolioItems(): Collection
    {
        return $this->portfolioItems;
    }

    public function addPortfolioItem(PortfolioItem $portfolioItem): static
    {
        if (!$this->portfolioItems->contains($portfolioItem)) {
            $this->portfolioItems->add($portfolioItem);
            $portfolioItem->setCategory($this);
        }

        return $this;
    }

    public function removePortfolioItem(PortfolioItem $portfolioItem): static
    {
        if ($this->portfolioItems->removeElement($portfolioItem)) {
            // set the owning side to null (unless already changed)
            if ($portfolioItem->getCategory() === $this) {
                $portfolioItem->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
