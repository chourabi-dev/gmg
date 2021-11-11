<?php

namespace App\Entity;

use App\Repository\DocumentTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=DocumentTypesRepository::class)
 * 
 */
class DocumentTypes
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
    private $DocumentType;

    /**
     * @ORM\ManyToOne(targetEntity=DocumentRef::class, inversedBy="documentTypes")
     */
    private $documentRef;

    /**
     * @ORM\OneToMany(targetEntity=CandidateDocuments::class, mappedBy="documentType")
     */
    private $candidateDocuments;

    /**
     * @ORM\OneToMany(targetEntity=CompanyDocuments::class, mappedBy="documentType")
     */
    private $companyDocuments;

    public function __construct()
    {
        $this->candidateDocuments = new ArrayCollection();
        $this->companyDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentType(): ?string
    {
        return $this->DocumentType;
    }

    public function setDocumentType(string $DocumentType): self
    {
        $this->DocumentType = $DocumentType;

        return $this;
    }

    public function getDocumentRef(): ?DocumentRef
    {
        return $this->documentRef;
    }

    public function setDocumentRef(?DocumentRef $documentRef): self
    {
        $this->documentRef = $documentRef;

        return $this;
    }

    /**
     * @return Collection|CandidateDocuments[]
     */
    public function getCandidateDocuments(): Collection
    {
        return $this->candidateDocuments;
    }

    public function addCandidateDocument(CandidateDocuments $candidateDocument): self
    {
        if (!$this->candidateDocuments->contains($candidateDocument)) {
            $this->candidateDocuments[] = $candidateDocument;
            $candidateDocument->setDocumentType($this);
        }

        return $this;
    }

    public function removeCandidateDocument(CandidateDocuments $candidateDocument): self
    {
        if ($this->candidateDocuments->removeElement($candidateDocument)) {
            // set the owning side to null (unless already changed)
            if ($candidateDocument->getDocumentType() === $this) {
                $candidateDocument->setDocumentType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->DocumentType;
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
            $companyDocument->setDocumentType($this);
        }

        return $this;
    }

    public function removeCompanyDocument(CompanyDocuments $companyDocument): self
    {
        if ($this->companyDocuments->removeElement($companyDocument)) {
            // set the owning side to null (unless already changed)
            if ($companyDocument->getDocumentType() === $this) {
                $companyDocument->setDocumentType(null);
            }
        }

        return $this;
    }
}
