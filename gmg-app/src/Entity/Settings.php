<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nbrTelMax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dayStartWeek;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $periodicity = [];



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrTelMax(): ?int
    {
        return $this->nbrTelMax;
    }

    public function setNbrTelMax(int $nbrTelMax): self
    {
        $this->nbrTelMax = $nbrTelMax;

        return $this;
    }

    public function getDayStartWeek(): ?string
    {
        return $this->dayStartWeek;
    }

    public function setDayStartWeek(string $dayStartWeek): self
    {
        $this->dayStartWeek = $dayStartWeek;

        return $this;
    }

    public function getPeriodicity(): ?array
    {
        

        return array_unique($this->periodicity);
    }

    public function setPeriodicity(?array $periodicity): self
    {
        $this->periodicity = $periodicity;

        return $this;
    }


}
