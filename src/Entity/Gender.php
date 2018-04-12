<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenderRepository")
 */
class Gender
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender_code;

    public function getId()
    {
        return $this->id;
    }

    public function getGenderName(): ?string
    {
        return $this->gender_name;
    }

    public function setGenderName(string $gender_name): self
    {
        $this->gender_name = $gender_name;

        return $this;
    }

    public function getGenderCode(): ?string
    {
        return $this->gender_code;
    }

    public function setGenderCode(string $gender_code): self
    {
        $this->gender_code = $gender_code;

        return $this;
    }
}
