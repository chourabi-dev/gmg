<?php

namespace App\Entity;

use App\Repository\CompaniesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompaniesRepository::class)
 */
class Companies
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
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyLogo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=CompanyLocations::class, mappedBy="company")
     */
    private $companyLocations;

    /**
     * @ORM\OneToMany(targetEntity=Phones::class, mappedBy="company")
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity=Emails::class, mappedBy="company")
     */
    private $emails;

    /**
     * @ORM\OneToMany(targetEntity=SocialMedia::class, mappedBy="company")
     */
    private $socialMedia;

    /**
     * @ORM\OneToMany(targetEntity=CompanyAccounts::class, mappedBy="company")
     */
    private $companyAccounts;

    /**
     * @ORM\OneToMany(targetEntity=PrivateNotes::class, mappedBy="company")
     */
    private $privateNotes;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyTypes::class, inversedBy="companies")
     */
    private $companyType;

    /**
     * @ORM\ManyToOne(targetEntity=IndustryTypes::class, inversedBy="companies")
     */
    private $industry;

    /**
     * @ORM\OneToMany(targetEntity=CompanyDocuments::class, mappedBy="company")
     */
    private $companyDocuments;

    /**
     * @ORM\OneToMany(targetEntity=CompanyContacts::class, mappedBy="company")
     */
    private $companyContacts;

    public function __construct()
    {
        $this->companyLocations = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->socialMedia = new ArrayCollection();
        $this->companyAccounts = new ArrayCollection();
        $this->privateNotes = new ArrayCollection();
        $this->companyDocuments = new ArrayCollection();
        $this->companyContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyLogo(): ?string
    {
        return $this->companyLogo;
    }

    public function setCompanyLogo(string $companyLogo): self
    {
        $this->companyLogo = $companyLogo;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|CompanyLocations[]
     */
    public function getCompanyLocations(): Collection
    {
        return $this->companyLocations;
    }

    public function addCompanyLocation(CompanyLocations $companyLocation): self
    {
        if (!$this->companyLocations->contains($companyLocation)) {
            $this->companyLocations[] = $companyLocation;
            $companyLocation->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyLocation(CompanyLocations $companyLocation): self
    {
        if ($this->companyLocations->removeElement($companyLocation)) {
            // set the owning side to null (unless already changed)
            if ($companyLocation->getCompany() === $this) {
                $companyLocation->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Phones[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phones $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setCompany($this);
        }

        return $this;
    }

    public function removePhone(Phones $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getCompany() === $this) {
                $phone->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Emails[]
     */
    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function addEmail(Emails $email): self
    {
        if (!$this->emails->contains($email)) {
            $this->emails[] = $email;
            $email->setCompany($this);
        }

        return $this;
    }

    public function removeEmail(Emails $email): self
    {
        if ($this->emails->removeElement($email)) {
            // set the owning side to null (unless already changed)
            if ($email->getCompany() === $this) {
                $email->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SocialMedia[]
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }

    public function addSocialMedium(SocialMedia $socialMedium): self
    {
        if (!$this->socialMedia->contains($socialMedium)) {
            $this->socialMedia[] = $socialMedium;
            $socialMedium->setCompany($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): self
    {
        if ($this->socialMedia->removeElement($socialMedium)) {
            // set the owning side to null (unless already changed)
            if ($socialMedium->getCompany() === $this) {
                $socialMedium->setCompany(null);
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
            $companyAccount->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyAccount(CompanyAccounts $companyAccount): self
    {
        if ($this->companyAccounts->removeElement($companyAccount)) {
            // set the owning side to null (unless already changed)
            if ($companyAccount->getCompany() === $this) {
                $companyAccount->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrivateNotes[]
     */
    public function getPrivateNotes(): Collection
    {
        return $this->privateNotes;
    }

    public function addPrivateNote(PrivateNotes $privateNote): self
    {
        if (!$this->privateNotes->contains($privateNote)) {
            $this->privateNotes[] = $privateNote;
            $privateNote->setCompany($this);
        }

        return $this;
    }

    public function removePrivateNote(PrivateNotes $privateNote): self
    {
        if ($this->privateNotes->removeElement($privateNote)) {
            // set the owning side to null (unless already changed)
            if ($privateNote->getCompany() === $this) {
                $privateNote->setCompany(null);
            }
        }

        return $this;
    }

    public function getCompanyType(): ?CompanyTypes
    {
        return $this->companyType;
    }

    public function setCompanyType(?CompanyTypes $companyType): self
    {
        $this->companyType = $companyType;

        return $this;
    }

    public function getIndustry(): ?IndustryTypes
    {
        return $this->industry;
    }

    public function setIndustry(?IndustryTypes $industry): self
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * @return Collection|CompanyDocuments[]
     */
    public function getCompanyDocuments(): Collection
    {
        return $this->companyDocuments;
    }

    public function addCompanyDocument(CompanyDocuments $companyDocument): self
    {
        if (!$this->companyDocuments->contains($companyDocument)) {
            $this->companyDocuments[] = $companyDocument;
            $companyDocument->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyDocument(CompanyDocuments $companyDocument): self
    {
        if ($this->companyDocuments->removeElement($companyDocument)) {
            // set the owning side to null (unless already changed)
            if ($companyDocument->getCompany() === $this) {
                $companyDocument->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompanyContacts[]
     */
    public function getCompanyContacts(): Collection
    {
        return $this->companyContacts;
    }

    public function addCompanyContact(CompanyContacts $companyContact): self
    {
        if (!$this->companyContacts->contains($companyContact)) {
            $this->companyContacts[] = $companyContact;
            $companyContact->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyContact(CompanyContacts $companyContact): self
    {
        if ($this->companyContacts->removeElement($companyContact)) {
            // set the owning side to null (unless already changed)
            if ($companyContact->getCompany() === $this) {
                $companyContact->setCompany(null);
            }
        }

        return $this;
    }
}
