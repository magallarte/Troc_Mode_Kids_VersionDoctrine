<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KidRepository")
 */
class Kid
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\NotBlank()
    */
    private $kid_name;

    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\NotBlank()
    */
    private $kid_surname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    private $kid_birthday;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\School", inversedBy="school_kid_list")
     */
    private $kid_school_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Member", mappedBy="member_kid_list")
     * @Assert\NotBlank()
     */
    private $kid_parent_list;

    public function __construct()
    {
        $this->kid_parent_list = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getKidName(): ?string
    {
        return $this->kid_name;
    }

    public function setKidName(string $kid_name): self
    {
        $this->kid_name = $kid_name;

        return $this;
    }

    public function getKidSurname(): ?string
    {
        return $this->kid_surname;
    }

    public function setKidSurname(string $kid_surname): self
    {
        $this->kid_surname = $kid_surname;

        return $this;
    }

    public function getKidBirthday(): ?\DateTimeInterface
    {
        return $this->kid_birthday;
    }

    public function setKidBirthday(?\DateTimeInterface $kid_birthday): self
    {
        $this->kid_birthday = $kid_birthday;

        return $this;
    }

    public function getKidSchoolId(): ?School
    {
        return $this->kid_school_id;
    }

    public function setKidSchoolId(?School $kid_school_id): self
    {
        $this->kid_school_id = $kid_school_id;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getKidParentList(): Collection
    {
        return $this->kid_parent_list;
    }

    public function addKidParentList(Member $kidParentList): self
    {
        if (!$this->kid_parent_list->contains($kidParentList)) {
            $this->kid_parent_list[] = $kidParentList;
            $kidParentList->addMemberKidList($this);
        }

        return $this;
    }

    public function setKidParentList(Member $kidParentList): self
    {
        return $this->addKidParentList($kidParentList);
    }

    public function removeKidParentList(Member $kidParentList): self
    {
        if ($this->kid_parent_list->contains($kidParentList)) {
            $this->kid_parent_list->removeElement($kidParentList);
            $kidParentList->removeMemberKidList($this);
        }

        return $this;
    }

}
