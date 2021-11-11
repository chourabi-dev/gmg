<?php

namespace App\Entity;

use App\Repository\CondidatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CondidatesRepository::class)
 * @ORM\Table(name="candidates")
 */
class Condidates
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dob;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $otherExperience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $applicationFile;

    /**
     * @ORM\ManyToOne(targetEntity=FamilyStatusTypes::class, inversedBy="condidates")
     */
    private $familyStatusType;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class)
     */
    private $referredBy;

    /**
     * @ORM\ManyToOne(targetEntity=Agencies::class)
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity=SourceTypes::class)
     */
    private $source;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity=CandidateLocations::class, mappedBy="candidate")
     */
    private $locationType;

    /**
     * @ORM\OneToMany(targetEntity=Phones::class, mappedBy="candidate")
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity=Emails::class, mappedBy="candiate")
     */
    private $emails;

    /**
     * @ORM\OneToMany(targetEntity=SocialMedia::class, mappedBy="candidate")
     */
    private $socialMedia;

    /**
     * @ORM\OneToMany(targetEntity=PrivateNotes::class, mappedBy="candidate")
     */
    private $privateNotes;

    /**
     * @ORM\OneToMany(targetEntity=CandidateSkills::class, mappedBy="candidate")
     */
    private $candidateSkills;

    /**
     * @ORM\OneToMany(targetEntity=CandidatesLanguages::class, mappedBy="candidate")
     */
    private $candidatesLanguages;

    /**
     * @ORM\OneToMany(targetEntity=CandidatesPayment::class, mappedBy="candidate")
     */
    private $candidatesPayments;

    /**
     * @ORM\OneToMany(targetEntity=Status::class, mappedBy="candidate")
     */
    private $statuses;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $affilationDate;

    /**
     * @ORM\OneToMany(targetEntity=CandidateDocuments::class, mappedBy="candidate")
     */
    private $candidateDocuments;

    /**
     * @ORM\OneToMany(targetEntity=StatusContract::class, mappedBy="candidate")
     */
    private $statusContracts;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="condidates", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="condidates")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="condidates")
     */
    private $updatedBy;


    public function __construct()
    {
        $this->locationType = new ArrayCollection();
        $this->phoneNumber = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->socialMedia = new ArrayCollection();
        $this->privateNotes = new ArrayCollection();
        $this->candidateSkills = new ArrayCollection();
        $this->candidatesLanguages = new ArrayCollection();
        $this->candidatesPayments = new ArrayCollection();
        $this->statuses = new ArrayCollection();
        $this->candidateDocuments = new ArrayCollection();
        $this->statusContracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getDob(): ?string
    {
        return $this->dob;
    }

    public function setDob(string $dob): self
    {
        $this->dob = $dob;

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

    public function getOtherExperience(): ?string
    {
        return $this->otherExperience;
    }

    public function setOtherExperience(?string $otherExperience): self
    {
        $this->otherExperience = $otherExperience;

        return $this;
    }

    public function getApplicationFile(): ?string
    {
        return $this->applicationFile;
    }

    public function setApplicationFile(string $applicationFile): self
    {
        $this->applicationFile = $applicationFile;

        return $this;
    }

    public function getFamilyStatusType(): ?FamilyStatusTypes
    {
        return $this->familyStatusType;
    }

    public function setFamilyStatusType(?FamilyStatusTypes $familyStatusType): self
    {
        $this->familyStatusType = $familyStatusType;

        return $this;
    }

    public function getReferredBy(): ?self
    {
        return $this->referredBy;
    }

    public function setReferredBy(?self $referredBy): self
    {
        $this->referredBy = $referredBy;

        return $this;
    }

    public function getAgency(): ?Agencies
    {
        return $this->agency;
    }

    public function setAgency(?Agencies $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    public function getSource(): ?SourceTypes
    {
        return $this->source;
    }

    public function setSource(?SourceTypes $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
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

    /**
     * @return Collection|CandidateLocations[]
     */
    public function getLocationType(): Collection
    {
        return $this->locationType;
    }

    public function addLocationType(CandidateLocations $locationType): self
    {
        
        if (!$this->locationType->contains($locationType)) {
            $this->locationType[] = $locationType;
            $locationType->setCandidate($this);
        }

        return $this;
    }

    public function removeLocationType(CandidateLocations $locationType): self
    {
        if ($this->locationType->removeElement($locationType)) {
            // set the owning side to null (unless already changed)
            if ($locationType->getCandidate() === $this) {
                $locationType->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Phones[]
     */
    public function getPhoneNumber(): Collection
    {
        return $this->phoneNumber;
    }

    public function addPhoneNumber(Phones $phoneNumber): self
    {
        if (!$this->phoneNumber->contains($phoneNumber)) {
            $this->phoneNumber[] = $phoneNumber;
            $phoneNumber->setCandidate($this);
        }

        return $this;
    }

    public function removePhoneNumber(Phones $phoneNumber): self
    {
        if ($this->phoneNumber->removeElement($phoneNumber)) {
            // set the owning side to null (unless already changed)
            if ($phoneNumber->getCandidate() === $this) {
                $phoneNumber->setCandidate(null);
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
            $email->setCandiate($this);
        }

        return $this;
    }

    public function removeEmail(Emails $email): self
    {
        if ($this->emails->removeElement($email)) {
            // set the owning side to null (unless already changed)
            if ($email->getCandiate() === $this) {
                $email->setCandiate(null);
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
            $socialMedium->setCandidate($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): self
    {
        if ($this->socialMedia->removeElement($socialMedium)) {
            // set the owning side to null (unless already changed)
            if ($socialMedium->getCandidate() === $this) {
                $socialMedium->setCandidate(null);
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
            $privateNote->setCandidate($this);
        }

        return $this;
    }

    public function removePrivateNote(PrivateNotes $privateNote): self
    {
        if ($this->privateNotes->removeElement($privateNote)) {
            // set the owning side to null (unless already changed)
            if ($privateNote->getCandidate() === $this) {
                $privateNote->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CandidateSkills[]
     */
    public function getCandidateSkills(): Collection
    {
        return $this->candidateSkills;
    }


    public function addCandidateSkill(CandidateSkills $candidateSkill): self
    {
        if (!$this->candidateSkills->contains($candidateSkill)) {
            $this->candidateSkills[] = $candidateSkill;
            $candidateSkill->setCandidate($this);
        }

        return $this;
    }

    public function removeCandidateSkill(CandidateSkills $candidateSkill): self
    {
        if ($this->candidateSkills->removeElement($candidateSkill)) {
            // set the owning side to null (unless already changed)
            if ($candidateSkill->getCandidate() === $this) {
                $candidateSkill->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CandidatesLanguages[]
     */
    public function getCandidatesLanguages(): Collection
    {
        return $this->candidatesLanguages;
    }

    public function addCandidatesLanguage(CandidatesLanguages $candidatesLanguage): self
    {
        if (!$this->candidatesLanguages->contains($candidatesLanguage)) {
            $this->candidatesLanguages[] = $candidatesLanguage;
            $candidatesLanguage->setCandidate($this);
        }

        return $this;
    }

    public function removeCandidatesLanguage(CandidatesLanguages $candidatesLanguage): self
    {
        if ($this->candidatesLanguages->removeElement($candidatesLanguage)) {
            // set the owning side to null (unless already changed)
            if ($candidatesLanguage->getCandidate() === $this) {
                $candidatesLanguage->setCandidate(null);
            }
        }

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
            $candidatesPayment->setCandidate($this);
        }

        return $this;
    }

    public function removeCandidatesPayment(CandidatesPayment $candidatesPayment): self
    {
        if ($this->candidatesPayments->removeElement($candidatesPayment)) {
            // set the owning side to null (unless already changed)
            if ($candidatesPayment->getCandidate() === $this) {
                $candidatesPayment->setCandidate(null);
            }
        }

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
            $status->setCandidate($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->statuses->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getCandidate() === $this) {
                $status->setCandidate(null);
            }
        }

        return $this;
    }

    public function getAffilationDate(): ?\DateTimeInterface
    {
        return $this->affilationDate;
    }

    public function setAffilationDate(?\DateTimeInterface $affilationDate): self
    {
        $this->affilationDate = $affilationDate;

        return $this;
    }

    /**
     * @return Collection|CandidateDocuments[]
     */
    public function getCandidateDocuments(): Collection
    {
        return $this->candidateDocuments;
    }

    public function addCandidateDocument(CandidateDocuments $candidateDocument): self
    {
        if (!$this->candidateDocuments->contains($candidateDocument)) {
            $this->candidateDocuments[] = $candidateDocument;
            $candidateDocument->setCandidate($this);
        }

        return $this;
    }

    public function removeCandidateDocument(CandidateDocuments $candidateDocument): self
    {
        if ($this->candidateDocuments->removeElement($candidateDocument)) {
            // set the owning side to null (unless already changed)
            if ($candidateDocument->getCandidate() === $this) {
                $candidateDocument->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StatusContract[]
     */
    public function getStatusContracts(): Collection
    {
        return $this->statusContracts;
    }

    public function addStatusContract(StatusContract $statusContract): self
    {
        if (!$this->statusContracts->contains($statusContract)) {
            $this->statusContracts[] = $statusContract;
            $statusContract->setCandidate($this);
        }

        return $this;
    }

    public function removeStatusContract(StatusContract $statusContract): self
    {
        if ($this->statusContracts->removeElement($statusContract)) {
            // set the owning side to null (unless already changed)
            if ($statusContract->getCandidate() === $this) {
                $statusContract->setCandidate(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?Staff
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Staff $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedBy(): ?Staff
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?Staff $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }


}
