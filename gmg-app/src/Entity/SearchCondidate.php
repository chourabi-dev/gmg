<?php

namespace App\Entity;

class SearchCondidate
{
    private $id;
    private $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function getLabel(): ?int
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }



    public function __toString()
    {
        return $this->label;
    }
}
