<?php

namespace App\Entity;

use App\Repository\FormateursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateursRepository::class)
 */
class Formateurs extends User
{


}
