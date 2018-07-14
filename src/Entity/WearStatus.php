<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WearStatusRepository")
 */
class WearStatus
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
    private $wearStatus_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wearStatus_code;

    public function getId()
    {
        return $this->id;
    }

    public function getWearStatusName(): ?string
    {
        return $this->wearStatus_name;
    }

    public function setWearStatusName(string $wearStatus_name): self
    {
        $this->wearStatus_name = $wearStatus_name;

        return $this;
    }

    public function getWearStatusCode(): ?string
    {
        return $this->wearStatus_code;
    }

    public function setWearStatusCode(?string $wearStatus_code): self
    {
        $this->wearStatus_code = $wearStatus_code;

        return $this;
    }
}
