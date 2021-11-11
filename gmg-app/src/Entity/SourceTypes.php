<?php

namespace App\Entity;

use App\Repository\SourceTypesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SourceTypesRepository::class)
 * @UniqueEntity("sourceType")
 */
class SourceTypes
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
    private $sourceType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceType(): ?string
    {
        return $this->sourceType;
    }

    public function setSourceType(string $sourceType): self
    {
        $this->sourceType = $sourceType;

        return $this;
    }


    public function __toString()
    {
        return $this->sourceType;
    }
}
