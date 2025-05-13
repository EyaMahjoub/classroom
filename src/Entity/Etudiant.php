<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $imageProfile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'etudiant')]
    private Collection $inscription;

    /**
     * @var Collection<int, commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'etudiant')]
    private Collection $commentaire;

    /**
     * @var Collection<int, notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'etudiant')]
    private Collection $notification;

    /**
     * @var Collection<int, soumissionDevoire>
     */
    #[ORM\OneToMany(targetEntity: SoumissionDevoire::class, mappedBy: 'etudiant')]
    private Collection $soumissionDevoire;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'Etudiant')]
    private Collection $classes;

    public function __construct()
    {
        $this->inscription = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
        $this->notification = new ArrayCollection();
        $this->soumissionDevoire = new ArrayCollection();
        $this->classes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getImageProfile(): ?string
    {
        return $this->imageProfile;
    }

    public function setImageProfile(string $imageProfile): static
    {
        $this->imageProfile = $imageProfile;

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

    /**
     * @return Collection<int, inscription>
     */
    public function getInscription(): Collection
    {
        return $this->inscription;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription->add($inscription);
            $inscription->setEtudiant($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscription->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEtudiant() === $this) {
                $inscription->setEtudiant(null);
            }
        }

        return $this;
    }
 public function getThreeInscribedClasses(): array
    {
        return array_slice($this->classes->toArray(), 0, 3);
    }
    /**
     * @return Collection<int, commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setEtudiant($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEtudiant() === $this) {
                $commentaire->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, notification>
     */
    public function getNotification(): Collection
    {
        return $this->notification;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notification->contains($notification)) {
            $this->notification->add($notification);
            $notification->setEtudiant($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notification->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getEtudiant() === $this) {
                $notification->setEtudiant(null);
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
            $soumissionDevoire->setEtudiant($this);
        }

        return $this;
    }

    public function removeSoumissionDevoire(SoumissionDevoire $soumissionDevoire): static
    {
        if ($this->soumissionDevoire->removeElement($soumissionDevoire)) {
            // set the owning side to null (unless already changed)
            if ($soumissionDevoire->getEtudiant() === $this) {
                $soumissionDevoire->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->addEtudiant($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): static
    {
        if ($this->classes->removeElement($class)) {
            $class->removeEtudiant($this);
        }

        return $this;
    }
}
