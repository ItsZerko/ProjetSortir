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
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="sortieSite")
     */
    private $sites;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="id_sortie")
     */
    private $idInscr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    public function __construct()
    {
        $this->idInscr = new ArrayCollection();
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


    /**
     * @return Collection|Inscription[]
     */
    public function getIdInscr(): Collection
    {
        return $this->idInscr;
    }

    public function addIdInscr(Inscription $idInscr): self
    {
        if (!$this->idInscr->contains($idInscr)) {
            $this->idInscr[] = $idInscr;
            $idInscr->setIdSortie($this);
        }
        return $this;
    }

    public function removeIdInscr(Inscription $idInscr): self
    {
        if ($this->idInscr->contains($idInscr)) {
            $this->idInscr->removeElement($idInscr);
            // set the owning side to null (unless already changed)
            if ($idInscr->getIdSortie() === $this) {
                $idInscr->setIdSortie(null);
            }
        }
        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param mixed $sites
     */
    public function setSites($sites): void
    {
        $this->sites = $sites;
    }
}

