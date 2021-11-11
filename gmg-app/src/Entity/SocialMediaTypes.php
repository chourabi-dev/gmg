<?php

namespace App\Entity;

use App\Repository\SocialMediaTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SocialMediaTypesRepository::class)
 * @UniqueEntity("socialMediaType")
 */
class SocialMediaTypes
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
    private $socialMediaType;

    /**
     * @ORM\OneToMany(targetEntity=SocialMedia::class, mappedBy="socialMediaType")
     */
    private $socialMedia;

    public function __construct()
    {
        $this->socialMedia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialMediaType(): ?string
    {
        return $this->socialMediaType;
    }

    public function setSocialMediaType(string $socialMediaType): self
    {
        $this->socialMediaType = $socialMediaType;

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
            $socialMedium->setSocialMediaType($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): self
    {
        if ($this->socialMedia->removeElement($socialMedium)) {
            // set the owning side to null (unless already changed)
            if ($socialMedium->getSocialMediaType() === $this) {
                $socialMedium->setSocialMediaType(null);
            }
        }

        return $this;
    }
}
