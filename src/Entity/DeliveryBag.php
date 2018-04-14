<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryBagRepository")
 */
class DeliveryBag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $deliveryBag_serviceFee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="member_deliveryBag_list")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliveryBag_buyer;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $deliveryBag_buttonAmount;

    /**
     * @ORM\Column(type="date")
     */
    private $deliveryBag_buyDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliveryBag_processStatus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="article_deliveyBag")
     */
    private $deliveryBag_article_list;

    public function __construct()
    {
        $this->deliveryBag_article_list = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDeliveryBagServiceFee(): ?float
    {
        return $this->deliveryBag_serviceFee;
    }

    public function setDeliveryBagServiceFee(float $deliveryBag_serviceFee): self
    {
        $this->deliveryBag_serviceFee = $deliveryBag_serviceFee;

        return $this;
    }

    public function getDeliveryBagBuyer(): ?Member
    {
        return $this->deliveryBag_buyer;
    }

    public function setDeliveryBagBuyer(?Member $deliveryBag_buyer): self
    {
        $this->deliveryBag_buyer = $deliveryBag_buyer;

        return $this;
    }

    public function getDeliveryBagButtonAmount(): ?float
    {
        return $this->deliveryBag_buttonAmount;
    }

    public function setDeliveryBagButtonAmount(?float $deliveryBag_buttonAmount): self
    {
        $this->deliveryBag_buttonAmount = $deliveryBag_buttonAmount;

        return $this;
    }

    public function getDeliveryBagBuyDate(): ?\DateTimeInterface
    {
        return $this->deliveryBag_buyDate;
    }

    public function setDeliveryBagBuyDate(\DateTimeInterface $deliveryBag_buyDate): self
    {
        $this->deliveryBag_buyDate = $deliveryBag_buyDate;

        return $this;
    }

    public function getDeliveryBagProcessStatus(): ?ProcessSatus
    {
        return $this->deliveryBag_processStatus;
    }

    public function setDeliveryBagProcessStatus(?ProcessSatus $deliveryBag_processStatus): self
    {
        $this->deliveryBag_processStatus = $deliveryBag_processStatus;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getDeliveryBagArticleList(): Collection
    {
        return $this->deliveryBag_article_list;
    }

    public function addDeliveryBagArticleList(Article $deliveryBagArticleList): self
    {
        if (!$this->deliveryBag_article_list->contains($deliveryBagArticleList)) {
            $this->deliveryBag_article_list[] = $deliveryBagArticleList;
            $deliveryBagArticleList->setArticleDeliveyBag($this);
        }

        return $this;
    }

    public function removeDeliveryBagArticleList(Article $deliveryBagArticleList): self
    {
        if ($this->deliveryBag_article_list->contains($deliveryBagArticleList)) {
            $this->deliveryBag_article_list->removeElement($deliveryBagArticleList);
            // set the owning side to null (unless already changed)
            if ($deliveryBagArticleList->getArticleDeliveyBag() === $this) {
                $deliveryBagArticleList->setArticleDeliveyBag(null);
            }
        }

        return $this;
    }
}
