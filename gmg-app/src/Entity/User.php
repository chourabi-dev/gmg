<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=Staff::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $staff;

    /**
     * @ORM\OneToOne(targetEntity=Condidates::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $condidates;


    

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        // unset the owning side of the relation if necessary
        if ($staff === null && $this->staff !== null) {
            $this->staff->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($staff !== null && $staff->getUser() !== $this) {
            $staff->setUser($this);
        }

        $this->staff = $staff;

        return $this;
    }

    public function getCondidates(): ?Condidates
    {
        return $this->condidates;
    }

    public function setCondidates(?Condidates $condidates): self
    {
        // unset the owning side of the relation if necessary
        if ($condidates === null && $this->condidates !== null) {
            $this->condidates->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($condidates !== null && $condidates->getUser() !== $this) {
            $condidates->setUser($this);
        }

        $this->condidates = $condidates;

        return $this;
    }
}
