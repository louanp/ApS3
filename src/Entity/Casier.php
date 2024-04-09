<?php

namespace App\Entity;

use App\Repository\CasierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CasierRepository::class)]
class Casier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $disponibilite = null;

    #[ORM\Column(length: 255)]
    private ?string $lib = null;

    #[ORM\Column]
    private ?float $longueur = null;

    #[ORM\Column]
    private ?float $largeur = null;

    #[ORM\Column]
    private ?float $hauteur = null;

    #[ORM\ManyToOne(inversedBy: 'lesCasiers')]
    private ?CentreRelais $leCentreRelais = null;

    #[ORM\OneToMany(mappedBy: 'leCasier', targetEntity: User::class)]
    private Collection $lesUsers;

    #[ORM\OneToMany(mappedBy: 'Casier', targetEntity: Commande::class)]
    private Collection $lesCommandes;

    public function __construct()
    {
        $this->lesUsers = new ArrayCollection();
        $this->lesCommandes = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getLib(): ?string
    {
        return $this->lib;
    }

    public function setLib(string $lib): static
    {
        $this->lib = $lib;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): static
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(float $largeur): static
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?float
    {
        return $this->hauteur;
    }

    public function setHauteur(float $hauteur): static
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getLeCentreRelais(): ?CentreRelais
    {
        return $this->leCentreRelais;
    }

    public function setLeCentreRelais(?CentreRelais $leCentreRelais): static
    {
        $this->leCentreRelais = $leCentreRelais;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLesUsers(): Collection
    {
        return $this->lesUsers;
    }

    public function addLesUser(User $lesUser): static
    {
        if (!$this->lesUsers->contains($lesUser)) {
            $this->lesUsers->add($lesUser);
            $lesUser->setLeCasier($this);
        }

        return $this;
    }

    public function removeLesUser(User $lesUser): static
    {
        if ($this->lesUsers->removeElement($lesUser)) {
            // set the owning side to null (unless already changed)
            if ($lesUser->getLeCasier() === $this) {
                $lesUser->setLeCasier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getLesCommandes(): Collection
    {
        return $this->lesCommandes;
    }

    public function addLesCommande(Commande $lesCommande): static
    {
        if (!$this->lesCommandes->contains($lesCommande)) {
            $this->lesCommandes->add($lesCommande);
            $lesCommande->setCasier($this);
        }

        return $this;
    }

    public function removeLesCommande(Commande $lesCommande): static
    {
        if ($this->lesCommandes->removeElement($lesCommande)) {
            // set the owning side to null (unless already changed)
            if ($lesCommande->getCasier() === $this) {
                $lesCommande->setCasier(null);
            }
        }

        return $this;
    }
    
}
