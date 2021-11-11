<?php

namespace App\Entity;

use App\Repository\CompanyDocumentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyDocumentsRepository::class)
 */
class CompanyDocuments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="companyDocuments")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=DocumentTypes::class, inversedBy="companyDocuments")
     */
    private $documentType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $docPDF;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expiryDate;

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

    public function getDocumentType(): ?DocumentTypes
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentTypes $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getDocPDF(): ?string
    {
        return $this->docPDF;
    }

    public function setDocPDF(string $docPDF): self
    {
        $this->docPDF = $docPDF;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }
}
