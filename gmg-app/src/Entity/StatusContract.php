<?php

namespace App\Entity;

use App\Repository\StatusContractRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusContractRepository::class)
 */
class StatusContract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="statusContracts")
     */
    private $staff;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="statusContracts")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=ContractStatusTypes::class, inversedBy="statusContracts")
     */
    private $contractStatusType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
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

    public function getContractStatusType(): ?ContractStatusTypes
    {
        return $this->contractStatusType;
    }

    public function setContractStatusType(?ContractStatusTypes $contractStatusType): self
    {
        $this->contractStatusType = $contractStatusType;

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

    public function setAddDate(\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }
}
