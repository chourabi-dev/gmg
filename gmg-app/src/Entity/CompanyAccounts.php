<?php

namespace App\Entity;

use App\Repository\CompanyAccountsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyAccountsRepository::class)
 */
class CompanyAccounts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="companyAccounts")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=BankInformations::class, inversedBy="companyAccounts")
     */
    private $bankInformations;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Companies
    {
        return $this->company;
    }

    public function setCompany(?Companies $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getBankInformations(): ?BankInformations
    {
        return $this->bankInformations;
    }

    public function setBankInformations(?BankInformations $bankInformations): self
    {
        $this->bankInformations = $bankInformations;

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
}
