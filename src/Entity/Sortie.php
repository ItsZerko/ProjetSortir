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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", inversedBy="sorties", cascade={"remove"})
     */
    private $organisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="sortieSite")
     */
    private $sites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="id_sortie", cascade={"remove"})
     */
    private $idInscr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="sorties", cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\Column(type="text")
     * @ORM\JoinColumn(nullable=true)
<<<<<<< HEAD
     *
=======
>>>>>>> ad2249823798c863625bfa222e512bda69ab5adc
     */
    private $motifAnnulation;


    public function __construct()
    {
        $this->idInscr = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }



    public function getEtat(): string
    {
        return $this->etat;
    }


    public function setEtat($etat)
    {
        $this->etat = $etat;
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


    public function getSites(): ?Site
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


    public function getMotifAnnulation(): ?string
    {
        return $this->motifAnnulation;
    }

    public function setMotifAnnulation(string $motifAnnulation): self
    {
        $this->motifAnnulation = $motifAnnulation;

        return $this;
    }


    public function isSuppSortie()
    {

        if ($this->idInscr->count() > 0) {
            return false;
        }
        return true;
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



}

