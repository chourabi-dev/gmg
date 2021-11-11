<?php

namespace App\Entity;

use App\Repository\StaffRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StaffRepository::class)
 */
class Staff
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
    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DOB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pemail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Departments::class, inversedBy="staff")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity=StaffTypes::class, inversedBy="staff")
     */
    private $staffType;

    /**
     * @ORM\ManyToOne(targetEntity=FamilyStatusTypes::class, inversedBy="staff")
     */
    private $familyStatusType;

    /**
     * @ORM\ManyToOne(targetEntity=BankInformations::class, inversedBy="staff")
     */
    private $bankInformation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=AgencyToStaff::class, mappedBy="staff")
     */
    private $agency;

    /**
     * @ORM\OneToMany(targetEntity=LocationToStaff::class, mappedBy="staff")
     */
    private $locationToStaff;

    /**
     * @ORM\OneToMany(targetEntity=PrivateNotes::class, mappedBy="staff")
     */
    private $privateNotes;

    /**
     * @ORM\OneToMany(targetEntity=StaffContracts::class, mappedBy="staff")
     */
    private $staffContracts;

    /**
     * @ORM\OneToMany(targetEntity=EmergencyContacts::class, mappedBy="staff")
     */
    private $emergencyContacts;

    /**
     * @ORM\OneToMany(targetEntity=Status::class, mappedBy="staff")
     */
    private $statuses;

    /**
     * @ORM\OneToMany(targetEntity=StatusContract::class, mappedBy="staff")
     */
    private $statusContracts;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="staff", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Condidates::class, mappedBy="createdBy")
     */
    private $condidates;

    public function __construct()
    {
        $this->agency = new ArrayCollection();
        $this->locationToStaff = new ArrayCollection();
        $this->privateNotes = new ArrayCollection();
        $this->staffContracts = new ArrayCollection();
        $this->emergencyContacts = new ArrayCollection();
        $this->statuses = new ArrayCollection();
        $this->statusContracts = new ArrayCollection();
        $this->condidates = new ArrayCollection();
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDOB(): ?string
    {
        return $this->DOB;
    }

    public function setDOB(string $DOB): self
    {
        $this->DOB = $DOB;

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

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    public function setTel1(string $tel1): self
    {
        $this->tel1 = $tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(string $tel2): self
    {
        $this->tel2 = $tel2;

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

    public function getPemail(): ?string
    {
        return $this->pemail;
    }

    public function setPemail(string $pemail): self
    {
        $this->pemail = $pemail;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDepartment(): ?Departments
    {
        return $this->department;
    }

    public function setDepartment(?Departments $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getStaffType(): ?StaffTypes
    {
        return $this->staffType;
    }

    public function setStaffType(?StaffTypes $staffType): self
    {
        $this->staffType = $staffType;

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

    public function getBankInformation(): ?BankInformations
    {
        return $this->bankInformation;
    }

    public function setBankInformation(?BankInformations $bankInformation): self
    {
        $this->bankInformation = $bankInformation;

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

    /**
     * @return Collection|AgencyToStaff[]
     */
    public function getAgency(): Collection
    {
        return $this->agency;
    }

    public function addAgency(AgencyToStaff $agency): self
    {
        if (!$this->agency->contains($agency)) {
            $this->agency[] = $agency;
            $agency->setStaff($this);
        }

        return $this;
    }

    public function removeAgency(AgencyToStaff $agency): self
    {
        if ($this->agency->removeElement($agency)) {
            // set the owning side to null (unless already changed)
            if ($agency->getStaff() === $this) {
                $agency->setStaff(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LocationToStaff[]
     */
    public function getLocationToStaff(): Collection
    {
        return $this->locationToStaff;
    }

    public function addLocationToStaff(LocationToStaff $locationToStaff): self
    {
        if (!$this->locationToStaff->contains($locationToStaff)) {
            $this->locationToStaff[] = $locationToStaff;
            $locationToStaff->setStaff($this);
        }

        return $this;
    }

    public function removeLocationToStaff(LocationToStaff $locationToStaff): self
    {
        if ($this->locationToStaff->removeElement($locationToStaff)) {
            // set the owning side to null (unless already changed)
            if ($locationToStaff->getStaff() === $this) {
                $locationToStaff->setStaff(null);
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
            $privateNote->setStaff($this);
        }

        return $this;
    }

    public function removePrivateNote(PrivateNotes $privateNote): self
    {
        if ($this->privateNotes->removeElement($privateNote)) {
            // set the owning side to null (unless already changed)
            if ($privateNote->getStaff() === $this) {
                $privateNote->setStaff(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StaffContracts[]
     */
    public function getStaffContracts(): Collection
    {
        return $this->staffContracts;
    }

    public function addStaffContract(StaffContracts $staffContract): self
    {
        if (!$this->staffContracts->contains($staffContract)) {
            $this->staffContracts[] = $staffContract;
            $staffContract->setStaff($this);
        }

        return $this;
    }

    public function removeStaffContract(StaffContracts $staffContract): self
    {
        if ($this->staffContracts->removeElement($staffContract)) {
            // set the owning side to null (unless already changed)
            if ($staffContract->getStaff() === $this) {
                $staffContract->setStaff(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EmergencyContacts[]
     */
    public function getEmergencyContacts(): Collection
    {
        return $this->emergencyContacts;
    }

    public function addEmergencyContact(EmergencyContacts $emergencyContact): self
    {
        if (!$this->emergencyContacts->contains($emergencyContact)) {
            $this->emergencyContacts[] = $emergencyContact;
            $emergencyContact->setStaff($this);
        }

        return $this;
    }

    public function removeEmergencyContact(EmergencyContacts $emergencyContact): self
    {
        if ($this->emergencyContacts->removeElement($emergencyContact)) {
            // set the owning side to null (unless already changed)
            if ($emergencyContact->getStaff() === $this) {
                $emergencyContact->setStaff(null);
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
            $status->setStaff($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->statuses->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getStaff() === $this) {
                $status->setStaff(null);
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
            $statusContract->setStaff($this);
        }

        return $this;
    }

    public function removeStatusContract(StatusContract $statusContract): self
    {
        if ($this->statusContracts->removeElement($statusContract)) {
            // set the owning side to null (unless already changed)
            if ($statusContract->getStaff() === $this) {
                $statusContract->setStaff(null);
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

    /**
     * @return Collection|Condidates[]
     */
    public function getCondidates(): Collection
    {
        return $this->condidates;
    }

    public function addCondidate(Condidates $condidate): self
    {
        if (!$this->condidates->contains($condidate)) {
            $this->condidates[] = $condidate;
            $condidate->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCondidate(Condidates $condidate): self
    {
        if ($this->condidates->removeElement($condidate)) {
            // set the owning side to null (unless already changed)
            if ($condidate->getCreatedBy() === $this) {
                $condidate->setCreatedBy(null);
            }
        }

        return $this;
    }
}
