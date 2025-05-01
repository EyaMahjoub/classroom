<?php

namespace App\Entity;
use App\Entity\SoumissionDevoire;
use App\Repository\DevoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevoireRepository::class)]
class Devoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, cours>
     */
    #[ORM\OneToMany(targetEntity: cours::class, mappedBy: 'devoire')]
    private Collection $cours;

    /**
     * @var Collection<int, soumissionDevoire>
     */
    #[ORM\OneToMany(targetEntity: soumissionDevoire::class, mappedBy: 'devoire')]
    private Collection $soumissionDevoire;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $deadline = null;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->soumissionDevoire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setDevoire($this);
        }

        return $this;
    }

    public function removeCour(cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getDevoire() === $this) {
                $cour->setDevoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, soumissionDevoire>
     */
    public function getSoumissionDevoire(): Collection
    {
        return $this->soumissionDevoire;
    }

    public function addSoumissionDevoire(SoumissionDevoire $soumissionDevoire): static
    {
        if (!$this->soumissionDevoire->contains($soumissionDevoire)) {
            $this->soumissionDevoire->add($soumissionDevoire);
            $soumissionDevoire->setDevoire($this);
        }

        return $this;
    }

    public function removeSoumissionDevoire(SoumissionDevoire $soumissionDevoire): static
    {
        if ($this->soumissionDevoire->removeElement($soumissionDevoire)) {
            // set the owning side to null (unless already changed)
            if ($soumissionDevoire->getDevoire() === $this) {
                $soumissionDevoire->setDevoire(null);
            }
        }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeadline(): ?\DateTimeImmutable
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeImmutable $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }
}
