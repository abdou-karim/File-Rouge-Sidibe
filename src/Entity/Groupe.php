<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"groupe:read"}},
 *     denormalizationContext={"groups"={"groupe:write"}},
 *     routePrefix="/admin",
 *      attributes={
 *              "pagination_enabled"=true,
 *              "pagination_items_per_page"=5,
 *               "security"= "is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur') ",
 *                "security_message"="Acces non autorisé"
 *     },
 *     collectionOperations={
 *          "Get_Groupe_P_A_F"={
 *              "method"="GET",
 *           "path"="/groupes",
 *     },
 *     "Get_Groupe_apprenant"={
 *            "method"="GET",
 *              "path"="/groupes/apprenants",
 *               "normalization_context"={"groups"={"groupeApprenant:read"}},
 *
 *     },
 *                  "POST",
 *     },
 *     itemOperations={
 *
 *              "delete_apprenants"={
 *              "path"="/groupes/{id}/apprenants/{ids}",
 *              "method"="delete",

 *     },
 *     "PUT"={
 *           "path"="/groupes/{id}",
 *     },
 *     "GET"={
 *        "path"="/groupes/{id}"
 *     },
 *     },
 * )
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "reFormGr:read","grPrincipal:read","promoGrApRefAp:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "reFormGr:read","grPrincipal:read","promoGrApRefAp:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "reFormGr:read","grPrincipal:read","promoGrApRefAp:read"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "reFormGr:read","grPrincipal:read","promoGrApRefAp:read"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "reFormGr:read","grPrincipal:read","promoGrApRefAp:read"})
     */
    private $typeDeGroupe;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="groupes")
     * @ApiSubresource
     * @Groups({"groupe:read","groupe:write"})
     */
    private $promotion;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenants::class, inversedBy="groupes")
     * @Groups({"groupe:read","groupe:write",
     *     "groupeApprenant:read","grPrincipal:read","promoGrApRefAp:read"})
     * @ApiSubresource()
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateurs::class, inversedBy="groupes")
     * @Groups({"groupe:read","groupe:write"})
     */
    private $formateurs;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

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

    public function getTypeDeGroupe(): ?string
    {
        return $this->typeDeGroupe;
    }

    public function setTypeDeGroupe(string $typeDeGroupe): self
    {
        $this->typeDeGroupe = $typeDeGroupe;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

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
        }

        return $this;
    }

    public function removeApprenant(Apprenants $apprenant): self
    {
        $this->apprenants->removeElement($apprenant);

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
