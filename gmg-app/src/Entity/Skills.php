<?php

namespace App\Entity;

use App\Repository\SkillsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SkillsRepository::class)
 * @UniqueEntity("skill")
 */
class Skills
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
    private $skill;

    /**
     * @ORM\OneToMany(targetEntity=SubSkills::class, mappedBy="skill")
     */
    private $subSkills;

    public function __construct()
    {
        $this->subSkills = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkill(): ?string
    {
        return $this->skill;
    }

    public function setSkill(string $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * @return Collection|SubSkills[]
     */
    public function getSubSkills(): Collection
    {
        return $this->subSkills;
    }






    public function __toString()
    {
        return $this->skill;
    }

    public function addSubSkill(SubSkills $subSkill): self
    {
        if (!$this->subSkills->contains($subSkill)) {
            $this->subSkills[] = $subSkill;
            $subSkill->setSkill($this);
        }

        return $this;
    }

    public function removeSubSkill(SubSkills $subSkill): self
    {
        if ($this->subSkills->removeElement($subSkill)) {
            // set the owning side to null (unless already changed)
            if ($subSkill->getSkill() === $this) {
                $subSkill->setSkill(null);
            }
        }

        return $this;
    }
}
