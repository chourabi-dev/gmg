<?php

namespace App\Entity;

use App\Repository\LocationToStaffRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationToStaffRepository::class)
 */
class LocationToStaff
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="locationToStaff")
     */
    private $staff;

    /**
     * @ORM\ManyToOne(targetEntity=Locations::class, inversedBy="locationToStaff")
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=LocationTypes::class, inversedBy="locationToStaff")
     */
    private $locationType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

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

    public function getLocationType(): ?LocationTypes
    {
        return $this->locationType;
    }

    public function setLocationType(?LocationTypes $locationType): self
    {
        $this->locationType = $locationType;

        return $this;
    }
}
