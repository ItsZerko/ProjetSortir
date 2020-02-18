<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 */
class Site
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
     * @ORM\OneToMany(targetEntity="App\Entity\Participant", mappedBy="site")
     * Cas possible cascade={"remove"}
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="sites")
     */
    private $sortieSite;

    public function __construct()
    {
        $this->sortieSite = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants($participants): void
    {
        $this->participants = $participants;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getSortieSite(): Collection
    {
        return $this->sortieSite;
    }

    public function addSortieSite(Sortie $sortieSite): self
    {
        if (!$this->sortieSite->contains($sortieSite)) {
            $this->sortieSite[] = $sortieSite;
            $sortieSite->setSites($this);
        }

        return $this;
    }

    public function removeSortieSite(Sortie $sortieSite): self
    {
        if ($this->sortieSite->contains($sortieSite)) {
            $this->sortieSite->removeElement($sortieSite);
            // set the owning side to null (unless already changed)
            if ($sortieSite->getSites() === $this) {
                $sortieSite->setSites(null);
            }
        }

        return $this;
    }
}
