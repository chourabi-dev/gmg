<?php

namespace App\Entity;

use App\Repository\ContactsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactsRepository::class)
 */
class Contacts
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
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dobContact;

    /**
     * @ORM\ManyToOne(targetEntity=Locations::class, inversedBy="contacts")
     */
    private $location;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=Phones::class, mappedBy="contact")
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity=Emails::class, mappedBy="contact")
     */
    private $emails;

    /**
     * @ORM\OneToMany(targetEntity=SocialMedia::class, mappedBy="contact")
     */
    private $socialMedia;

    /**
     * @ORM\OneToMany(targetEntity=PrivateNotes::class, mappedBy="contact")
     */
    private $privateNotes;

    /**
     * @ORM\OneToMany(targetEntity=ContactsLanguages::class, mappedBy="contact")
     */
    private $contactsLanguages;

    /**
     * @ORM\OneToMany(targetEntity=CompanyContacts::class, mappedBy="contact")
     */
    private $companyContacts;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->socialMedia = new ArrayCollection();
        $this->privateNotes = new ArrayCollection();
        $this->contactsLanguages = new ArrayCollection();
        $this->companyContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getDobContact(): ?string
    {
        return $this->dobContact;
    }

    public function setDobContact(string $dobContact): self
    {
        $this->dobContact = $dobContact;

        return $this;
    }

    public function getLocation(): ?Locations
    {
        return $this->location;
    }

    public function setLocation(?Locations $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

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
            $phone->setContact($this);
        }

        return $this;
    }

    public function removePhone(Phones $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getContact() === $this) {
                $phone->setContact(null);
            }
        }

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
            $email->setContact($this);
        }

        return $this;
    }

    public function removeEmail(Emails $email): self
    {
        if ($this->emails->removeElement($email)) {
            // set the owning side to null (unless already changed)
            if ($email->getContact() === $this) {
                $email->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SocialMedia[]
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }

    public function addSocialMedium(SocialMedia $socialMedium): self
    {
        if (!$this->socialMedia->contains($socialMedium)) {
            $this->socialMedia[] = $socialMedium;
            $socialMedium->setContact($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): self
    {
        if ($this->socialMedia->removeElement($socialMedium)) {
            // set the owning side to null (unless already changed)
            if ($socialMedium->getContact() === $this) {
                $socialMedium->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrivateNotes[]
     */
    public function getPrivateNotes(): Collection
    {
        return $this->privateNotes;
    }

    public function addPrivateNote(PrivateNotes $privateNote): self
    {
        if (!$this->privateNotes->contains($privateNote)) {
            $this->privateNotes[] = $privateNote;
            $privateNote->setContact($this);
        }

        return $this;
    }

    public function removePrivateNote(PrivateNotes $privateNote): self
    {
        if ($this->privateNotes->removeElement($privateNote)) {
            // set the owning side to null (unless already changed)
            if ($privateNote->getContact() === $this) {
                $privateNote->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ContactsLanguages[]
     */
    public function getContactsLanguages(): Collection
    {
        return $this->contactsLanguages;
    }

    public function addContactsLanguage(ContactsLanguages $contactsLanguage): self
    {
        if (!$this->contactsLanguages->contains($contactsLanguage)) {
            $this->contactsLanguages[] = $contactsLanguage;
            $contactsLanguage->setContact($this);
        }

        return $this;
    }

    public function removeContactsLanguage(ContactsLanguages $contactsLanguage): self
    {
        if ($this->contactsLanguages->removeElement($contactsLanguage)) {
            // set the owning side to null (unless already changed)
            if ($contactsLanguage->getContact() === $this) {
                $contactsLanguage->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompanyContacts[]
     */
    public function getCompanyContacts(): Collection
    {
        return $this->companyContacts;
    }

    public function addCompanyContact(CompanyContacts $companyContact): self
    {
        if (!$this->companyContacts->contains($companyContact)) {
            $this->companyContacts[] = $companyContact;
            $companyContact->setContact($this);
        }

        return $this;
    }

    public function removeCompanyContact(CompanyContacts $companyContact): self
    {
        if ($this->companyContacts->removeElement($companyContact)) {
            // set the owning side to null (unless already changed)
            if ($companyContact->getContact() === $this) {
                $companyContact->setContact(null);
            }
        }

        return $this;
    }
}
