<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessStatusRepository")
 */
class ProcessStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $processStatus_name;

    public function getId()
    {
        return $this->id;
    }

    public function getProcessStatusName(): ?string
    {
        return $this->processStatus_name;
    }

    public function setProcessStatusName(string $processStatus_name): self
    {
        $this->processStatus_name = $processStatus_name;

        return $this;
    }
}
