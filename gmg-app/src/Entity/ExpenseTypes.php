<?php

namespace App\Entity;

use App\Repository\ExpenseTypesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ExpenseTypesRepository::class)
 * @UniqueEntity("expenseType")
 */
class ExpenseTypes
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
    private $expenseType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpenseType(): ?string
    {
        return $this->expenseType;
    }

    public function setExpenseType(string $expenseType): self
    {
        $this->expenseType = $expenseType;

        return $this;
    }
}
