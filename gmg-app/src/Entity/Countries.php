<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountriesRepository::class)
 */
class Countries
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
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=Holidays::class, mappedBy="country")
     */
    private $holidays;

    public function __construct()
    {
        $this->holidays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Holidays[]
     */
    public function getHolidays(): Collection
    {
        return $this->holidays;
    }

    public function addHoliday(Holidays $holiday): self
    {
        if (!$this->holidays->contains($holiday)) {
            $this->holidays[] = $holiday;
            $holiday->setCountry($this);
        }

        return $this;
    }

    public function removeHoliday(Holidays $holiday): self
    {
        if ($this->holidays->removeElement($holiday)) {
            // set the owning side to null (unless already changed)
            if ($holiday->getCountry() === $this) {
                $holiday->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->country;
    }
}
