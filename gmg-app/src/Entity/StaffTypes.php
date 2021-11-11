<?php

namespace App\Entity;

use App\Repository\StaffTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StaffTypesRepository::class)
 */
class StaffTypes
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
    private $staffType;

    /**
     * @ORM\OneToMany(targetEntity=Staff::class, mappedBy="staffType")
     */
    private $staff;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaffType(): ?string
    {
        return $this->staffType;
    }

    public function setStaffType(string $staffType): self
    {
        $this->staffType = $staffType;

        return $this;
    }

    /**
     * @return Collection|Staff[]
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staff->contains($staff)) {
            $this->staff[] = $staff;
            $staff->setStaffType($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getStaffType() === $this) {
                $staff->setStaffType(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->staffType;
    }
}
