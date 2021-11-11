<?php

namespace App\Entity;

use App\Repository\SubjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SubjectsRepository::class)
 * @UniqueEntity("subject")
 */
class Subjects
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
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity=PrivateNotes::class, mappedBy="subject")
     */
    private $privateNotes;

    public function __construct()
    {
        $this->privateNotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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
            $privateNote->setSubject($this);
        }

        return $this;
    }

    public function removePrivateNote(PrivateNotes $privateNote): self
    {
        if ($this->privateNotes->removeElement($privateNote)) {
            // set the owning side to null (unless already changed)
            if ($privateNote->getSubject() === $this) {
                $privateNote->setSubject(null);
            }
        }

        return $this;
    }
}
