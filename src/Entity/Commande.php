<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $poid = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $estimationLivraison = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column]
    private ?float $longueur = null;

    #[ORM\Column]
    private ?float $largeur = null;

    #[ORM\Column]
    private ?float $hauteur = null;

    #[ORM\OneToMany(mappedBy: 'laCommande', targetEntity: Etat::class)]
    private Collection $lesEtats;

    #[ORM\ManyToMany(targetEntity: NotifClient::class, inversedBy: 'lesCommandes')]
    private Collection $lesNotifsClient;

    #[ORM\Column]
    private ?int $Etat = null;

    #[ORM\ManyToOne(inversedBy: 'lesCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Casier $Casier = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CentreRelais $centreRelais = null;

    #[ORM\ManyToOne(inversedBy: 'Commande')]
    private ?Evaluation $evaluation = null;

    public function __construct()
    {
        $this->lesEtats = new ArrayCollection();
        $this->lesNotifsClient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoid(): ?float
    {
        return $this->poid;
    }

    public function setPoid(float $poid): static
    {
        $this->poid = $poid;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getEstimationLivraison(): ?\DateTimeInterface
    {
        return $this->estimationLivraison;
    }

    public function setEstimationLivraison(\DateTimeInterface $estimationLivraison): static
    {
        $this->estimationLivraison = $estimationLivraison;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

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

    /**
     * @return Collection<int, Etat>
     */
    public function getLesEtats(): Collection
    {
        return $this->lesEtats;
    }

    public function addLesEtat(Etat $lesEtat): static
    {
        if (!$this->lesEtats->contains($lesEtat)) {
            $this->lesEtats->add($lesEtat);
            $lesEtat->setLaCommande($this);
        }

        return $this;
    }

    public function removeLesEtat(Etat $lesEtat): static
    {
        if ($this->lesEtats->removeElement($lesEtat)) {
            // set the owning side to null (unless already changed)
            if ($lesEtat->getLaCommande() === $this) {
                $lesEtat->setLaCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NotifClient>
     */
    public function getLesNotifsClient(): Collection
    {
        return $this->lesNotifsClient;
    }

    public function addLesNotifsClient(NotifClient $lesNotifsClient): static
    {
        if (!$this->lesNotifsClient->contains($lesNotifsClient)) {
            $this->lesNotifsClient->add($lesNotifsClient);
        }

        return $this;
    }

    public function removeLesNotifsClient(NotifClient $lesNotifsClient): static
    {
        $this->lesNotifsClient->removeElement($lesNotifsClient);

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->Etat;
    }

    public function setEtat(int $Etat): static
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getCasier(): ?Casier
    {
        return $this->Casier;
    }

    public function setCasier(?Casier $Casier): static
    {
        $this->Casier = $Casier;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCentreRelais(): ?CentreRelais
    {
        return $this->centreRelais;
    }

    public function setCentreRelais(?CentreRelais $centreRelais): static
    {
        $this->centreRelais = $centreRelais;

        return $this;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }
}
