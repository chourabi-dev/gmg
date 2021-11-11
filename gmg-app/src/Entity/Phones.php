<?php

namespace App\Entity;

use App\Repository\PhonesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhonesRepository::class)
 */
class Phones
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="phoneNumber")
     */
    private $candidate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $displayOrder;

    /**
     * @ORM\ManyToOne(targetEntity=PhoneTypes::class, inversedBy="phones")
     */
    private $phoneType;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="phones")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Contacts::class, inversedBy="phones")
     */
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?Condidates
    {
        return $this->candidate;
    }

    public function setCandidate(?Condidates $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(?int $displayOrder): self
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    public function getPhoneType(): ?PhoneTypes
    {
        return $this->phoneType;
    }

    public function setPhoneType(?PhoneTypes $phoneType): self
    {
        $this->phoneType = $phoneType;

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

    public function getContact(): ?Contacts
    {
        return $this->contact;
    }

    public function setContact(?Contacts $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
