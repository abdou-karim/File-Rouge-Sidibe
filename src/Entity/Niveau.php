<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
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
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $crictereDevaluation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $groupeDaction;

    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="niveaux")
     */
    private $competence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCrictereDevaluation(): ?string
    {
        return $this->crictereDevaluation;
    }

    public function setCrictereDevaluation(string $crictereDevaluation): self
    {
        $this->crictereDevaluation = $crictereDevaluation;

        return $this;
    }

    public function getGroupeDaction(): ?string
    {
        return $this->groupeDaction;
    }

    public function setGroupeDaction(string $groupeDaction): self
    {
        $this->groupeDaction = $groupeDaction;

        return $this;
    }

    public function getCompetence(): ?Competences
    {
        return $this->competence;
    }

    public function setCompetence(?Competences $competence): self
    {
        $this->competence = $competence;

        return $this;
    }
}
