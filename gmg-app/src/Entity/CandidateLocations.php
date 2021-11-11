<?php

namespace App\Entity;

use App\Repository\CandidateLocationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidateLocationsRepository::class)
 */
class CandidateLocations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="locationType")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=LocationTypes::class, inversedBy="location")
     */
    private $locationType;

    /**
     * @ORM\ManyToOne(targetEntity=Locations::class, inversedBy="candidateLocations")
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?Condidates
    {
        return $this->candidate;
    }

    public function setCandidate(?Condidates $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function geLocationType(): ?LocationTypes
    {
        return $this->locationType;
    }

    public function setLocationType(?LocationTypes $locationType): self
    {
        $this->locationType = $locationType;

        return $this;
    }

    public function getLocation(): ?Locations
    {
        return $this->location;
    }

    public function setLocation(?Locations $location): self
    {
        $this->location = $location;

        return $this;
    }
}
