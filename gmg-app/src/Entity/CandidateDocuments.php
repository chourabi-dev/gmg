<?php

namespace App\Entity;

use App\Repository\CandidateDocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidateDocumentsRepository::class)
 */
class CandidateDocuments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="candidateDocuments")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=DocumentTypes::class, inversedBy="candidateDocuments")
     */
    private $documentType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $issueDate;

    /**
     * @ORM\Column(type="string")
     */
    private $expiryDate;

    /**
     * @ORM\OneToMany(targetEntity=Files::class, mappedBy="candidateDocument")
     */
    private $files;



    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

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

    public function getDocumentType(): ?DocumentTypes
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentTypes $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getIdNumber(): ?string
    {
        return $this->idNumber;
    }

    public function setIdNumber(string $idNumber): self
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    public function getIssueDate(): ?\DateTimeInterface
    {
        return $this->issueDate;
    }

    public function setIssueDate(\DateTimeInterface $issueDate): self
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    public function getExpiryDate(): ?string
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(string $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * @return Collection|Files[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(Files $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setCandidateDocument($this);
        }

        return $this;
    }

    public function removeFile(Files $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getCandidateDocument() === $this) {
                $file->setCandidateDocument(null);
            }
        }

        return $this;
    }


}
