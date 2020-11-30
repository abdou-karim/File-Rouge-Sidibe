<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 * @ApiResource(
 *     routePrefix="/admin",
 *     normalizationContext={"groups"={"GroupeCompetences:read"}},
 *     denormalizationContext={"groups"={"GroupeCompetences:write"}},
 *     collectionOperations={
 *                   "GET",
 *                   "POST",
 *     },
 *     itemOperations={
 *            "GET"={
 *     "path"="/groupe_competences/{id}/competences",
 *     "security" = "is_granted('GROUPE_COMPETENCE_READ', object)"},
 *     "GET"={"path"="/groupe_competences/{id}",
 *     "security" = "is_granted('GROUPE_COMPETENCE_READ', object)"},
 *     },
 *       attributes={
 *              "pagination_enabled"=true,
 *              "pagination_items_per_page"=3
 *     },
 * )
 */
class GroupeCompetences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @group({"GroupeCompetences:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:write"})
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:write"})
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="groupeCompetences",cascade = { "persist" })
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     * @ApiSubresource
     */
    private $competence;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="groupeCompetence")
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     */
    private $tags;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Competences[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeGroupeCompetence($this);
        }

        return $this;
    }
}
