<?php

namespace App\Entity;

use App\Repository\EmailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmailsRepository::class)
 */
class Emails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="emails")
     */
    private $candiate;

    /**
     * @ORM\ManyToOne(targetEntity=EmailTypes::class, inversedBy="emails")
     */
    private $emailType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="emails")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Contacts::class, inversedBy="emails")
     */
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandiate(): ?Condidates
    {
        return $this->candiate;
    }

    public function setCandiate(?Condidates $candiate): self
    {
        $this->candiate = $candiate;

        return $this;
    }

    public function getEmailType(): ?EmailTypes
    {
        return $this->emailType;
    }

    public function setEmailType(?EmailTypes $emailType): self
    {
        $this->emailType = $emailType;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCompany(): ?Companies
    {
        return $this->company;
    }

    public function setCompany(?Companies $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getContact(): ?Contacts
    {
        return $this->contact;
    }

    public function setContact(?Contacts $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
