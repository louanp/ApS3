<?php

namespace App\Entity;

use App\Repository\CentreRelaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use DateTime;
use DateInterval;

#[ORM\Entity(repositoryClass: CentreRelaisRepository::class)]
class CentreRelais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column]
    private ?int $pourcentagecasierutil ;

    #[ORM\Column]
    private ?int $totalCommande = null;

    #[ORM\OneToMany(mappedBy: 'leCentreRelais', targetEntity: NotifRelais::class)]
    private Collection $lesNotifsRelais;

    #[ORM\OneToMany(mappedBy: 'leCentreRelais', targetEntity: Casier::class, orphanRemoval: true)]
    private Collection $lesCasiers;

    #[ORM\Column(length: 255)]
    private ?string $Ville = null;
    

    #[ORM\Column(length: 255)]
    private ?string $Pays = null;

    #[ORM\OneToMany(mappedBy: 'centreRelais', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;


    public function __construct()
    {
        $this->lesNotifsRelais = new ArrayCollection();
        $this->lesCasiers = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->retours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }
    public function getpourcentage(): ?int
    {
        $touslescasier= $this->getLesCasiers();
        $totalcasier= 0;
        foreach($touslescasier as $lacasier)
        {
            $totalcasier +=1;
        }
        $touslescommande= $this->getCommandes();
        $totalcommande=0;
        foreach($touslescommande as $lacommande)
        {
            if($lacommande->getEtat()<4)
            {
                $totalcommande +=1;
            }
        }
        if ($totalcommande==0)
        {
            $this->pourcentagecasierutil = 0;
        }
        else
        {
            $this->pourcentagecasierutil = ($totalcommande *100)/$totalcasier; 
        }
        
        return $this->pourcentagecasierutil;
    }

    public function setpourcentage(int $pourcentage): static
    {
        $this->pourcentagecasierutil = $pourcentage;

        return $this;
    }
    public function getTotalcommande(): ?int
    {
        $touslescommande= $this->getCommandes();
        $tot= 0;
        foreach($touslescommande as $lacommande)
        {
            $tot+=1;
        }
        $this->totalCommande = $tot;
        return $this->totalCommande;
    }

    public function setTotalcommande(int $total): static
    {
        $this->capacite = $total;

        return $this;
    }

    /**
     * @return Collection<int, NotifRelais>
     */
    public function getLesNotifsRelais(): Collection
    {
        return $this->lesNotifsRelais;
    }

    public function addLesNotifsRelai(NotifRelais $lesNotifsRelai): static
    {
        if (!$this->lesNotifsRelais->contains($lesNotifsRelai)) {
            $this->lesNotifsRelais->add($lesNotifsRelai);
            $lesNotifsRelai->setLeCentreRelais($this);
        }

        return $this;
    }

    public function removeLesNotifsRelai(NotifRelais $lesNotifsRelai): static
    {
        if ($this->lesNotifsRelais->removeElement($lesNotifsRelai)) {
            // set the owning side to null (unless already changed)
            if ($lesNotifsRelai->getLeCentreRelais() === $this) {
                $lesNotifsRelai->setLeCentreRelais(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Casier>
     */
    public function getLesCasiers(): Collection
    {
        return $this->lesCasiers;
    }

    public function addLesCasier(Casier $lesCasier): static
    {
        if (!$this->lesCasiers->contains($lesCasier)) {
            $this->lesCasiers->add($lesCasier);
            $lesCasier->setLeCentreRelais($this);
        }

        return $this;
    }

    public function removeLesCasier(Casier $lesCasier): static
    {
        if ($this->lesCasiers->removeElement($lesCasier)) {
            // set the owning side to null (unless already changed)
            if ($lesCasier->getLeCentreRelais() === $this) {
                $lesCasier->setLeCentreRelais(null);
            }
        }

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(string $Pays): static
    {
        $this->Pays = $Pays;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setCentreRelais($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getCentreRelais() === $this) {
                $commande->setCentreRelais(null);
            }
        }

        return $this;
    }

      public function getAvgTime(CentreRelais $centreRelais): ?DateInterval
{
    $totalSeconds = 0;
    $totalOrders = 0;

    foreach ($this->commandes as $commande) {
        $dateCommande = $commande->getDateCommande();
        $dateEstimationLivraison = $commande->getEstimationLivraison();

        $interval = $dateCommande->diff($dateEstimationLivraison);

        $totalSeconds += $interval->s + $interval->i * 60 + $interval->h * 3600 + $interval->d * 86400;

        $totalOrders++;
    }

    if ($totalOrders > 0) {
        $averageTimeInSeconds = $totalSeconds / $totalOrders;

        return DateInterval::createFromDateString($averageTimeInSeconds . ' seconds');
    }

    return null; 
}




    
}
