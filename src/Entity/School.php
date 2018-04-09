<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchoolRepository")
 */
class School
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
    private $school_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $school_address1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $school_address2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $school_zip_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $school_city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $school_director_gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $school_director_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $school_director_tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $school_director_email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Kid", mappedBy="kid_school_id")
     */
    private $school_kid_list;

    public function __construct()
    {
        $this->school_kid_list = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSchoolName(): ?string
    {
        return $this->school_name;
    }

    public function setSchoolName(string $school_name): self
    {
        $this->school_name = $school_name;

        return $this;
    }

    public function getSchoolAddress1(): ?string
    {
        return $this->school_address1;
    }

    public function setSchoolAddress1(?string $school_address1): self
    {
        $this->school_address1 = $school_address1;

        return $this;
    }

    public function getSchoolAddress2(): ?string
    {
        return $this->school_address2;
    }

    public function setSchoolAddress2(?string $school_address2): self
    {
        $this->school_address2 = $school_address2;

        return $this;
    }

    public function getSchoolZipCode(): ?string
    {
        return $this->school_zip_code;
    }

    public function setSchoolZipCode(?string $school_zip_code): self
    {
        $this->school_zip_code = $school_zip_code;

        return $this;
    }

    public function getSchoolCity(): ?string
    {
        return $this->school_city;
    }

    public function setSchoolCity(string $school_city): self
    {
        $this->school_city = $school_city;

        return $this;
    }

    public function getSchoolDirectorGender(): ?string
    {
        return $this->school_director_gender;
    }

    public function setSchoolDirectorGender(string $school_director_gender): self
    {
        $this->school_director_gender = $school_director_gender;

        return $this;
    }

    public function getSchoolDirectorName(): ?string
    {
        return $this->school_director_name;
    }

    public function setSchoolDirectorName(string $school_director_name): self
    {
        $this->school_director_name = $school_director_name;

        return $this;
    }

    public function getSchoolDirectorTel(): ?string
    {
        return $this->school_director_tel;
    }

    public function setSchoolDirectorTel(?string $school_director_tel): self
    {
        $this->school_director_tel = $school_director_tel;

        return $this;
    }

    public function getSchoolDirectorEmail(): ?string
    {
        return $this->school_director_email;
    }

    public function setSchoolDirectorEmail(?string $school_director_email): self
    {
        $this->school_director_email = $school_director_email;

        return $this;
    }

    /**
     * @return Collection|Kid[]
     */
    public function getSchoolKidList(): Collection
    {
        return $this->school_kid_list;
    }

    public function addSchoolKidList(Kid $schoolKidList): self
    {
        if (!$this->school_kid_list->contains($schoolKidList)) {
            $this->school_kid_list[] = $schoolKidList;
            $schoolKidList->setKidSchoolId($this);
        }

        return $this;
    }

    public function removeSchoolKidList(Kid $schoolKidList): self
    {
        if ($this->school_kid_list->contains($schoolKidList)) {
            $this->school_kid_list->removeElement($schoolKidList);
            // set the owning side to null (unless already changed)
            if ($schoolKidList->getKidSchoolId() === $this) {
                $schoolKidList->setKidSchoolId(null);
            }
        }

        return $this;
    }
}
