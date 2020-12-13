<?php

namespace App\Entity;

use App\Repository\BriefRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $contexte;

    /**
     * @ORM\Column(type="date")
     */
    private $datePoste;

    /**
     * @ORM\Column(type="date")
     */
    private $dateLimite;

    /**
     * @ORM\Column(type="text")
     */
    private $listeLivrable;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionRapide;

    /**
     * @ORM\Column(type="text")
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="text")
     */
    private $cricterePerformance;

    /**
     * @ORM\Column(type="text")
     */
    private $modaliteEvaluation;

    /**
     * @ORM\Column(type="blob")
     */
    private $imageExemplaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getDatePoste(): ?\DateTimeInterface
    {
        return $this->datePoste;
    }

    public function setDatePoste(\DateTimeInterface $datePoste): self
    {
        $this->datePoste = $datePoste;

        return $this;
    }

    public function getDateLimite(): ?\DateTimeInterface
    {
        return $this->dateLimite;
    }

    public function setDateLimite(\DateTimeInterface $dateLimite): self
    {
        $this->dateLimite = $dateLimite;

        return $this;
    }

    public function getListeLivrable(): ?string
    {
        return $this->listeLivrable;
    }

    public function setListeLivrable(string $listeLivrable): self
    {
        $this->listeLivrable = $listeLivrable;

        return $this;
    }

    public function getDescriptionRapide(): ?string
    {
        return $this->descriptionRapide;
    }

    public function setDescriptionRapide(string $descriptionRapide): self
    {
        $this->descriptionRapide = $descriptionRapide;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

        return $this;
    }

    public function getCricterePerformance(): ?string
    {
        return $this->cricterePerformance;
    }

    public function setCricterePerformance(string $cricterePerformance): self
    {
        $this->cricterePerformance = $cricterePerformance;

        return $this;
    }

    public function getModaliteEvaluation(): ?string
    {
        return $this->modaliteEvaluation;
    }

    public function setModaliteEvaluation(string $modaliteEvaluation): self
    {
        $this->modaliteEvaluation = $modaliteEvaluation;

        return $this;
    }

    public function getImageExemplaire()
    {
        return $this->imageExemplaire;
    }

    public function setImageExemplaire($imageExemplaire): self
    {
        $this->imageExemplaire = $imageExemplaire;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
