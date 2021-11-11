<?php

namespace App\Entity;

use App\Repository\ContractsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContractsRepository::class)
 */
class Contracts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ContractTypes::class, inversedBy="contracts")
     */
    private $contractType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contractPdf;

    /**
     * @ORM\Column(type="date")
     */
    private $DateStartContract;


    /**
     * @ORM\Column(type="float")
     */
    private $salary;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $daysOff;

    /**
     * @ORM\OneToMany(targetEntity=StaffContracts::class, mappedBy="contract")
     */
    private $staffContracts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ContractDoc;

    /**
     * @ORM\Column(type="integer")
     */
    private $probation;

    /**
     * @ORM\Column(type="integer")
     */
    private $noticePeriode;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DateEndContract;

    public function __construct()
    {
        $this->staffContracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractType(): ?ContractTypes
    {
        return $this->contractType;
    }

    public function setContractType(?ContractTypes $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getContractPdf(): ?string
    {
        return $this->contractPdf;
    }

    public function setContractPdf(string $contractPdf): self
    {
        $this->contractPdf = $contractPdf;

        return $this;
    }

    public function getDateStartContract(): ?\DateTimeInterface
    {
        return $this->DateStartContract;
    }

    public function setDateStartContract(\DateTimeInterface $DateStartContract): self
    {
        $this->DateStartContract = $DateStartContract;

        return $this;
    }



    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getDaysOff(): ?int
    {
        return $this->daysOff;
    }

    public function setDaysOff(?int $daysOff): self
    {
        $this->daysOff = $daysOff;

        return $this;
    }

    /**
     * @return Collection|StaffContracts[]
     */
    public function getStaffContracts(): Collection
    {
        return $this->staffContracts;
    }

    public function addStaffContract(StaffContracts $staffContract): self
    {
        if (!$this->staffContracts->contains($staffContract)) {
            $this->staffContracts[] = $staffContract;
            $staffContract->setContract($this);
        }

        return $this;
    }

    public function removeStaffContract(StaffContracts $staffContract): self
    {
        if ($this->staffContracts->removeElement($staffContract)) {
            // set the owning side to null (unless already changed)
            if ($staffContract->getContract() === $this) {
                $staffContract->setContract(null);
            }
        }

        return $this;
    }

    public function getContractDoc(): ?string
    {
        return $this->ContractDoc;
    }

    public function setContractDoc(string $ContractDoc): self
    {
        $this->ContractDoc = $ContractDoc;

        return $this;
    }

    public function getProbation(): ?int
    {
        return $this->probation;
    }

    public function setProbation(int $probation): self
    {
        $this->probation = $probation;

        return $this;
    }

    public function getNoticePeriode(): ?int
    {
        return $this->noticePeriode;
    }

    public function setNoticePeriode(int $noticePeriode): self
    {
        $this->noticePeriode = $noticePeriode;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(?bool $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getDateEndContract(): ?string
    {
        return $this->DateEndContract;
    }

    public function setDateEndContract(?string $DateEndContract): self
    {
        $this->DateEndContract = $DateEndContract;

        return $this;
    }
}
