<?php

namespace App\Entity;

use App\Repository\ContractTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractTypesRepository::class)
 */
class ContractTypes
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
    private $contractType;

    /**
     * @ORM\OneToMany(targetEntity=Contracts::class, mappedBy="contractType")
     */
    private $contracts;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(string $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    /**
     * @return Collection|Contracts[]
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contracts $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts[] = $contract;
            $contract->setContractType($this);
        }

        return $this;
    }

    public function removeContract(Contracts $contract): self
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getContractType() === $this) {
                $contract->setContractType(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->contractType;
    }
}
