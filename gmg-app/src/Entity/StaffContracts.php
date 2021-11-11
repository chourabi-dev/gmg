<?php

namespace App\Entity;

use App\Repository\StaffContractsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StaffContractsRepository::class)
 */
class StaffContracts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="staffContracts")
     */
    private $staff;

    /**
     * @ORM\ManyToOne(targetEntity=Contracts::class, inversedBy="staffContracts")
     */
    private $contract;

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

    public function getContract(): ?Contracts
    {
        return $this->contract;
    }

    public function setContract(?Contracts $contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}
