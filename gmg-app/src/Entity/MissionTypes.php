<?php

namespace App\Entity;

use App\Repository\MissionTypesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=MissionTypesRepository::class)
 * @UniqueEntity("messionType")
 */
class MissionTypes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $messionType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessionType(): ?string
    {
        return $this->messionType;
    }

    public function setMessionType(string $messionType): self
    {
        $this->messionType = $messionType;

        return $this;
    }
}
