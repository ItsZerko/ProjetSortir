<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SortieRepository")
 */
class Sortie
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
     * @ORM\Column(type="datetime")
     */
    private $dateHeureDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLimiteInscription;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbInscriptionMax;

    /**
     * @ORM\Column(type="text")
     */
    private $infoSortie;

    /**
<<<<<<< HEAD

=======
>>>>>>> e6ba983c817ab97d471257ce639f915d7d9d53f4
     * @ORM\Column(type="string", length=255)
     */
         private $etat;


    public function getEtat(): string
    {
        return $this->etat;
    }


    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * @param mixed $sortie
     */
    public function setSortie($sortie): void
    {
        $this->sortie = $sortie;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", inversedBy="organisateur")
     */
    private $sortie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="id_sortie")
     */
    private $id_inscr;

    public function __construct()
    {
        $this->id_inscr = new ArrayCollection();
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

    public function getDateHeureDebut(): ?\DateTime
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTime $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionMax(): ?int
    {
        return $this->nbInscriptionMax;
    }

    public function setNbInscriptionMax(int $nbInscriptionMax): self
    {
        $this->nbInscriptionMax = $nbInscriptionMax;

        return $this;
    }

    public function getInfoSortie(): ?string
    {
        return $this->infoSortie;
    }

    public function setInfoSortie(string $infoSortie): self
    {
        $this->infoSortie = $infoSortie;

        return $this;
    }

<<<<<<< HEAD



=======

    /**
     * @return mixed
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * @param mixed $sortie
     */
    public function setSortie($sortie): void
    {
        $this->sortie = $sortie;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getIdInscr(): Collection
    {
        return $this->id_inscr;
    }

    public function addIdInscr(Inscription $idInscr): self
    {
        if (!$this->id_inscr->contains($idInscr)) {
            $this->id_inscr[] = $idInscr;
            $idInscr->setIdSortie($this);
        }

        return $this;
    }

    public function removeIdInscr(Inscription $idInscr): self
    {
        if ($this->id_inscr->contains($idInscr)) {
            $this->id_inscr->removeElement($idInscr);
            // set the owning side to null (unless already changed)
            if ($idInscr->getIdSortie() === $this) {
                $idInscr->setIdSortie(null);
            }
        }

        return $this;
    }


    public function getEtat():string
    {
        return $this->etat;
    }


    public function setEtat($etat)
    {
        $this->etat = $etat;
    }
>>>>>>> e6ba983c817ab97d471257ce639f915d7d9d53f4
}
