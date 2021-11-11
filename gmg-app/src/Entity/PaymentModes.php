<?php

namespace App\Entity;

use App\Repository\PaymentModesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PaymentModesRepository::class)
 * @UniqueEntity("paymentMode")
 */
class PaymentModes
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
    private $paymentMode;

    /**
     * @ORM\OneToMany(targetEntity=PaymentHistory::class, mappedBy="paymentMode")
     */
    private $paymentHistories;

    public function __construct()
    {
        $this->paymentHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentMode(): ?string
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(string $paymentMode): self
    {
        $this->paymentMode = $paymentMode;

        return $this;
    }

    /**
     * @return Collection|PaymentHistory[]
     */
    public function getPaymentHistories(): Collection
    {
        return $this->paymentHistories;
    }

    public function addPaymentHistory(PaymentHistory $paymentHistory): self
    {
        if (!$this->paymentHistories->contains($paymentHistory)) {
            $this->paymentHistories[] = $paymentHistory;
            $paymentHistory->setPaymentMode($this);
        }

        return $this;
    }

    public function removePaymentHistory(PaymentHistory $paymentHistory): self
    {
        if ($this->paymentHistories->removeElement($paymentHistory)) {
            // set the owning side to null (unless already changed)
            if ($paymentHistory->getPaymentMode() === $this) {
                $paymentHistory->setPaymentMode(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->paymentMode;
    }
}
