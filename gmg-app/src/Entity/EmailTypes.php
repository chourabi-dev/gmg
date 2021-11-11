<?php

namespace App\Entity;

use App\Repository\EmailTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EmailTypesRepository::class)
 * @UniqueEntity("emailType")
 */
class EmailTypes
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
    private $emailType;

    /**
     * @ORM\OneToMany(targetEntity=Emails::class, mappedBy="emailType")
     */
    private $emails;

    public function __construct()
    {
        $this->emails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailType(): ?string
    {
        return $this->emailType;
    }

    public function setEmailType(string $emailType): self
    {
        $this->emailType = $emailType;

        return $this;
    }

    /**
     * @return Collection|Emails[]
     */
    public function getEmails(): Collection
    {
        return $this->emails;
    }

    public function addEmail(Emails $email): self
    {
        if (!$this->emails->contains($email)) {
            $this->emails[] = $email;
            $email->setEmailType($this);
        }

        return $this;
    }

    public function removeEmail(Emails $email): self
    {
        if ($this->emails->removeElement($email)) {
            // set the owning side to null (unless already changed)
            if ($email->getEmailType() === $this) {
                $email->setEmailType(null);
            }
        }

        return $this;
    }
}
