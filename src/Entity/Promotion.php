<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 * @ApiResource(
 *     routePrefix="/admin",
 *     attributes={
 *          "security"= "is_granted('ROLE_Apprenant') or is_granted('ROLE_Formateur')",
 *     },
 *      collectionOperations={
 *
 *               "get_R_F_G"={
 *              "method"="GET",
 *              "path"="/promotions",
 *              "normalization_context"={"groups"={"reFormGr:read"}},
 *              "security"= "is_granted('ROLE_Community Manager')",
 *     },
 *              "get_R_F_AGprincipal"={
 *                    "method"="GET",
 *                      "path"="/promotion/principale",
 *                  "normalization_context"={"groups"={"grPrincipal:read"}},
 *                   "security"= "is_granted('ROLE_Community Manager')",
 *     },
 *     "get_Apprenant_Attente"={
 *                    "method"="GET",
 *                     "path"="/promotion/apprenants/attente",
 *                      "normalization_context"={"groups"={"promo_app_attente:read"}},
 *     },
 *     "POST"={
 *            "denormalization_context"={"groups"={"post_promo:write"}},
 *
 *     },
 *     },
 *     itemOperations={
 *
 *        "get_Ref_Form_Gr"={
 *             "method"="GET",
 *              "path"="/promotions/{id}",
 *              "normalization_context"={"groups"={"reFormGr:read"}},
 *     "security"= "is_granted('ROLE_Community Manager')",
 *
 *     },
 *     "get_Ref_Form_App"={
 *        "method"="GET",
 *        "path"="/promotions/{id}/principal",
 *         "normalization_context"={"groups"={"grPrincipal:read"}},
 *     "security"= "is_granted('ROLE_Community Manager')",
 *
 *     },
 *     "get_Ref_Pr_GroupeComp_comp"={
 *                 "method"="GET",
 *                  "path"="/promotions/{id}/referentiels",
 *              "normalization_context"={"groups"={"RefGroupCompCom:read"}},
 *     "security"= "is_granted('ROLE_Community Manager')",
 *
 *
 *     },
 *
 *     "get_Referentiel_AppAttente"={
 *             "method"="GET",
 *             "path"="/promotions/{id}/apprenants/attente",
 *             "normalization_context"={"groups"={"promo_app_attente:read"}},
 *     "security"= "is_granted('ROLE_Community Manager')",
 *     },
 *     "get_Pr_Gr_Ap_Ref_Ap"={
 *
 *     "method"="GET",
 *     "path"="/promotions/{id}/groupes/{id2}/apprenants",
 *     "normalization_context"={"groups"={"promoGrApRefAp:read"}},
 *     "security"= "is_granted('ROLE_Community Manager')",
 *
 *     },
 *     "get_form_ref_groupe"={
 *          "method"="GET",
 *          "path"="/promotions/{id}/formateurs",
 *      "normalization_context"={"groups"={"reFormGr:read"}},
 *     "security"= "is_granted('ROLE_Community Manager')",
 *     },
 *     "promo_put_Ref"={
 *          "method"="PUT",
 *          "path"="/promotions/{id}/referentiels",
 *          "denormalization_context"={"groups"={"PromoRef:write"}}
 *     },
 *     "promo_delete_add_apprenant"={
*           "method"="PUT",
 *          "path"="/promotions/{id}/apprenants",
 *     "denormalization_context"={"groups"={"promoDeleteAddApprenant:write"}}
 *
 *     },
 *     "promo_delete_add_formateur"={
 *            "method"="PUT",
 *              "path"="/promotions/{id}/formateurs",
 *     "denormalization_context"={"groups"={"promoDeleteAddFormateur:write"}}
 *     },
 *     "promo_update_statut_groupe"={
 *          "method"="PUT",
 *          "path"="/promotions/{id}/groupes{idg}",
 *     "denormalization_context"={"groups"={"promoUpdateStatutGroupe:write"}}
 *
 *     },
 *     },

 * )
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read","groupe:write","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","reFormGr:read","grPrincipal:read",
     *     "promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *   })
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","reFormGr:read","grPrincipal:read",
     *     "promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *     })
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *     })
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *     })
     */
    private $lieu;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *    })
     */
    private $dateFinProvisoire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *     })
     */
    private $fabrique;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *     })
     */
    private $dateFinReelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","RefGroupCompCom:read"
     * ,"post_promo:write","promoGrApRefAp:read","PromoRef:write"
     *     })
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Formateurs::class, inversedBy="promotions")
     * @Groups ({"reFormGr:read","grPrincipal:read"})
     * @ApiSubresource
     *
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promotion")
     * @Groups ({"reFormGr:read","grPrincipal:read","promoGrApRefAp:read"})
     * @ApiSubresource
     */
    private $groupes;

    /**
     * @ORM\Column(type="date")
     * @Groups ({"grPrincipal:read","PromoRef:write"})
     */
    private $dateDebut;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promo",cascade = { "persist" })
     * @ORM\JoinColumn(nullable=false)
     * @Groups ({"reFormGr:read","grPrincipal:read","post_promo:write",
     *     "promo_app_attente:read","promoGrApRefAp:read","PromoRef:write"})
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Apprenants::class, mappedBy="promotion")
     * @Groups ({"promo_app_attente:read","post_promo:write","promoGrApRefAp:read","promoDeleteAddApprenant:write"})
     * @ApiSubresource
     */
    private $apprenants;

    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateFinProvisoire(): ?\DateTimeInterface
    {
        return $this->dateFinProvisoire;
    }

    public function setDateFinProvisoire(\DateTimeInterface $dateFinProvisoire): self
    {
        $this->dateFinProvisoire = $dateFinProvisoire;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateFinReelle(): ?\DateTimeInterface
    {
        return $this->dateFinReelle;
    }

    public function setDateFinReelle(\DateTimeInterface $dateFinReelle): self
    {
        $this->dateFinReelle = $dateFinReelle;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Formateurs[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateurs $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateurs $formateur): self
    {
        $this->formateurs->removeElement($formateur);

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromotion($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromotion() === $this) {
                $groupe->setPromotion(null);
            }
        }

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

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
            $apprenant->setPromotion($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenants $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getPromotion() === $this) {
                $apprenant->setPromotion(null);
            }
        }

        return $this;
    }
}
