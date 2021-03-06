<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *       collectionOperations={
 *
 *          "get_admin_users"={
 *               "method"="GET",
 *               "path"="/users",
 *           "security"= "is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager') or is_granted('ROLE_Administrateur')",
 *
 *
 *          },
 *     "POST"={
 *        "path"="/users",
 *     },
 *     },
 *       attributes={
 *              "pagination_enabled"=true,
 *          "pagination_items_per_page"=5,
 *     "security_message"="Acces non autorisé",
 *     "security"= "is_granted('ROLE_Administrateur')",
 *
 *     },
 *     itemOperations={
 *          "get_admin_users_id"={
 *               "method"="GET",
 *               "path"="/users/{id}",
 *                   "defaults"={"id"=null},
 *     "security"= "is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager') or is_granted('ROLE_Apprenant') or is_granted('ROLE_Administrateur')",
 *
 *          },
 *          "delete_users"={
 *     "method"="DELETE","path"="/users/{id}",
 *     "security"= "is_granted('ROLE_Administrateur')"
 * },
 *          "PUT"={
 *          "security"= "is_granted('ROLE_Formateur') or is_granted('ROLE_Apprenant')",
 *     },
 *     },
 *
 *
 *
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"administrateur"="User","apprenants" = "Apprenants","formateurs"="Formateurs","community Manager"="CommunityManager"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read","formateur:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write","promoGrApRefAp:read",
     *     "promoDeleteAddApprenant:write","apprenant:read", "apprenant:write"
     * })
     * @Groups({"profil:read"})
     * @groups({"referentiel:read","referentiel:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read","profilSortie:read"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read","formateur:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write","promoGrApRefAp:read",*
     *     "promoDeleteAddApprenant:write","apprenant:read", "apprenant:write"
     * })
     * @groups({"referentiel:read","referentiel:write"})
     * @Assert\NotBlank
     */
    private $username;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read","profilSortie:read"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read","formateur:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write","promoGrApRefAp:read",
     *     "promoDeleteAddApprenant:write","apprenant:read", "apprenant:write"
     *     })
     * @groups({"referentiel:read","referentiel:write"})
     * @Assert\NotBlank
     */
    private $fisrtname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read","profilSortie:read"})*
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read","formateur:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write","promoGrApRefAp:read",
     *     "promoDeleteAddApprenant:write","apprenant:read", "apprenant:write"
     *     })
     * @groups({"referentiel:read","referentiel:write"})
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read","profilSortie:read"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read","formateur:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write","promoGrApRefAp:read",
     *     "promoDeleteAddApprenant:write","apprenant:read", "apprenant:write"
     *     })
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide"
     * )
     * @groups({"referentiel:read","referentiel:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read","profilSortie:read"})
     * @Groups({"groupe:read","groupe:write","groupeApprenant:read","formateur:read","reFormGr:read",
     *     "grPrincipal:read","promo_app_attente:read","promotion:write","promoGrApRefAp:read"
     * ,"promoDeleteAddApprenant:write","apprenant:read", "apprenant:write"
     *     })
     * @groups({"referentiel:read","referentiel:write"})
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     * @Groups({"user:read", "user:write"})
     * @Groups({"profil:read","promoDeleteAddApprenant:write"})
     */
    private $archivage;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class)
     * @Groups({"user:read", "user:write"})
     * @groups({"referentiel:read","referentiel:write"})
     */
    private $profils;

    /**
     * @Groups({"user:write"})
     */
    private $plainPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profils->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFisrtname(): ?string
    {
        return $this->fisrtname;
    }

    public function setFisrtname(string $fisrtname): self
    {
        $this->fisrtname = $fisrtname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoto()
    {
        if($this->photo)
        {
            $data = stream_get_contents($this->photo);
            if(!$this->photo){

                fclose($this->photo);
            }


            return base64_encode($data);
        }else
        {
            return null;
        }
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

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

    public function getProfils(): ?Profil
    {
        return $this->profils;
    }

    public function setProfils(?Profil $profils): self
    {
        $this->profils = $profils;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @param $plainPassword
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
