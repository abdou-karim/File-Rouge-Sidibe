<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
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
 *       normalizationContext={"groups"={"apprenant:read","user:read"}},
 *       denormalizationContext={"groups"={"apprenant:write","user:write"}}
 *
 * )
 * @ORM\Entity(repositoryClass=ApprenantsRepository::class)
 */
class Apprenants extends User
{
    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"apprenant:read", "apprenant:write"})
     * @Assert\NotBlank
     */
    private $genre;

    /**
     * @ORM\Column(type="text")
     * @Groups({"apprenant:read", "apprenant:write"})
     * @Assert\NotBlank
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"apprenant:read", "apprenant:write"})
     * @Assert\NotBlank
     */
    private $telephone;


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

}
