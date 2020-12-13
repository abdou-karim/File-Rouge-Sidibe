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

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"referentiel:read"}},
 *     denormalizationContext={"groups"={"referentiel:write"}},
 *
 *     routePrefix="/admin",
 *     attributes={
 *      "pagination_enabled"=true,
 *     "pagination_items_per_page"=3,
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
 *                      "POST",
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
     *     "reFormGr:read","grPrincipal:read","post_promo:write","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})

     *
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write","referentiel:read","referentiel:write",
     *     "referentielGetComptence:read","reFormGr:read","grPrincipal:read","post_promo:write",
     *     "RefGroupCompCom:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})
     * @Assert\NotBlank
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentielGet:read","referentielGetComptence:read","reFormGr:read","grPrincipal:read","post_promo:write",
     *     "RefGroupCompCom:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write","referentiel:write"})
     * @Assert\NotBlank
     *
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write","referentielGet:read",
     *     "referentielGetComptence:read","reFormGr:read","grPrincipal:read","post_promo:write",
     *     "RefGroupCompCom:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})
     *
     */
    private $crictereAdmission;

    /**
     * @ORM\Column(type="text")
     * @Groups({"referentiel:read","referentiel:write","referentielGet:read",
     *     "referentielGetComptence:read","reFormGr:read","grPrincipal:read","post_promo:write",
     *     "RefGroupCompCom:read","promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})
     *
     */
    private $crictereEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, inversedBy="referentiels")
     * @Groups({"referentiel:read","referentielGet:read","referentiel:write",
     *     "referentielGetComptence:read","reFormGr:read","RefGroupCompCom:read"})
     * @ApiSubresource
     */
    private $groupeCompetence;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="referentiel",cascade = { "persist" })
     *
     */
    private $promo;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"referentiel:read","referentiel:write","post_promo:write",
     *     "RefGroupCompCom:read","PromoRef:write"})
     */
    private $programme;

    public function __construct()
    {
        $this->groupeCompetence = new ArrayCollection();
        $this->promo = new ArrayCollection();
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

    /**
     * @return Collection|Promotion[]
     */
    public function getPromo(): Collection
    {
        return $this->promo;
    }

    public function addPromo(Promotion $promo): self
    {
        if (!$this->promo->contains($promo)) {
            $this->promo[] = $promo;
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promotion $promo): self
    {
        if ($this->promo->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

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
}
