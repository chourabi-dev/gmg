<?php

namespace App\Entity;

use App\Repository\PhoneTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PhoneTypesRepository::class)
 * @UniqueEntity("phoneType")
 */
class PhoneTypes
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
    private $phoneType;

    /**
     * @ORM\OneToMany(targetEntity=Phones::class, mappedBy="phoneType")
     */
    private $phones;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneType(): ?string
    {
        return $this->phoneType;
    }

    public function setPhoneType(string $phoneType): self
    {
        $this->phoneType = $phoneType;

        return $this;
    }

    /**
     * @return Collection|Phones[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phones $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setPhoneType($this);
        }

        return $this;
    }

    public function removePhone(Phones $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getPhoneType() === $this) {
                $phone->setPhoneType(null);
            }
        }

        return $this;
    }
}
