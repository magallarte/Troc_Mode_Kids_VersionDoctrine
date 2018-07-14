<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
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
    private $article_picture1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $article_picture2;

    // Picture 3 not used yet
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    // private $article_picture3;

    /**
     * @ORM\Column(type="float")
     */
    private $article_buttonValue;

    /**
     * @ORM\Column(type="float")
     */
    private $article_eurosValue;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $article_comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Color")
     */
    private $article_color;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Size")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_size;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WearStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_wearStatus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gender")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_gender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_processStatus;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fabric", cascade={"persist"})
     */
    private $article_fabric;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DeliveryBag", inversedBy="deliveryBag_article_list")
     */
    private $article_deliveryBag;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DonationBag", inversedBy="donationBag_article_list")
     */
    private $article_donationBag;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Season")
     */
    private $article_season;

    /**
     * @ORM\Column(type="string", length=13)
     */
    private $article_code;


    public function __construct()
    {
        $this->article_color = new ArrayCollection();
        $this->article_fabric = new ArrayCollection();
        $this->article_season = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getArticlePicture1()
    {
        return $this->article_picture1;
    }

    public function setArticlePicture1( $article_picture1)  
    {
        $this->article_picture1 = $article_picture1;

        return $this;
    }

    public function getArticlePicture2()
    {
        return $this->article_picture2;
    }

    public function setArticlePicture2($article_picture2)
    {
        $this->article_picture2 = $article_picture2;

        return $this;
    }

    // Picture 3 not used yet
    // public function getArticlePicture3()
    // {
    //     return $this->article_picture3;
    // }

    // public function setArticlePicture3($article_picture3)
    // {
    //     $this->article_picture3 = $article_picture3;

    //     return $this;
    // }

    public function getArticleButtonValue(): ?float
    {
        return $this->article_buttonValue;
    }

    public function setArticleButtonValue(float $article_buttonValue): self
    {
        $this->article_buttonValue = $article_buttonValue;

        return $this;
    }

    public function getArticleEurosValue(): ?float
    {
        return $this->article_eurosValue;
    }

    public function setArticleEurosValue(float $article_eurosValue): self
    {
        $this->article_eurosValue = $article_eurosValue;

        return $this;
    }

    public function getArticleComments(): ?string
    {
        return $this->article_comments;
    }

    public function setArticleComments(?string $article_comments): self
    {
        $this->article_comments = $article_comments;

        return $this;
    }

    /**
     * @return Collection|Color[]
     */
    public function getArticleColor(): Collection
    {
        return $this->article_color;
    }

    public function addArticleColor(Color $articleColor): self
    {
        if (!$this->article_color->contains($articleColor)) {
            $this->article_color[] = $articleColor;
        }

        return $this;
    }

    public function removeArticleColor(Color $articleColor): self
    {
        if ($this->article_color->contains($articleColor)) {
            $this->article_color->removeElement($articleColor);
        }

        return $this;
    }

    public function getArticleBrand(): ?Brand
    {
        return $this->article_brand;
    }

    public function setArticleBrand(?Brand $article_brand): self
    {
        $this->article_brand = $article_brand;

        return $this;
    }

    public function getArticleType(): ?Type
    {
        return $this->article_type;
    }

    public function setArticleType(?Type $article_type): self
    {
        $this->article_type = $article_type;

        return $this;
    }

    public function getArticleSize(): ?Size
    {
        return $this->article_size;
    }

    public function setArticleSize(?Size $article_size): self
    {
        $this->article_size = $article_size;

        return $this;
    }

    public function getArticleWearStatus(): ?WearStatus
    {
        return $this->article_wearStatus;
    }

    public function setArticleWearStatus(?WearStatus $article_wearStatus): self
    {
        $this->article_wearStatus = $article_wearStatus;

        return $this;
    }

    public function getArticleGender(): ?Gender
    {
        return $this->article_gender;
    }

    public function setArticleGender(?Gender $article_gender): self
    {
        $this->article_gender = $article_gender;

        return $this;
    }

    public function getArticleProcessStatus(): ?ProcessStatus
    {
        return $this->article_processStatus;
    }

    public function setArticleProcessStatus(?ProcessStatus $article_processStatus): self
    {
        $this->article_processStatus = $article_processStatus;

        return $this;
    }

    /**
     * @return Collection|Fabric[]
     */
    public function getArticleFabric(): Collection
    {
        return $this->article_fabric;
    }

    public function addArticleFabric(Fabric $articleFabric): self
    {
        if (!$this->article_fabric->contains($articleFabric)) {
            $this->article_fabric[] = $articleFabric;
        }

        return $this;
    }

    public function removeArticleFabric(Fabric $articleFabric): self
    {
        if ($this->article_fabric->contains($articleFabric)) {
            $this->article_fabric->removeElement($articleFabric);
        }

        return $this;
    }

    public function getArticleDeliveryBag(): ?DeliveryBag
    {
        return $this->article_DeliveryBag;
    }

    public function setArticleDeliveryBag(?DeliveryBag $article_DeliveryBag): self
    {
        $this->article_DeliveryBag = $article_DeliveryBag;

        return $this;
    }

    public function getArticleDonationBag(): ?DonationBag
    {
        return $this->article_donationBag;
    }

    public function setArticleDonationBag(?DonationBag $article_donationBag): self
    {
        $this->article_donationBag = $article_donationBag;

        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getArticleSeason(): Collection
    {
        return $this->article_season;
    }

    public function addArticleSeason(Season $articleSeason): self
    {
        if (!$this->article_season->contains($articleSeason)) {
            $this->article_season[] = $articleSeason;
        }

        return $this;
    }

    public function removeArticleSeason(Season $articleSeason): self
    {
        if ($this->article_season->contains($articleSeason)) {
            $this->article_season->removeElement($articleSeason);
        }

        return $this;
    }

    public function getArticleCode(): ?string
    {
        return $this->article_code;
    }

    public function setArticleCode(?string $last_article_code): ?string
    {
        // We get a NUM code from the 4 last characters of the last similar article
        $numCode = substr( $last_article_code, -4 );

        // We increment this NUM code  
        if( ctype_digit($numCode) ) {
            $numCode = (int)$numCode;
            $numCode++;
            $numCode=str_pad($numCode,4,"0",STR_PAD_LEFT);
        }
       // We create a GENDER code
        $genderCode = $this->getArticleGender()->getGenderCode();
        
        // We create a SIZE code
        $sizeCode = $this->getArticleSize()->getSizeCode();

        // We create a SEASON code ( with 1 or 2 optionnal characters)
        $seasonCode='';
            foreach($this->getArticleSeason() as $articleSeason)
            {
                $seasonCode = $seasonCode.$articleSeason->getSeasonCode();
            }
        if(strlen($seasonCode)<1)
            {
                $seasonCode= ( str_pad($seasonCode ,2, "0", STR_PAD_LEFT) );
            }
        // We create a TYPE code
        $typeCode = $this->getArticleType()->getTypeCode();

        // We concatenate the differents codes
        $this->article_code = $genderCode.$sizeCode.$seasonCode.$typeCode.$numCode;
        
        return $this->article_code;
    }

}
