<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 *  @ApiFilter(BooleanFilter::class,properties={"archivage"})
 * @ApiResource(
 *          attributes={
 *     "security"= "is_granted('ROLE_Administrateur')",
 *     "security_message"="Acces non autorisé",
 *     "pagination_enabled"=true,
 *     "pagination_items_per_page"=5
 *     },
 *      collectionOperations={
 *           "get_apprenants"={
 *               "method"="GET",
 *      "security"="(is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager'))",
 *          },
 *            "add_apprenant"={
 *               "method"="POST",
 *              "security"="(is_granted('ROLE_Administrateur'))"
 *          }
 *      },
 *      itemOperations={
 *           "get_apprenants_id"={
 *               "method"="GET",
 *      "security"="(is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager' or is_granted('ROLE_Apprenant')))",
 *                "defaults"={"id"=null},
 *          },
 *
 *            "modifier_apprenants_id"={
 *               "method"="PUT",
 *     "security"="(is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur')  or is_granted('ROLE_Apprenant')))",
 *          },
 *
 *      },
 *       normalizationContext={"groups"={"apprenant:read"}},
 *       denormalizationContext={"groups"={"apprenant:write"}}
 *
 * )
 * @ORM\Entity(repositoryClass=ApprenantsRepository::class)
 */
class Apprenants extends User
{
    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"apprenant:read", "apprenant:write","profilSortie:read"})
     * @Assert\NotBlank
     * @Groups({"getApprenantsByPs"})
     * @Groups({"user:read", "user:write"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write",
     *     "promoGrApRefAp:read","promoDeleteAddApprenant:write"
     * })
     * @Groups({"profil:read"})
     */
    private $genre;

    /**
     * @ORM\Column(type="text")
     * @Groups({"user:read", "user:write"})
     * @Groups({"apprenant:read", "apprenant:write","profilSortie:read"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write","promoGrApRefAp:read",
     * "promoDeleteAddApprenant:write"
     *     })
     * @Groups({"profil:read"})
     * @Groups({"getApprenantsByPs"})
     * @Assert\NotBlank
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"user:read", "user:write"})
     * @Groups({"apprenant:read", "apprenant:write","profilSortie:read"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write",
     *     "promoGrApRefAp:read","promoDeleteAddApprenant:write"
     * })
     * @Groups({"profil:read"})
     * @Groups({"getApprenantsByPs"})
     * @Assert\NotBlank
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilSortie::class, inversedBy="apprenants")
     * @Groups({"groupe:read","groupe:write"})
     * @Groups({"user:read", "user:write"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read"})
     * @ApiSubresource()
     *
     */
    private $profilSortie;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="apprenant", cascade={"persist"})
     * @Groups({"user:read", "user:write"})
     */
    private $groupe;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"promo_app_attente:read","promotion:write"})
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="apprenants",cascade = { "persist" })
     * @ORM\JoinColumn(nullable=true)
     */
    private $promotion;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
    }


    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getProfilSortie(): ?ProfilSortie
    {
        return $this->profilSortie;
    }

    public function setProfilSortie(?ProfilSortie $profilSortie): self
    {
        $this->profilSortie = $profilSortie;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
            $groupe->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->removeElement($groupe)) {
            $groupe->removeApprenant($this);
        }

        return $this;
    }

    public function getUsername(): string
    {
        return strtoupper(parent::getUsername());
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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



}
