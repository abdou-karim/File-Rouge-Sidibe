<?php

namespace App\Entity;

use App\Repository\ReferentielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
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
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $crictereAdmission;

    /**
     * @ORM\Column(type="text")
     */
    private $crictereEvaluation;

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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCrictereAdmission(): ?string
    {
        return $this->crictereAdmission;
    }

    public function setCrictereAdmission(string $crictereAdmission): self
    {
        $this->crictereAdmission = $crictereAdmission;

        return $this;
    }

    public function getCrictereEvaluation(): ?string
    {
        return $this->crictereEvaluation;
    }

    public function setCrictereEvaluation(string $crictereEvaluation): self
    {
        $this->crictereEvaluation = $crictereEvaluation;

        return $this;
    }
}
