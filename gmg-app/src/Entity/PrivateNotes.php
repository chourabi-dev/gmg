<?php

namespace App\Entity;

use App\Repository\PrivateNotesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrivateNotesRepository::class)
 */
class PrivateNotes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="privateNotes")
     */
    private $staff;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAddNote;

    /**
     * @ORM\ManyToOne(targetEntity=Subjects::class, inversedBy="privateNotes")
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="privateNotes")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="privateNotes")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Contacts::class, inversedBy="privateNotes")
     */
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getDateAddNote(): ?\DateTimeInterface
    {
        return $this->dateAddNote;
    }

    public function setDateAddNote(\DateTimeInterface $dateAddNote): self
    {
        $this->dateAddNote = $dateAddNote;

        return $this;
    }

    public function getSubject(): ?Subjects
    {
        return $this->subject;
    }

    public function setSubject(?Subjects $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
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
