<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand
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
    private $brand_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brand_code;

    public function getId()
    {
        return $this->id;
    }

    public function getBrandName(): ?string
    {
        return $this->brand_name;
    }

    public function setBrandName(string $brand_name): self
    {
        $this->brand_name = $brand_name;

        return $this;
    }

    public function getBrandCode(): ?string
    {
        return $this->brand_code;
    }

    public function setBrandCode(?string $brand_code): self
    {
        $this->brand_code = $brand_code;

        return $this;
    }
}
