<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="Profil", type="string")
 * @ORM\DiscriminatorMap({"admin"="User","apprenant"="Apprenants","formateu"="Formateurs","communityManager"="CommunityManager"})
 * @ApiResource(
 *     collectionOperations={
 *          "get_admin_users"={
 *               "method"="GET",
 *               "path"="/admin/users",
 *              "security"= "is_granted('ROLE_Administrateur'))",
 *                  "security_message"="Acces non autorisé",
 *          }
 *     },
 *       attributes={
 *              "pagination_enabled"=true
 *     },
 *     itemOperations={
 *          "get_admin_users_id"={
 *               "method"="GET",
 *               "path"="/admin/users/{id}",
 *              "security"= "is_granted('ROLE_Administrateur'))",
 *                  "security_message"="Acces non autorisé",
 *
 *          },
 *
 *            "modifier_admin_users_id"={
 *               "method"="PUT",
 *               "path"="/admin/users/{id}",
 *                  "security"= "is_granted('ROLE_Administrateur'))",
 *                  "security_message"="Acces non autorisé",
 *
 *          },
 *          "delete_user"={"method"="DELETE","path"="/admin/users/{id}","security_message"="Acces non autorisé",
 *     "security"= "is_granted('ROLE_Administrateur'))"},
 *
 *     },
 *
 *
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Groups({"user:read", "user:write"})
     * @Groups({"profils:read"})
     */
    private $username;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"user:write"})
     * @SerializedName("password")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Groups({"profils:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     * @Groups({"profils:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     * @Groups({"profils:read"})
     */
    private $lastename;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     * @Groups({"profils:read"})
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Profils::class, inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     */
    private $profils;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastename(): ?string
    {
        return $this->lastename;
    }

    public function setLastename(string $lastename): self
    {
        $this->lastename = $lastename;

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

    public function getProfils(): ?Profils
    {
        return $this->profils;
    }

    public function setProfils(?Profils $profils): self
    {
        $this->profils = $profils;

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

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
