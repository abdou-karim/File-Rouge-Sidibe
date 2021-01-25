<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ApiResource(
 *     routePrefix="/admin",
 *     normalizationContext={"groups"={"GroupeCompetences:read"}},
 *     denormalizationContext={"groups"={"GroupeCompetences:write"}},
 *     collectionOperations={
 *                   "GET"={
 *                  "security"= "is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager') or is_granted('ROLE_Apprenant') or is_granted('ROLE_Administrateur')",
 *                      "path"="/groupe_competences",
 *     },
 *                   "POST"={
 *                  "path"="/groupe_competences",
 *                  "security"= "is_granted('ROLE_Administrateur')",
 *     },
 *     },
 *     itemOperations={
 *     "PUT",
 *     "DELETE",
 *            "GET"={
 *     "path"="/
 * competences",
 *     "security" = "is_granted('GROUPE_COMPETENCE_READ', object)"
 * },
 *
 *     "GET"={
 *     "path"="/groupe_competences/{id}",
 *     "security" = "is_granted('GROUPE_COMPETENCE_READ', object)"},
 *     },
 *       attributes={
 *              "pagination_enabled"=true,
 *              "pagination_items_per_page"=5,
 *     "security"= "is_granted('ROLE_Administrateur')",
 *     },
 * )
 */
class GroupeCompetences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups(
     *     {"referentielGet:read","referentielGetComptence:read","referentiel:read","GroupeCompetences:read",
     *     "GroupeCompetences:write","RefGroupCompCom:read","referentiel:write"
     *     })
     * @Groups ({"tags:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"GroupeCompetences:read","GroupeCompetences:write","RefGroupCompCom:read",
     *     "referentielGetComptence:read",
     *     "referentielGet:read","referentiel:write","referentiel:read","competence:write"})
     * @Groups ({"tags:read"})
     * @Assert\NotBlank
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"GroupeCompetences:read","GroupeCompetences:write","RefGroupCompCom:read",
     *     "referentielGetComptence:read",
     *     "referentielGet:read","referentiel:write","referentiel:read","competence:write"})
     * @Groups ({"tags:read"})
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="groupeCompetences",cascade = { "persist" })
     * @groups({"GroupeCompetences:read","GroupeCompetences:write","RefGroupCompCom:read","referentiel:read",
     *     "referentielGet:read","referentiel:write","referentielGetComptence:read"})
     *
     * @ApiSubresource
     */
    private $competence;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="groupeCompetence")
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetence")
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     */
    private $referentiels;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }
}
