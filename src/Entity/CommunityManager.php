<?php

namespace App\Entity;

use App\Repository\CommunityManagerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommunityManagerRepository::class)
 */
class CommunityManager extends User
{

}
