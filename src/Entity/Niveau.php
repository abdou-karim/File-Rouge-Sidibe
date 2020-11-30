<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 * @ApiResource()
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"competence:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:read","competence:write"})
     * @groups({"GroupeCompetences:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:read","competence:write"})
     * @Groups({"GroupeCompetences:write"})
     */
    private $crictereDevaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:read","competence:write"})
     * @groups({"GroupeCompetences:write"})
     */
    private $groupeDaction;

    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="niveaux",cascade = { "persist" })
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
