<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 * @ORM\Table(name="status_equivalence")
 */
class Status
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="statuses")
     */
    private $staff;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="statuses")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=PackTypes::class, inversedBy="statuses")
     */
    private $packType;

    /**
     * @ORM\ManyToOne(targetEntity=StatusTypes::class, inversedBy="statuses")
     */
    private $statusType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $note;

    /**
     * @ORM\Column(name="status_datetime",type="datetime", nullable=true)
     */
    private $addDate;

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

    public function getCandidate(): ?Condidates
    {
        return $this->candidate;
    }

    public function setCandidate(?Condidates $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getPackType(): ?PackTypes
    {
        return $this->packType;
    }

    public function setPackType(?PackTypes $packType): self
    {
        $this->packType = $packType;

        return $this;
    }

    public function getStatusType(): ?StatusTypes
    {
        return $this->statusType;
    }

    public function setStatusType(?StatusTypes $statusType): self
    {
        $this->statusType = $statusType;

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

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->addDate;
    }

    public function setAddDate(?\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }
}
