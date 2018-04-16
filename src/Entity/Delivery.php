<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
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
    private $delivery_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SchoolStop")
     */
    private $delivery_schoolStop;

    public function getId()
    {
        return $this->id;
    }

    public function getDeliveryType(): ?string
    {
        return $this->delivery_type;
    }

    public function setDeliveryType(string $delivery_type): self
    {
        $this->delivery_type = $delivery_type;

        return $this;
    }

    public function getDeliverySchoolStop(): ?SchoolStop
    {
        return $this->delivery_schoolStop;
    }

    public function setDeliverySchoolStop(?SchoolStop $delivery_schoolStop): self
    {
        $this->delivery_schoolStop = $delivery_schoolStop;

        return $this;
    }
}
