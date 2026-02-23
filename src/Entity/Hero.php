<?php

namespace App\Entity;

use App\Repository\HeroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HeroRepository::class)]

#[ORM\HasLifecycleCallbacks] // <-- essentiel pour PrePersist / PreUpdate
class Hero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $updatedAt = null;

    /**
     * @var Collection<int, HeroJob>
     */
   #[ORM\OneToMany(mappedBy: 'hero', targetEntity: HeroJob::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $heroJobs;

   /**
    * @var Collection<int, About>
    */
   #[ORM\OneToMany(targetEntity: About::class, mappedBy: 'hero')]
   private Collection $abouts;

   #[ORM\Column(length: 255)]
   private ?string $profileImage = null;

    public function __construct()
    {
        $this->heroJobs = new ArrayCollection();
        $this->isActive = true; // optionnel
        $this->abouts = new ArrayCollection();
    }

    // === Getters / Setters ===
    public function getId(): ?int { return $this->id; }
    public function getFullname(): ?string { return $this->fullname; }
    public function setFullname(string $fullname): static { $this->fullname = $fullname; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(string $image): static { $this->image = $image; return $this; }

    public function isActive(): ?bool { return $this->isActive; }
    public function setIsActive(bool $isActive): static { $this->isActive = $isActive; return $this; }

    public function getCreatedAt(): ?\DateTime { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTime { return $this->updatedAt; }

    /**
     * @return Collection<int, HeroJob>
     */
    public function getHeroJobs(): Collection { return $this->heroJobs; }

    public function addHeroJob(HeroJob $heroJob): static
    {
        if (!$this->heroJobs->contains($heroJob)) {
            $this->heroJobs->add($heroJob);
            $heroJob->setHero($this);
        }
        return $this;
    }

    public function removeHeroJob(HeroJob $heroJob): static
    {
        if ($this->heroJobs->removeElement($heroJob)) {
            if ($heroJob->getHero() === $this) {
                $heroJob->setHero(null);
            }
        }
        return $this;
    }

    // ================= LIFECYCLE CALLBACKS =================
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function __toString(): string
    {
        return $this->fullname ?? '';
    }

    /**
     * @return Collection<int, About>
     */
    public function getAbouts(): Collection
    {
        return $this->abouts;
    }

    public function addAbout(About $about): static
    {
        if (!$this->abouts->contains($about)) {
            $this->abouts->add($about);
            $about->setHero($this);
        }

        return $this;
    }

    public function removeAbout(About $about): static
    {
        if ($this->abouts->removeElement($about)) {
            // set the owning side to null (unless already changed)
            if ($about->getHero() === $this) {
                $about->setHero(null);
            }
        }

        return $this;
    }

    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    public function setProfileImage(string $profileImage): static
    {
        $this->profileImage = $profileImage;

        return $this;
    }
}
