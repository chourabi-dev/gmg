<?php

namespace App\Entity;

use App\Repository\IndustryTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=IndustryTypesRepository::class)
 * @UniqueEntity("industryType")
 */
class IndustryTypes
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
    private $industryType;

    /**
     * @ORM\OneToMany(targetEntity=Companies::class, mappedBy="industry")
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

    public function getIndustryType(): ?string
    {
        return $this->industryType;
    }

    public function setIndustryType(string $industryType): self
    {
        $this->industryType = $industryType;

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
            $company->setIndustry($this);
        }

        return $this;
    }

    public function removeCompany(Companies $company): self
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getIndustry() === $this) {
                $company->setIndustry(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->industryType;
    }
}
