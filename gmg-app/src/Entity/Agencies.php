<?php

namespace App\Entity;

use App\Repository\AgenciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenciesRepository::class)
 */
class Agencies
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
    private $agency;

    /**
     * @ORM\OneToMany(targetEntity=AgencyToStaff::class, mappedBy="agency")
     */
    private $agencyToStaff;

    public function __construct()
    {
        $this->agencyToStaff = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgency(): ?string
    {
        return $this->agency;
    }

    public function setAgency(string $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * @return Collection|AgencyToStaff[]
     */
    public function getAgencyToStaff(): Collection
    {
        return $this->agencyToStaff;
    }

    public function addAgencyToStaff(AgencyToStaff $agencyToStaff): self
    {
        if (!$this->agencyToStaff->contains($agencyToStaff)) {
            $this->agencyToStaff[] = $agencyToStaff;
            $agencyToStaff->setAgency($this);
        }

        return $this;
    }

    public function removeAgencyToStaff(AgencyToStaff $agencyToStaff): self
    {
        if ($this->agencyToStaff->removeElement($agencyToStaff)) {
            // set the owning side to null (unless already changed)
            if ($agencyToStaff->getAgency() === $this) {
                $agencyToStaff->setAgency(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->agency;
    }
}
