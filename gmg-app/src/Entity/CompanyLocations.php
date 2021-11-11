<?php

namespace App\Entity;

use App\Repository\CompanyLocationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyLocationsRepository::class)
 */
class CompanyLocations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="companyLocations")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=LocationTypes::class, inversedBy="companyLocations")
     */
    private $locationType;

    /**
     * @ORM\ManyToOne(targetEntity=Locations::class, inversedBy="companyLocations")
     */
    private $location;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isBillingAddress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Companies
    {
        return $this->company;
    }

    public function setCompany(?Companies $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getLocationType(): ?LocationTypes
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

    public function getIsBillingAddress(): ?bool
    {
        return $this->isBillingAddress;
    }

    public function setIsBillingAddress(?bool $isBillingAddress): self
    {
        $this->isBillingAddress = $isBillingAddress;

        return $this;
    }
}
