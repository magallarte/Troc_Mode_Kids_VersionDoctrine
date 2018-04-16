<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchoolStopRepository")
 */
class SchoolStop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\School")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolStop_school;

    /**
     * @ORM\Column(type="datetime")
     */
    private $schoolStop_date;

    public function getId()
    {
        return $this->id;
    }

    public function getSchoolStopSchool(): ?School
    {
        return $this->schoolStop_school;
    }

    public function setSchoolStopSchool(?School $schoolStop_school): self
    {
        $this->schoolStop_school = $schoolStop_school;

        return $this;
    }

    public function getSchoolStopDate(): ?\DateTimeInterface
    {
        return $this->schoolStop_date;
    }

    public function setSchoolStopDate(\DateTimeInterface $schoolStop_date): self
    {
        $this->schoolStop_date = $schoolStop_date;

        return $this;
    }
}
