<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=ProfilsRepository::class)
 * @ApiFilter(BooleanFilter::class,properties={"archivage"})
 *  @ApiResource(
 *
 *     collectionOperations={
 *
 *          "get_admin_profils"={
 *                      "method"="GET",
 *                       "path"="/admin/profils",
 *                      "security"= "is_granted('ROLE_Administrateur')",
 *                        "security_message"="Acces non autorisé"
 *
 *     },
 *      "get_admin_profils_users"={
 *               "method"="GET",
 *               "path"="/admin/profils/{id}/users",
 *                  "security_message"="Acces non autorisé",
 *              "security"= "is_granted('ROLE_Administrateur')",
 *          },
 *      "create_profil"={
 *               "method"="POST",
 *               "path"="/admin/profils",
 *              "security"= "is_granted('ROLE_Administrateur')",
 *                "security_message"="Acces non autorisé"
 *          },
 *     },
 *     itemOperations={
 *               "get_admin_profils_id"={
 *               "method"="GET",
 *               "path"="/admin/profils/{id}",
 *              "security"= "is_granted('ROLE_Administrateur')",
 *                  "security_message"="Acces non autorisé"
 *
 *          },
 *           "put_admin_profils_id"={
 *               "method"="PUT",
 *               "path"="/admin/profils/{id}",
 *              "security"= "is_granted('ROLE_Administrateur')",
 *                  "security_message"="Acces non autorisé"
 *          },
 *              "delete_profil"={
 *               "method"="DELETE",
 *               "path"="/admin/profils/{id}",
 *                  "security"= "is_granted('ROLE_Administrateur')",
 *                  "security_message"="Acces non autorisé"
 *          },
 *     },
 *     attributes={
 *              "pagination_enabled"=true
 *     },
 *     normalizationContext={"groups"={"profils:read"}},
 *     denormalizationContext={"groups"={"profils:write"}}
 * )
 */
class Profils
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profils:read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     * @Groups({"profils:read", "profils:write"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profils")
     *
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

    public function __construct()
    {
        $this->user = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setProfils($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfils() === $this) {
                $user->setProfils(null);
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
