<?php

namespace App\Entity;

use App\Repository\CricterDadmissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=CricterDadmissionsRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"cricterDadmissions:read"}},
 *     denormalizationContext={"groups"={"cricterDadmissions:write"}},
 *     )
 */
class CricterDadmissions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups({"referentiel:read","referentiel:write"})
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups({"referentiel:read","referentiel:write"})
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="cricterDadmissions",cascade = { "persist" })
     * @groups({"cricterDadmissions:read","cricterDadmissions:write"})
     */
    private $referentiel;

    public function __construct()
    {
        $this->referentiel = new ArrayCollection();
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
     * @return Collection|Referentiel[]
     */
    public function getReferentiel(): Collection
    {
        return $this->referentiel;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiel->contains($referentiel)) {
            $this->referentiel[] = $referentiel;
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        $this->referentiel->removeElement($referentiel);

        return $this;
    }
}
