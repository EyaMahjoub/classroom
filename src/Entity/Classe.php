<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    /**
     * @var Collection<int, fichier>
     */
    #[ORM\OneToMany(targetEntity: fichier::class, mappedBy: 'classe')]
    private Collection $fichier;

    /**
     * @var Collection<int, cours>
     */
    #[ORM\OneToMany(targetEntity: cours::class, mappedBy: 'classe')]
    private Collection $cours;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?enseignant $enseignant = null;

    public function __construct()
    {
        $this->fichier = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, fichier>
     */
    public function getFichier(): Collection
    {
        return $this->fichier;
    }

    public function addFichier(fichier $fichier): static
    {
        if (!$this->fichier->contains($fichier)) {
            $this->fichier->add($fichier);
            $fichier->setClasse($this);
        }

        return $this;
    }

    public function removeFichier(fichier $fichier): static
    {
        if ($this->fichier->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getClasse() === $this) {
                $fichier->setClasse(null);
            }
        }

        return $this;
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
            $cour->setClasse($this);
        }

        return $this;
    }

    public function removeCour(cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getClasse() === $this) {
                $cour->setClasse(null);
            }
        }

        return $this;
    }

    public function getEnseignant(): ?enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?enseignant $enseignant): static
    {
        $this->enseignant = $enseignant;

        return $this;
    }
}
