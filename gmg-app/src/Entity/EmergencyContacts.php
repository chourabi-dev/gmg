<?php

namespace App\Entity;

use App\Repository\EmergencyContactsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmergencyContactsRepository::class)
 */
class EmergencyContacts
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
    private $nameEmergency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mobileEmergency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailEmergency;

    /**
     * @ORM\ManyToOne(targetEntity=RelativeTypes::class, inversedBy="emergencyContacts")
     */
    private $relativeType;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="emergencyContacts")
     */
    private $staff;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEmergency(): ?string
    {
        return $this->nameEmergency;
    }

    public function setNameEmergency(string $nameEmergency): self
    {
        $this->nameEmergency = $nameEmergency;

        return $this;
    }

    public function getMobileEmergency(): ?string
    {
        return $this->mobileEmergency;
    }

    public function setMobileEmergency(string $mobileEmergency): self
    {
        $this->mobileEmergency = $mobileEmergency;

        return $this;
    }

    public function getEmailEmergency(): ?string
    {
        return $this->emailEmergency;
    }

    public function setEmailEmergency(string $emailEmergency): self
    {
        $this->emailEmergency = $emailEmergency;

        return $this;
    }

    public function getRelativeType(): ?RelativeTypes
    {
        return $this->relativeType;
    }

    public function setRelativeType(?RelativeTypes $relativeType): self
    {
        $this->relativeType = $relativeType;

        return $this;
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


}
