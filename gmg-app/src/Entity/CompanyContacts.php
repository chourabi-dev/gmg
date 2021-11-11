<?php

namespace App\Entity;

use App\Repository\CompanyContactsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyContactsRepository::class)
 */
class CompanyContacts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Contacts::class, inversedBy="companyContacts")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="companyContacts")
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vcard;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessCardFaceOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessCardFaceTwo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContact(): ?Contacts
    {
        return $this->contact;
    }

    public function setContact(?Contacts $contact): self
    {
        $this->contact = $contact;

        return $this;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getVcard(): ?string
    {
        return $this->vcard;
    }

    public function setVcard(string $vcard): self
    {
        $this->vcard = $vcard;

        return $this;
    }

    public function getBusinessCardFaceOne(): ?string
    {
        return $this->businessCardFaceOne;
    }

    public function setBusinessCardFaceOne(?string $businessCardFaceOne): self
    {
        $this->businessCardFaceOne = $businessCardFaceOne;

        return $this;
    }

    public function getBusinessCardFaceTwo(): ?string
    {
        return $this->businessCardFaceTwo;
    }

    public function setBusinessCardFaceTwo(?string $businessCardFaceTwo): self
    {
        $this->businessCardFaceTwo = $businessCardFaceTwo;

        return $this;
    }
}
