<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(type:'boolean')]
    private $is_Verified =false;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $typeNotif = null;

    #[ORM\ManyToMany(targetEntity: NotifClient::class, inversedBy: 'lesUsers')]
    private Collection $lesNotifsUser;

    #[ORM\ManyToOne(inversedBy: 'lesUsers')]
    private ?Casier $leCasier = null;


    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commande::class)]
    private Collection $commandes;

    #[ORM\ManyToMany(targetEntity: CentreRelais::class, mappedBy: 'lesUser')]
    private Collection $centreRelais;

    public function __construct()
    {
        $this->lesNotifsUser = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->centreRelais = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
    public function getIsVerified(): ?bool
    {
        return $this->is_Verified;
    }
    public function setIsVerified(bool $is_verified): static
    {
        $this->is_Verified = $is_verified;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTypeNotif(): ?string
    {
        return $this->typeNotif;
    }

    public function setTypeNotif(string $typeNotif): static
    {
        $this->typeNotif = $typeNotif;

        return $this;
    }

    /**
     * @return Collection<int, NotifClient>
     */
    public function getLesNotifsUser(): Collection
    {
        return $this->lesNotifsUser;
    }

    public function averLesNotifsUser(NotifClient $lesNotifsUser): static
    {
        if (!$this->lesNotifsUser->contains($lesNotifsUser)) {
            $this->lesNotifsUser->add($lesNotifsUser);
        }

        return $this;
    }

    public function removeLesNotifsUser(NotifClient $lesNotifsUser): static
    {
        $this->lesNotifsUser->removeElement($lesNotifsUser);

        return $this;
    }

    public function getLeCasier(): ?Casier
    {
        return $this->leCasier;
    }

    public function setLeCasier(?Casier $leCasier): static
    {
        $this->leCasier = $leCasier;

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }
    public function historicCommande(): Collection
    {
        $commandes = $this->getCommandes();
    
        $commandes = $commandes->toArray();
       
    
        return new ArrayCollection($commandes);
    }

    /**
     * @return Collection<int, CentreRelais>
     */
    public function getCentreRelais(): Collection
    {
        return $this->centreRelais;
    }

    public function addCentreRelai(CentreRelais $centreRelai): static
    {
        if (!$this->centreRelais->contains($centreRelai)) {
            $this->centreRelais->add($centreRelai);
            $centreRelai->addLesUser($this);
        }

        return $this;
    }

    public function removeCentreRelai(CentreRelais $centreRelai): static
    {
        if ($this->centreRelais->removeElement($centreRelai)) {
            $centreRelai->removeLesUser($this);
        }

        return $this;
    }
    
}
