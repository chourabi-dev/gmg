<?php

namespace App\Entity;

use App\Repository\LocationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationsRepository::class)
 */
class Locations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addresse1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addresse2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=LocationToStaff::class, mappedBy="location")
     */
    private $locationToStaff;

    /**
     * @ORM\OneToMany(targetEntity=CandidateLocations::class, mappedBy="location")
     */
    private $candidateLocations;

    /**
     * @ORM\OneToMany(targetEntity=CompanyLocations::class, mappedBy="location")
     */
    private $companyLocations;

    /**
     * @ORM\OneToMany(targetEntity=Contacts::class, mappedBy="location")
     */
    private $contacts;

    public function __construct()
    {
        $this->locationToStaff = new ArrayCollection();
        $this->candidateLocations = new ArrayCollection();
        $this->companyLocations = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddresse1(): ?string
    {
        return $this->addresse1;
    }

    public function setAddresse1(?string $addresse1): self
    {
        $this->addresse1 = $addresse1;

        return $this;
    }

    public function getAddresse2(): ?string
    {
        return $this->addresse2;
    }

    public function setAddresse2(?string $addresse2): self
    {
        $this->addresse2 = $addresse2;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|LocationToStaff[]
     */
    public function getLocationToStaff(): Collection
    {
        return $this->locationToStaff;
    }

    public function addLocationToStaff(LocationToStaff $locationToStaff): self
    {
        if (!$this->locationToStaff->contains($locationToStaff)) {
            $this->locationToStaff[] = $locationToStaff;
            $locationToStaff->setLocation($this);
        }

        return $this;
    }

    public function removeLocationToStaff(LocationToStaff $locationToStaff): self
    {
        if ($this->locationToStaff->removeElement($locationToStaff)) {
            // set the owning side to null (unless already changed)
            if ($locationToStaff->getLocation() === $this) {
                $locationToStaff->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CandidateLocations[]
     */
    public function getCandidateLocations(): Collection
    {
        return $this->candidateLocations;
    }

    public function addCandidateLocation(CandidateLocations $candidateLocation): self
    {
        if (!$this->candidateLocations->contains($candidateLocation)) {
            $this->candidateLocations[] = $candidateLocation;
            $candidateLocation->setLocation($this);
        }

        return $this;
    }

    public function removeCandidateLocation(CandidateLocations $candidateLocation): self
    {
        if ($this->candidateLocations->removeElement($candidateLocation)) {
            // set the owning side to null (unless already changed)
            if ($candidateLocation->getLocation() === $this) {
                $candidateLocation->setLocation(null);
            }
        }

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
            $companyLocation->setLocation($this);
        }

        return $this;
    }

    public function removeCompanyLocation(CompanyLocations $companyLocation): self
    {
        if ($this->companyLocations->removeElement($companyLocation)) {
            // set the owning side to null (unless already changed)
            if ($companyLocation->getLocation() === $this) {
                $companyLocation->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contacts[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setLocation($this);
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getLocation() === $this) {
                $contact->setLocation(null);
            }
        }

        return $this;
    }
}
