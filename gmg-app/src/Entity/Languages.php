<?php

namespace App\Entity;

use App\Repository\LanguagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=LanguagesRepository::class)
 * @UniqueEntity("language")
 */
class Languages
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
    private $language;

    /**
     * @ORM\OneToMany(targetEntity=CandidatesLanguages::class, mappedBy="language")
     */
    private $candidatesLanguages;

    public function __construct()
    {
        $this->candidatesLanguages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

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
            $candidatesLanguage->setLanguage($this);
        }

        return $this;
    }

    public function removeCandidatesLanguage(CandidatesLanguages $candidatesLanguage): self
    {
        if ($this->candidatesLanguages->removeElement($candidatesLanguage)) {
            // set the owning side to null (unless already changed)
            if ($candidatesLanguage->getLanguage() === $this) {
                $candidatesLanguage->setLanguage(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->language;
    }
}
