<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormateursRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=FormateursRepository::class)
 *  @ApiFilter(BooleanFilter::class,properties={"archivage"})
 * @ApiResource(
 *
 *             attributes={
 *     "security"="(is_granted('ROLE_Administrateur') or is_granted('ROLE_Formateur') or is_granted('ROLE_Community Manager') or is_granted('ROLE_Apprenant'))",
 *     "security_message"="Acces non autorisé",
 *     "pagination_enabled"=true,
 *     "pagination_items_per_page"=5
 *     },
 *     itemOperations={
                    "GET",
 *     }
 * )
 */
class Formateurs extends User
{


}
