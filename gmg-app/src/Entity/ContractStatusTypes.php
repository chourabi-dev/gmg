<?php

namespace App\Entity;

use App\Repository\ContractStatusTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractStatusTypesRepository::class)
 */
class ContractStatusTypes
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
    private $contractStatusType;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\OneToMany(targetEntity=StatusContract::class, mappedBy="contractStatusType")
     */
    private $statusContracts;

    public function __construct()
    {
        $this->statusContracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractStatusType(): ?string
    {
        return $this->contractStatusType;
    }

    public function setContractStatusType(string $contractStatusType): self
    {
        $this->contractStatusType = $contractStatusType;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * @return Collection|StatusContract[]
     */
    public function getStatusContracts(): Collection
    {
        return $this->statusContracts;
    }

    public function addStatusContract(StatusContract $statusContract): self
    {
        if (!$this->statusContracts->contains($statusContract)) {
            $this->statusContracts[] = $statusContract;
            $statusContract->setContractStatusType($this);
        }

        return $this;
    }

    public function removeStatusContract(StatusContract $statusContract): self
    {
        if ($this->statusContracts->removeElement($statusContract)) {
            // set the owning side to null (unless already changed)
            if ($statusContract->getContractStatusType() === $this) {
                $statusContract->setContractStatusType(null);
            }
        }

        return $this;
    }
}
