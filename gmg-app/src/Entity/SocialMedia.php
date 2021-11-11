<?php

namespace App\Entity;

use App\Repository\SocialMediaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocialMediaRepository::class)
 */
class SocialMedia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Condidates::class, inversedBy="socialMedia")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity=SocialMediaTypes::class, inversedBy="socialMedia")
     */
    private $socialMediaType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $socialMedia;

    /**
     * @ORM\ManyToOne(targetEntity=Companies::class, inversedBy="socialMedia")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Contacts::class, inversedBy="socialMedia")
     */
    private $contact;

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

    public function getSocialMediaType(): ?SocialMediaTypes
    {
        return $this->socialMediaType;
    }

    public function setSocialMediaType(?SocialMediaTypes $socialMediaType): self
    {
        $this->socialMediaType = $socialMediaType;

        return $this;
    }

    public function getSocialMedia(): ?string
    {
        return $this->socialMedia;
    }

    public function setSocialMedia(string $socialMedia): self
    {
        $this->socialMedia = $socialMedia;

        return $this;
    }

    public function getCompany(): ?Companies
    {
        return $this->company;
    }

    public function setCompany(?Companies $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getContact(): ?Contacts
    {
        return $this->contact;
    }

    public function setContact(?Contacts $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
