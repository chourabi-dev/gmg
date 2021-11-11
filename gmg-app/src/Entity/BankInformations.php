<?php

namespace App\Entity;

use App\Repository\BankInformationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BankInformationsRepository::class)
 */
class BankInformations
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
    private $bankName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $BankAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $acountNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $beneficiaryName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $swiftcode;

    /**
     * @ORM\OneToMany(targetEntity=Staff::class, mappedBy="bankInformation")
     */
    private $staff;

    /**
     * @ORM\OneToMany(targetEntity=CompanyAccounts::class, mappedBy="bankInformations")
     */
    private $companyAccounts;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
        $this->companyAccounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function setBankName(string $bankName): self
    {
        $this->bankName = $bankName;

        return $this;
    }

    public function getBankAddress(): ?string
    {
        return $this->BankAddress;
    }

    public function setBankAddress(string $BankAddress): self
    {
        $this->BankAddress = $BankAddress;

        return $this;
    }

    public function getAcountNumber(): ?string
    {
        return $this->acountNumber;
    }

    public function setAcountNumber(string $acountNumber): self
    {
        $this->acountNumber = $acountNumber;

        return $this;
    }

    public function getBeneficiaryName(): ?string
    {
        return $this->beneficiaryName;
    }

    public function setBeneficiaryName(string $beneficiaryName): self
    {
        $this->beneficiaryName = $beneficiaryName;

        return $this;
    }

    public function getSwiftcode(): ?string
    {
        return $this->swiftcode;
    }

    public function setSwiftcode(string $swiftcode): self
    {
        $this->swiftcode = $swiftcode;

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
            $staff->setBankInformation($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getBankInformation() === $this) {
                $staff->setBankInformation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompanyAccounts[]
     */
    public function getCompanyAccounts(): Collection
    {
        return $this->companyAccounts;
    }

    public function addCompanyAccount(CompanyAccounts $companyAccount): self
    {
        if (!$this->companyAccounts->contains($companyAccount)) {
            $this->companyAccounts[] = $companyAccount;
            $companyAccount->setBankInformations($this);
        }

        return $this;
    }

    public function removeCompanyAccount(CompanyAccounts $companyAccount): self
    {
        if ($this->companyAccounts->removeElement($companyAccount)) {
            // set the owning side to null (unless already changed)
            if ($companyAccount->getBankInformations() === $this) {
                $companyAccount->setBankInformations(null);
            }
        }

        return $this;
    }
}
