<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"referentiel:read"}},
 *     denormalizationContext={"groups"={"referentiel:write"}},
 *
 *     routePrefix="/admin",
 *     attributes={
 *      "pagination_enabled"=true,
 *     "pagination_items_per_page"=5,
 *     "security"= "is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager')",
 *     "security_message"="Acces non autorisé",
 *     },
 *     collectionOperations={
 *                "GET_R_GR"={
 *                  "path"="/referentiels",
 *                   "method"="GET",
 *
 *                      },
 *                  "GET_R_GR_C"={
 *                      "method"="GET",
 *                    "path"="/referentiels/grpecompetences",
 *                   "normalization_context"={"groups"={"referentielGet:read"}},
 *                           },
 *
 *     },
 *     itemOperations={
 *
 *              "GET_REF_GPC"={
 *                 "method"="GET",
 *                 "path"="/referentiels/{id}",
 *      "security"= "is_granted('ROLE_Apprenant')",
 *     },
 *              "GET_COMP_GP_REF"={
 *               "method"="GET",
 *              "path"="/referentiels/{id}/groupe_competences/{id2}",
 *              "normalization_context"={"groups"={"referentielGetComptence:read"}},
 *              "security"= "is_granted('ROLE_Apprenant')",
 *     },
 *     },
 *
 *     )
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"referentiel:read","referentiel:write","referentielGetComptence:read",
     *     "reFormGr:read","grPrincipal:read","promotion:write","promotion:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     *  @groups({"cricterDevaluations:read","cricterDevaluations:write"})

     *
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write","referentiel:read","referentiel:write",
     *     "referentielGetComptence:read","reFormGr:read","grPrincipal:read","promotion:write","promotion:read",
     *     "RefGroupCompCom:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     *  @groups({"cricterDevaluations:read","cricterDevaluations:write"})
     * @Assert\NotBlank
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentielGet:read","referentielGetComptence:read","reFormGr:read","grPrincipal:read","promotion:write",
     *     "RefGroupCompCom:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write","referentiel:read","referentiel:write"})
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     *  @groups({"cricterDevaluations:read","cricterDevaluations:write"})
     * @Assert\NotBlank
     *
     */
    private $presentation;

    /**
        @ORM\ManyToMany(targetEntity=GroupeCompetences::class, inversedBy="referentiels")
     * @Groups({"referentiel:read","referentiel:write","referentielGet:read",
     *     "referentielGetComptence:read","reFormGr:read","grPrincipal:read","promotion:write","promotion:read",
     *     "RefGroupCompCom:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     *  @groups({"cricterDevaluations:read","cricterDevaluations:write"})
     *
     *
    */
    private $groupeCompetence;
    /**
     * @ORM\Column(type="blob")
     * @Groups({"referentiel:read","referentiel:write",
     *     "RefGroupCompCom:read","PromoRef:write","promotion:write","promotion:read"})
     * @groups({"GroupeCompetences:read","GroupeCompetences:write"})
     * * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     *  @groups({"cricterDevaluations:read","cricterDevaluations:write"})
     */
    private $programme;

    /**
     * @ORM\ManyToMany(targetEntity=Promotion::class, mappedBy="referentiels")
     * @groups({"referentiel:read","referentiel:write"})
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     *  @groups({"cricterDevaluations:read","cricterDevaluations:write"})
     */
    private $promotions;

    /**
     * @ORM\ManyToMany(targetEntity=CricterDadmissions::class, mappedBy="referentiel",cascade = { "persist" })
     * @groups({"referentiel:read","referentiel:write"})
     */
    private $cricterDadmissions;

    /**
     * @ORM\ManyToMany(targetEntity=CricterDevaluations::class, mappedBy="referentiel",cascade = { "persist" })
     * @groups({"referentiel:read","referentiel:write"})
     */
    private $cricterDevaluations;

    /**
     * @ORM\OneToMany(targetEntity=Apprenants::class, mappedBy="referentiel")
     * @ApiSubresource
     * @groups({"referentiel:read","referentiel:write"})
     */
    private $apprenants;


    public function __construct()
    {
        $this->groupeCompetence = new ArrayCollection();
        $this->cricterDadmissions = new ArrayCollection();
        $this->cricterDevaluations = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }


    /**
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        $this->groupeCompetence->removeElement($groupeCompetence);

        return $this;
    }

    public function getProgramme()
    {
        if ($this->programme) {
            $data = stream_get_contents($this->programme);
            if (!$this->programme) {

                fclose($this->programme);
            }


            return base64_encode($data);
        }
    }

    public function setProgramme($programme): self
    {
        $this->programme = $programme;

        return $this;
    }


    /**
     * @return Collection|Promotion[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->addReferentiel($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            $promotion->removeReferentiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|CricterDadmissions[]
     */
    public function getCricterDadmissions(): Collection
    {
        return $this->cricterDadmissions;
    }

    public function addCricterDadmission(CricterDadmissions $cricterDadmission): self
    {
        if (!$this->cricterDadmissions->contains($cricterDadmission)) {
            $this->cricterDadmissions[] = $cricterDadmission;
            $cricterDadmission->addReferentiel($this);
        }

        return $this;
    }

    public function removeCricterDadmission(CricterDadmissions $cricterDadmission): self
    {
        if ($this->cricterDadmissions->removeElement($cricterDadmission)) {
            $cricterDadmission->removeReferentiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|CricterDevaluations[]
     */
    public function getCricterDevaluations(): Collection
    {
        return $this->cricterDevaluations;
    }

    public function addCricterDevaluation(CricterDevaluations $cricterDevaluation): self
    {
        if (!$this->cricterDevaluations->contains($cricterDevaluation)) {
            $this->cricterDevaluations[] = $cricterDevaluation;
            $cricterDevaluation->addReferentiel($this);
        }

        return $this;
    }

    public function removeCricterDevaluation(CricterDevaluations $cricterDevaluation): self
    {
        if ($this->cricterDevaluations->removeElement($cricterDevaluation)) {
            $cricterDevaluation->removeReferentiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|Apprenants[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenants $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setReferentiel($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenants $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getReferentiel() === $this) {
                $apprenant->setReferentiel(null);
            }
        }

        return $this;
    }
}
