<?php

namespace App\Entity;

use App\Repository\AllowancesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AllowancesRepository::class)
 */
class Allowances
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=AllowanceTypes::class, inversedBy="allowances")
     */
    private $allowanceType;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $periodicity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAllowanceType(): ?AllowanceTypes
    {
        return $this->allowanceType;
    }

    public function setAllowanceType(?AllowanceTypes $allowanceType): self
    {
        $this->allowanceType = $allowanceType;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getPeriodicity(): ?string
    {
        return $this->periodicity;
    }

    public function setPeriodicity(string $periodicity): self
    {
        $this->periodicity = $periodicity;

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
}
