<?php

namespace App\Entity;

use App\Repository\CandidateSkillsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidateSkillsRepository::class)
 */
class CandidateSkills
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="candidateSkills")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=SubSkills::class, inversedBy="candidateSkills")
     */
    private $skill;

    /**
     * @ORM\Column(type="integer")
     */
    private $displayOrder;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yearsExperience;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?Condidates
    {
        return $this->candidate;
    }

    public function setCandidate(?Condidates $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getSkill(): ?SubSkills
    {
        return $this->skill;
    }

    public function setSkill(?SubSkills $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): self
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    public function getYearsExperience(): ?int
    {
        return $this->yearsExperience;
    }

    public function setYearsExperience(?int $yearsExperience): self
    {
        $this->yearsExperience = $yearsExperience;

        return $this;
    }
}
