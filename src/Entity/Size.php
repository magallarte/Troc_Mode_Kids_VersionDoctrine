<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SizeRepository")
 */
class Size
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
    private $size_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $size_code;

    public function getId()
    {
        return $this->id;
    }

    public function getSizeName(): ?string
    {
        return $this->size_name;
    }

    public function setSizeName(string $size_name): self
    {
        $this->size_name = $size_name;

        return $this;
    }

    public function getSizeCode(): ?string
    {
        return $this->size_code;
    }

    public function setSizeCode(string $size_code): self
    {
        $this->size_code = $size_code;

        return $this;
    }
}
