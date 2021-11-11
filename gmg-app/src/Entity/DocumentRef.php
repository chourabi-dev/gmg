<?php

namespace App\Entity;

use App\Repository\DocumentRefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=DocumentRefRepository::class)
 * @UniqueEntity("DocumentRef")
 */
class DocumentRef
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
    private $DocumentRef;

    /**
     * @ORM\OneToMany(targetEntity=DocumentTypes::class, mappedBy="documentRef")
     */
    private $documentTypes;

    public function __construct()
    {
        $this->documentTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentRef(): ?string
    {
        return $this->DocumentRef;
    }

    public function setDocumentRef(string $DocumentRef): self
    {
        $this->DocumentRef = $DocumentRef;

        return $this;
    }

    /**
     * @return Collection|DocumentTypes[]
     */
    public function getDocumentTypes(): Collection
    {
        return $this->documentTypes;
    }

    public function addDocumentType(DocumentTypes $documentType): self
    {
        if (!$this->documentTypes->contains($documentType)) {
            $this->documentTypes[] = $documentType;
            $documentType->setDocumentRef($this);
        }

        return $this;
    }

    public function removeDocumentType(DocumentTypes $documentType): self
    {
        if ($this->documentTypes->removeElement($documentType)) {
            // set the owning side to null (unless already changed)
            if ($documentType->getDocumentRef() === $this) {
                $documentType->setDocumentRef(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->DocumentRef;
    }
}
