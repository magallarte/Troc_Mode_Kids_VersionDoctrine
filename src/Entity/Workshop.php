<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkshopRepository")
 */
class Workshop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $workshop_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $workshop_theme;

    /**
     * @ORM\Column(type="float")
     */
    private $workshop_fee;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $workshop_place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $workshop_picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="member_worshopAsTrainer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workshop_trainer;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Member", inversedBy="member_worshopAsTrainee")
     */
    private $workshop_trainees_list;

    public function __construct()
    {
        $this->workshop_trainees_list = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWorkshopDate(): ?\DateTimeInterface
    {
        return $this->workshop_date;
    }

    public function setWorkshopDate(\DateTimeInterface $workshop_date): self
    {
        $this->workshop_date = $workshop_date;

        return $this;
    }

    public function getWorkshopTheme(): ?string
    {
        return $this->workshop_theme;
    }

    public function setWorkshopTheme(string $workshop_theme): self
    {
        $this->workshop_theme = $workshop_theme;

        return $this;
    }

    public function getWorkshopFee(): ?float
    {
        return $this->workshop_fee;
    }

    public function setWorkshopFee(float $workshop_fee): self
    {
        $this->workshop_fee = $workshop_fee;

        return $this;
    }

    public function getWorkshopPlace(): ?string
    {
        return $this->workshop_place;
    }

    public function setWorkshopPlace(?string $workshop_place): self
    {
        $this->workshop_place = $workshop_place;

        return $this;
    }

    public function getWorkshopPicture(): ?string
    {
        return $this->workshop_picture;
    }

    public function setWorkshopPicture(?string $workshop_picture): self
    {
        $this->workshop_picture = $workshop_picture;

        return $this;
    }

    public function getWorkshopTrainer(): ?Member
    {
        return $this->workshop_trainer;
    }

    public function setWorkshopTrainer(?Member $workshop_trainer): self
    {
        $this->workshop_trainer = $workshop_trainer;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getWorkshopTraineesList(): Collection
    {
        return $this->workshop_trainees_list;
    }

    public function addWorkshopTraineesList(Member $workshopTraineesList): self
    {
        if (!$this->workshop_trainees_list->contains($workshopTraineesList)) {
            $this->workshop_trainees_list[] = $workshopTraineesList;
        }

        return $this;
    }

    public function removeWorkshopTraineesList(Member $workshopTraineesList): self
    {
        if ($this->workshop_trainees_list->contains($workshopTraineesList)) {
            $this->workshop_trainees_list->removeElement($workshopTraineesList);
        }

        return $this;
    }
}
