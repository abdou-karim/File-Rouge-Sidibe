<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
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
 *          routePrefix="/admin",
 *     collectionOperations={
 *
 *          "get_admin_profils"={
 *                      "method"="GET",
 *                       "path"="/profils",
 *
 *
 *     },
 *      "get_admin_profils_users"={
 *               "method"="GET",
 *               "path"="/profils/{id}/users",
 *
 *          },
 *      "create_profil"={
 *               "method"="POST",
 *               "path"="/profils",
 *
 *          },
 *     },
 *     itemOperations={
 *               "get_admin_profils_id"={
 *               "method"="GET",
 *               "path"="/profils/{id}",
 *          "normalization_context"={"groups"={"profilUser:read"}},
 *
 *
 *          },
 *           "put_admin_profils_id"={
 *               "method"="PUT",
 *               "path"="/profils/{id}",
 *
 *          },
 *              "delete_profil"={
 *               "method"="DELETE",
 *               "path"="/profils/{id}",
 *
 *          },
 *     },
 *     attributes={
 *              "pagination_enabled"=true,
 *              "pagination_items_per_page"=5,
 *          "security"= "is_granted('ROLE_Administrateur')",
 *                  "security_message"="Acces non autorisé"
 *     },
 *     normalizationContext={"groups"={"profil:read"}},
 *     denormalizationContext={"groups"={"profil:write"}}
 * )
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profil:read"})
     * @Groups({"user:read", "user:write"})
     *
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     * @Groups({"profil:read", "profil:write"})
     * @Groups({"user:read", "user:write"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profils")
     * @Groups({"profil:read"})
     *
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
