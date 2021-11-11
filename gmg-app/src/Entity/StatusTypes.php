<?php

namespace App\Entity;

use App\Repository\StatusTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
// this entitys belongs to the equivalance status types
/**
 * @ORM\Entity(repositoryClass=StatusTypesRepository::class)
 * @UniqueEntity("statusType")
 */
class StatusTypes
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
    private $statusType;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $ordre;

    /**
     * @ORM\OneToMany(targetEntity=Status::class, mappedBy="statusType")
     */
    private $statuses;

    public function __construct()
    {
        $this->statuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusType(): ?string
    {
        return $this->statusType;
    }

    public function setStatusType(string $statusType): self
    {
        $this->statusType = $statusType;

        return $this;
    }

    public function getOrdre(): ?string
    {
        return $this->ordre;
    }

    public function setOrdre(string $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * @return Collection|Status[]
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(Status $status): self
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses[] = $status;
            $status->setStatusType($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->statuses->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getStatusType() === $this) {
                $status->setStatusType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->statusType;
    }
}
