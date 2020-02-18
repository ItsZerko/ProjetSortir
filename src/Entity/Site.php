<?php

namespace App\Entity;

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
     * @return mixed
     */
    public function getSortieSite()
    {
        return $this->sortieSite;
    }

    /**
     * @param mixed $sortieSite
     */
    public function setSortieSite($sortieSite): void
    {
        $this->sortieSite = $sortieSite;
    }
}
