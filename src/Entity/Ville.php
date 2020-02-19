<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;

    /**
     * @var Lieu[]
     * @ORM\OneToMany(targetEntity="App\Entity\Lieu", mappedBy="ville", orphanRemoval=true, cascade={"remove"})
     */
    private $lieus;

    public function __construct()
    {
        $this->lieus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection|Lieu[]
     */
    public function getLieus(): Collection
    {
        return $this->lieus;
    }

    public function addLieus(Lieu $lieus): self
    {
        if (!$this->lieus->contains($lieus)) {
            $this->lieus[] = $lieus;
            $lieus->setVille($this);
        }

        return $this;
    }

    public function removeLieus(Lieu $lieus): self
    {
        if ($this->lieus->contains($lieus)) {
            $this->lieus->removeElement($lieus);
            // set the owning side to null (unless already changed)
            if ($lieus->getVille() === $this) {
                $lieus->setVille(null);
            }
        }

        return $this;
    }


    public function isSupprimableVille(Participant $participant)
    {
        foreach ($this->lieus as $lieu) {
            if ($lieu->getSorties()->count() > 0) {
                return false;
            }
        }

        if (!in_array('ROLE_ADMIN', $participant->getRoles())) {
            return false;
        }

        return true;
    }

    public function isModifiableVille(Participant $participant)
    {
        foreach ($this->lieus as $lieu) {
            if ($lieu->getSorties()->count() > 0) {
                return false;
            }
        }

        if (!in_array('ROLE_ADMIN', $participant->getRoles())) {
            return false;
        }

        return true;
    }

}
