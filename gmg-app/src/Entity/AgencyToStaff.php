<?php

namespace App\Entity;

use App\Repository\AgencyToStaffRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgencyToStaffRepository::class)
 */
class AgencyToStaff
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="agency")
     */
    private $staff;

    /**
     * @ORM\ManyToOne(targetEntity=Agencies::class, inversedBy="agencyToStaff")
     */
    private $agency;

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

    public function getAgency(): ?Agencies
    {
        return $this->agency;
    }

    public function setAgency(?Agencies $agency): self
    {
        $this->agency = $agency;

        return $this;
    }
}
