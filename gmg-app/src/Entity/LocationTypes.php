<?php

namespace App\Entity;

use App\Repository\LocationTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=LocationTypesRepository::class)
 * @UniqueEntity("locationType")
 */
class LocationTypes
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
    private $locationType;

    /**
     * @ORM\OneToMany(targetEntity=LocationToStaff::class, mappedBy="locationType")
     */
    private $locationToStaff;

    /**
     * @ORM\OneToMany(targetEntity=CandidateLocations::class, mappedBy="relation")
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity=CompanyLocations::class, mappedBy="locationType")
     */
    private $companyLocations;

    public function __construct()
    {
        $this->locationToStaff = new ArrayCollection();
        $this->location = new ArrayCollection();
        $this->companyLocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationType(): ?string
    {
        return $this->locationType;
    }

    public function setLocationType(string $locationType): self
    {
        $this->locationType = $locationType;

        return $this;
    }

    /**
     * @return Collection|LocationToStaff[]
     */
    public function getLocationToStaff(): Collection
    {
        return $this->locationToStaff;
    }

    public function addLocationToStaff(LocationToStaff $locationToStaff): self
    {
        if (!$this->locationToStaff->contains($locationToStaff)) {
            $this->locationToStaff[] = $locationToStaff;
            $locationToStaff->setLocationType($this);
        }

        return $this;
    }

    public function removeLocationToStaff(LocationToStaff $locationToStaff): self
    {
        if ($this->locationToStaff->removeElement($locationToStaff)) {
            // set the owning side to null (unless already changed)
            if ($locationToStaff->getLocationType() === $this) {
                $locationToStaff->setLocationType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CandidateLocations[]
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(CandidateLocations $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location[] = $location;
            $location->setRelation($this);
        }

        return $this;
    }

    public function removeLocation(CandidateLocations $location): self
    {
        if ($this->location->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getRelation() === $this) {
                $location->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompanyLocations[]
     */
    public function getCompanyLocations(): Collection
    {
        return $this->companyLocations;
    }

    public function addCompanyLocation(CompanyLocations $companyLocation): self
    {
        if (!$this->companyLocations->contains($companyLocation)) {
            $this->companyLocations[] = $companyLocation;
            $companyLocation->setLocationType($this);
        }

        return $this;
    }

    public function removeCompanyLocation(CompanyLocations $companyLocation): self
    {
        if ($this->companyLocations->removeElement($companyLocation)) {
            // set the owning side to null (unless already changed)
            if ($companyLocation->getLocationType() === $this) {
                $companyLocation->setLocationType(null);
            }
        }

        return $this;
    }
}
