<?php

namespace App\Entity;

use App\Repository\RetoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetoursRepository::class)]
class Retours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Commentaire = null;

    #[ORM\Column]
    private ?int $idCli = null;

    #[ORM\Column]
    private ?int $idCommande = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(?string $Commentaire): static
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

    public function getIdCli(): ?int
    {
        return $this->idCli;
    }

    public function setIdCli(int $idCli): static
    {
        $this->idCli = $idCli;

        return $this;
    }

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function setIdCommande(int $idCommande): static
    {
        $this->idCommande = $idCommande;

        return $this;
    }
}
