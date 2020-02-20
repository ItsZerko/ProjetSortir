<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", inversedBy="id_insc")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_participant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sortie", inversedBy="idInscr")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_sortie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTime
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTime $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getIdParticipant(): ?Participant
    {
        return $this->id_participant;
    }

    public function setIdParticipant(?Participant $id_participant): self
    {
        $this->id_participant = $id_participant;

        return $this;
    }

    public function getIdSortie(): ?Sortie
    {
        return $this->id_sortie;
    }

    public function setIdSortie(?Sortie $id_sortie): self
    {
        $this->id_sortie = $id_sortie;

        return $this;
    }
}
