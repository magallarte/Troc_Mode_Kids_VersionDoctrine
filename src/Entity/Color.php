<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 */
class Color
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
    private $color_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color_code;

    public function getId()
    {
        return $this->id;
    }

    public function getColorName(): ?string
    {
        return $this->color_name;
    }

    public function setColorName(string $color_name): self
    {
        $this->color_name = $color_name;

        return $this;
    }

    public function getColorCode(): ?string
    {
        return $this->color_code;
    }

    public function setColorCode(string $color_code): self
    {
        $this->color_code = $color_code;

        return $this;
    }
}
