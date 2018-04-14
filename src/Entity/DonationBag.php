<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonationBagRepository")
 */
class DonationBag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $donationBag_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="member_donationBag_list")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donationBag_donator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donationBag_processStatus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="article_donationBag")
     */
    private $donationBag_article_list;

    public function __construct()
    {
        $this->donationBag_article_list = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDonationBagDate(): ?\DateTimeInterface
    {
        return $this->donationBag_date;
    }

    public function setDonationBagDate(\DateTimeInterface $donationBag_date): self
    {
        $this->donationBag_date = $donationBag_date;

        return $this;
    }

    public function getDonationBagDonator(): ?Member
    {
        return $this->donationBag_donator;
    }

    public function setDonationBagDonator(?Member $donationBag_donator): self
    {
        $this->donationBag_donator = $donationBag_donator;

        return $this;
    }

    public function getDonationBagProcessStatus(): ?ProcessSatus
    {
        return $this->donationBag_processStatus;
    }

    public function setDonationBagProcessStatus(?ProcessSatus $donationBag_processStatus): self
    {
        $this->donationBag_processStatus = $donationBag_processStatus;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getDonationBagArticleList(): Collection
    {
        return $this->donationBag_article_list;
    }

    public function addDonationBagArticleList(Article $donationBagArticleList): self
    {
        if (!$this->donationBag_article_list->contains($donationBagArticleList)) {
            $this->donationBag_article_list[] = $donationBagArticleList;
            $donationBagArticleList->setArticleDonationBag($this);
        }

        return $this;
    }

    public function removeDonationBagArticleList(Article $donationBagArticleList): self
    {
        if ($this->donationBag_article_list->contains($donationBagArticleList)) {
            $this->donationBag_article_list->removeElement($donationBagArticleList);
            // set the owning side to null (unless already changed)
            if ($donationBagArticleList->getArticleDonationBag() === $this) {
                $donationBagArticleList->setArticleDonationBag(null);
            }
        }

        return $this;
    }
}
