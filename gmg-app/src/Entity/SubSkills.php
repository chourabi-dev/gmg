<?php

namespace App\Entity;

use App\Repository\SubSkillsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SubSkillsRepository::class)

 */
class SubSkills
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
    private $subSkill;

    /**
     * @ORM\ManyToOne(targetEntity=Skills::class, inversedBy="subSkills")
     */
    private $skill;

    /**
     * @ORM\OneToMany(targetEntity=CandidateSkills::class, mappedBy="skill")
     */
    private $candidateSkills;

    public function __construct()
    {
        $this->candidateSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubSkill(): ?string
    {
        return $this->subSkill;
    }

    public function setSubSkill(string $subSkill): self
    {
        $this->subSkill = $subSkill;

        return $this;
    }

    public function getSkill(): ?Skills
    {
        return $this->skill;
    }

    public function setSkill(?Skills $skill): self
    {
        $this->skill = $skill;

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
            $candidateSkill->setSkill($this);
        }

        return $this;
    }

    public function removeCandidateSkill(CandidateSkills $candidateSkill): self
    {
        if ($this->candidateSkills->removeElement($candidateSkill)) {
            // set the owning side to null (unless already changed)
            if ($candidateSkill->getSkill() === $this) {
                $candidateSkill->setSkill(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->subSkill;
    }
}
