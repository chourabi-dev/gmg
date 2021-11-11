<?php

namespace App\Entity;

use App\Repository\PaymentHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentHistoryRepository::class)
 */
class PaymentHistory
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
    private $paymentDate;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentModes::class, inversedBy="paymentHistories")
     */
    private $paymentMode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $receipt;

    /**
     * @ORM\OneToMany(targetEntity=CandidatesPayment::class, mappedBy="paymentHistory")
     */
    private $candidatesPayments;

    public function __construct()
    {
        $this->candidatesPayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentDate(): ?string
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(string $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

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

    public function getPaymentMode(): ?PaymentModes
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(?PaymentModes $paymentMode): self
    {
        $this->paymentMode = $paymentMode;

        return $this;
    }

    public function getReceipt(): ?string
    {
        return $this->receipt;
    }

    public function setReceipt(string $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return Collection|CandidatesPayment[]
     */
    public function getCandidatesPayments(): Collection
    {
        return $this->candidatesPayments;
    }

    public function addCandidatesPayment(CandidatesPayment $candidatesPayment): self
    {
        if (!$this->candidatesPayments->contains($candidatesPayment)) {
            $this->candidatesPayments[] = $candidatesPayment;
            $candidatesPayment->setPaymentHistory($this);
        }

        return $this;
    }

    public function removeCandidatesPayment(CandidatesPayment $candidatesPayment): self
    {
        if ($this->candidatesPayments->removeElement($candidatesPayment)) {
            // set the owning side to null (unless already changed)
            if ($candidatesPayment->getPaymentHistory() === $this) {
                $candidatesPayment->setPaymentHistory(null);
            }
        }

        return $this;
    }
}
