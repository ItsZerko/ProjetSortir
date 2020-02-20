<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 * @UniqueEntity("mail")
 * @UniqueEntity("username")
 */
class Participant implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", length=255, nullable=false)
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=4, minMessage="Votre username doit faire au moins 4 caractères")
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="participants")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $site;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     * @Assert\Email
     */
    private $mail;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;


    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au moins 8 caractères")
     * @Assert\EqualTo(propertyPath="password", message="Mot de passe différent")
     */
    public $passwordVerif;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="sortie")
     */
    private $organisateur;

    /**
     * @var Collection|Inscription[]
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="id_participant")
     */
    private $id_insc;

    public function __construct()
    {
        $this->id_insc = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPasswordVerif()
    {
        return $this->passwordVerif;
    }

    /**
     * @param mixed $passwordVerif
     */
    public function setPasswordVerif($passwordVerif): void
    {
        $this->passwordVerif = $passwordVerif;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }


    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }


    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }


    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @param mixed $password
     * @return Participant
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site): void
    {
        $this->site = $site;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getIdInsc(): Collection
    {
        return $this->id_insc;
    }

    public function addIdInsc(Inscription $idInsc): self
    {
        if (!$this->id_insc->contains($idInsc)) {
            $this->id_insc[] = $idInsc;
            $idInsc->setIdParticipant($this);
        }

        return $this;
    }

    public function removeIdInsc(Inscription $idInsc): self
    {
        if ($this->id_insc->contains($idInsc)) {
            $this->id_insc->removeElement($idInsc);
            // set the owning side to null (unless already changed)
            if ($idInsc->getIdParticipant() === $this) {
                $idInsc->setIdParticipant(null);
            }
        }

        return $this;
    }

    public function isInscrit(Sortie $sortie): bool
    {
        foreach ($this->id_insc as $inscription) {
            if ($inscription->getIdSortie() == $sortie) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param mixed $organisateur
     */
    public function setOrganisateur($organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    public function isSupprimable()
    {
        if (in_array('ROLE_ADMIN', $this->getRoles())) {
            return false;
        }

        if ($this->id_insc->count() > 0) {
            return false;
        }

        return true;
    }
}
