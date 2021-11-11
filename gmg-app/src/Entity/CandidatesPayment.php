<?php

namespace App\Entity;

use App\Repository\CandidatesPaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatesPaymentRepository::class)
 */
class CandidatesPayment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="candidatesPayments")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentHistory::class, inversedBy="candidatesPayments")
     */
    private $paymentHistory;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;
    

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

    public function getPaymentHistory(): ?PaymentHistory
    {
        return $this->paymentHistory;
    }

    public function setPaymentHistory(?PaymentHistory $paymentHistory): self
    {
        $this->paymentHistory = $paymentHistory;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
