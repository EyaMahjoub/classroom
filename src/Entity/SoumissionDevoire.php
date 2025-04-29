<?php

namespace App\Entity;

use App\Repository\SoumissionDevoireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoumissionDevoireRepository::class)]
class SoumissionDevoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'soumissionDevoire')]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'soumissionDevoire')]
    private ?Devoire $devoire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

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

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getDevoire(): ?Devoire
    {
        return $this->devoire;
    }

    public function setDevoire(?Devoire $devoire): static
    {
        $this->devoire = $devoire;

        return $this;
    }
}
