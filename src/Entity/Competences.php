<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetencesRepository::class)
 * @ApiResource (
 *     routePrefix="/admin",
 *     normalizationContext={"groups"={"competence:read"}},
 *     denormalizationContext={"groups"={"competence:write"}},
 *       attributes={
 *              "pagination_enabled"=true,
 *              "pagination_items_per_page"=3,
 *     "security"= "is_granted('ROLE_Administrateur')",
 *     "security_message"="Acces non autorisé",
 *     },
 *     collectionOperations={
 *             "Get_competence_n"={
 *                     "method"="GET",
 *                      "path"="/competences",
 *     "security"= "is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager') or is_granted('ROLE_Administrateur')",
 *     },
 *     "POST"={
 *             "path"="/competences",
 *     },
 *     },
 *     itemOperations={
 *              "GET"={
 *                 "path"="/competences/{id}",
 *                  "security"= "is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager')",
 *     },
 *     "PUT"={
 *          "path"="/competences/{id}"
 *     },
 *          "DELETE"={
 *               "path"="/competences/{id}"
 *     },
 *     }
 * )
 */
class Competences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"competence:read","GroupeCompetences:read","competence:write",
     *     "referentielGetComptence:read","referentielGet:read","GroupeCompetences:write","RefGroupCompCom:read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentielGet:read","referentiel:write","referentiel:read",
     *     "referentielGetComptence:read","GroupeCompetences:read",
     *     "GroupeCompetences:write","RefGroupCompCom:read","competence:read","competence:write"})
     * @Assert\NotBlank
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentielGet:read","referentiel:write",
     *     "referentielGetComptence:read","referentiel:read",
     *     "GroupeCompetences:read","GroupeCompetences:write","RefGroupCompCom:read","competence:read","competence:write"})
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="competence",cascade = { "persist" })
     * @Groups({"competence:write"})
     */
    private $groupeCompetences;


    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence",cascade = { "persist" })
     * @Groups({"competence:read","competence:write","GroupeCompetences:read","GroupeCompetences:write","RefGroupCompCom:read"})
     * @Assert\Count(min="3",max="3",exactMessage="boy bayil ligay def")
     * @Groups({"referentiel:write"})
     * @ApiSubresource()
     */
    private $niveaux;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
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
