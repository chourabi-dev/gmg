<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilesRepository::class)
 */
class Files
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
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=CandidateDocuments::class, inversedBy="files")
     */
    private $candidateDocument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getCandidateDocument(): ?CandidateDocuments
    {
        return $this->candidateDocument;
    }

    public function setCandidateDocument(?CandidateDocuments $candidateDocument): self
    {
        $this->candidateDocument = $candidateDocument;

        return $this;
    }
}
