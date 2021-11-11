<?php

namespace App\Entity;

use App\Repository\AllowanceTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AllowanceTypesRepository::class)
 */
class AllowanceTypes
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
    private $allowanceType;

    /**
     * @ORM\OneToMany(targetEntity=Allowances::class, mappedBy="allowanceType")
     */
    private $allowances;

    public function __construct()
    {
        $this->allowances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAllowanceType(): ?string
    {
        return $this->allowanceType;
    }

    public function setAllowanceType(string $allowanceType): self
    {
        $this->allowanceType = $allowanceType;

        return $this;
    }

    /**
     * @return Collection|Allowances[]
     */
    public function getAllowances(): Collection
    {
        return $this->allowances;
    }

    public function addAllowance(Allowances $allowance): self
    {
        if (!$this->allowances->contains($allowance)) {
            $this->allowances[] = $allowance;
            $allowance->setAllowanceType($this);
        }

        return $this;
    }

    public function removeAllowance(Allowances $allowance): self
    {
        if ($this->allowances->removeElement($allowance)) {
            // set the owning side to null (unless already changed)
            if ($allowance->getAllowanceType() === $this) {
                $allowance->setAllowanceType(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->allowanceType;
    }
}
