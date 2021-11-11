<?php

namespace App\Entity;

use App\Repository\FamilyStatusTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FamilyStatusTypesRepository::class)
 */
class FamilyStatusTypes
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
    private $familyStatusType;

    /**
     * @ORM\OneToMany(targetEntity=Staff::class, mappedBy="familyStatusType")
     */
    private $staff;

    /**
     * @ORM\OneToMany(targetEntity=Condidates::class, mappedBy="familyStatusType")
     */
    private $condidates;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
        $this->condidates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyStatusType(): ?string
    {
        return $this->familyStatusType;
    }

    public function setFamilyStatusType(string $familyStatusType): self
    {
        $this->familyStatusType = $familyStatusType;

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
            $staff->setFamilyStatusType($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getFamilyStatusType() === $this) {
                $staff->setFamilyStatusType(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->familyStatusType;
    }

    /**
     * @return Collection|Condidates[]
     */
    public function getCondidates(): Collection
    {
        return $this->condidates;
    }

    public function addCondidate(Condidates $condidate): self
    {
        if (!$this->condidates->contains($condidate)) {
            $this->condidates[] = $condidate;
            $condidate->setFamilyStatusType($this);
        }

        return $this;
    }

    public function removeCondidate(Condidates $condidate): self
    {
        if ($this->condidates->removeElement($condidate)) {
            // set the owning side to null (unless already changed)
            if ($condidate->getFamilyStatusType() === $this) {
                $condidate->setFamilyStatusType(null);
            }
        }

        return $this;
    }
}
