<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ProfilSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilSortieRepository::class)
 * @ApiFilter(BooleanFilter::class,properties={"archivage"})
 * @ApiResource(
 *     routePrefix="/admin",
 *     collectionOperations={
 *           "GET"={
*                        "security"="(is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager'))",
 *     },
 *     "POST"={
 *                              "security"="(is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur'))",
 *     }
 *     },
 *        normalizationContext={"groups"={"profilSortie:read"}},
 *          denormalizationContext={"groups"={"profilSortie:write"}},
 *          attributes={ "pagination_enabled"=true,"pagination_items_per_page"=5},
 *
 *     )
 */
class ProfilSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profilSortie:read", "profilSortie:write"})
     * @Groups({"user:read", "user:write"})
     *@Groups({"profil:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profilSortie:read", "profilSortie:write"})
     * @Groups({"user:read", "user:write"})
     * @Groups({"getApprenantsByPs"})
     * @Groups({"profil:read"})
     * @Assert\NotBlank
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=Apprenants::class, mappedBy="profilSortie")
     * @Groups({"profilSortie:read"})
     * @Groups({"getApprenantsByPs"})
     * @ApiSubresource()
     */
    private $apprenants;

    public function __construct()
    {
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
            $apprenant->setProfilSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenants $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
                $apprenant->setArchivage(true);

        }

        return $this;
    }
/*    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();

        if ($entity instanceof ProfilSortie){

          $entity->setArchivage(true);
            $user=$entity->getUser();
            $user->setArchivage(true);
            $em = $args->getEntityManager();
            $em->persist($entity,$user);
        }
        $em->flush();
    }*/
  /*  public  function preUpdate(LifecycleEventArgs $event){
        $entity = $event->getObject();
        if ($entity instanceof ProfilSortie) {

            $entity->setArchivage(true);

            $app=$entity->getUser();
            $app->setArchivage(true);
        }
    }*/
}
