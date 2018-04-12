<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 */
class Season
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
    private $season_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $season_code;

    public function getId()
    {
        return $this->id;
    }

    public function getSeasonName(): ?string
    {
        return $this->season_name;
    }

    public function setSeasonName(string $season_name): self
    {
        $this->season_name = $season_name;

        return $this;
    }

    public function getSeasonCode(): ?string
    {
        return $this->season_code;
    }

    public function setSeasonCode(string $season_code): self
    {
        $this->season_code = $season_code;

        return $this;
    }
}
