<?php

namespace App\Entity;

use App\Repository\CompanyTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CompanyTypesRepository::class)
 * @UniqueEntity("companyType")
 */
class CompanyTypes
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
    private $companyType;

    /**
     * @ORM\OneToMany(targetEntity=Companies::class, mappedBy="companyType")
     */
    private $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyType(): ?string
    {
        return $this->companyType;
    }

    public function setCompanyType(string $companyType): self
    {
        $this->companyType = $companyType;

        return $this;
    }

    /**
     * @return Collection|Companies[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Companies $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setCompanyType($this);
        }

        return $this;
    }

    public function removeCompany(Companies $company): self
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getCompanyType() === $this) {
                $company->setCompanyType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->companyType;
    }

}
