<?php

namespace App\Entity;

use App\Repository\NotifRelaisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifRelaisRepository::class)]
class NotifRelais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lib = null;

    #[ORM\ManyToOne(inversedBy: 'lesNotifsRelais')]
    private ?CentreRelais $leCentreRelais = null;

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

    public function getLeCentreRelais(): ?CentreRelais
    {
        return $this->leCentreRelais;
    }

    public function setLeCentreRelais(?CentreRelais $leCentreRelais): static
    {
        $this->leCentreRelais = $leCentreRelais;

        return $this;
    }
}
