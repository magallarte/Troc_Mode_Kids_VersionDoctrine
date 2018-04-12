<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FabricRepository")
 */
class Fabric
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
    private $fabric_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fabric_code;

    public function getId()
    {
        return $this->id;
    }

    public function getFabricName(): ?string
    {
        return $this->fabric_name;
    }

    public function setFabricName(string $fabric_name): self
    {
        $this->fabric_name = $fabric_name;

        return $this;
    }

    public function getFabricCode(): ?string
    {
        return $this->fabric_code;
    }

    public function setFabricCode(string $fabric_code): self
    {
        $this->fabric_code = $fabric_code;

        return $this;
    }
}
