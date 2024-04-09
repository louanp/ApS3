<?php

namespace App\Entity;

use App\Repository\NotifClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifClientRepository::class)]
class NotifClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lib = null;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'lesNotifsClient')]
    private Collection $lesCommandes;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'lesNotifsUser')]
    private Collection $lesUsers;

    public function __construct()
    {
        $this->lesClients = new ArrayCollection();
        $this->lesCommandes = new ArrayCollection();
        $this->lesUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $lesCommande->addLesNotifsClient($this);
        }

        return $this;
    }

    public function removeLesCommande(Commande $lesCommande): static
    {
        if ($this->lesCommandes->removeElement($lesCommande)) {
            $lesCommande->removeLesNotifsClient($this);
        }

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
            $lesUser->addLesNotifsUser($this);
        }

        return $this;
    }

    public function removeLesUser(User $lesUser): static
    {
        if ($this->lesUsers->removeElement($lesUser)) {
            $lesUser->removeLesNotifsUser($this);
        }

        return $this;
    }
}
