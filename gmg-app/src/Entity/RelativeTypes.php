<?php

namespace App\Entity;

use App\Repository\RelativeTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelativeTypesRepository::class)
 */
class RelativeTypes
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
    private $RelativeType;

    /**
     * @ORM\OneToMany(targetEntity=EmergencyContacts::class, mappedBy="relativeType")
     */
    private $emergencyContacts;

    public function __construct()
    {
        $this->emergencyContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelativeType(): ?string
    {
        return $this->RelativeType;
    }

    public function setRelativeType(string $RelativeType): self
    {
        $this->RelativeType = $RelativeType;

        return $this;
    }

    /**
     * @return Collection|EmergencyContacts[]
     */
    public function getEmergencyContacts(): Collection
    {
        return $this->emergencyContacts;
    }

    public function addEmergencyContact(EmergencyContacts $emergencyContact): self
    {
        if (!$this->emergencyContacts->contains($emergencyContact)) {
            $this->emergencyContacts[] = $emergencyContact;
            $emergencyContact->setRelativeType($this);
        }

        return $this;
    }

    public function removeEmergencyContact(EmergencyContacts $emergencyContact): self
    {
        if ($this->emergencyContacts->removeElement($emergencyContact)) {
            // set the owning side to null (unless already changed)
            if ($emergencyContact->getRelativeType() === $this) {
                $emergencyContact->setRelativeType(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->RelativeType;
    }
}
