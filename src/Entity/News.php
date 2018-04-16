<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
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
    private $news_title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $news_source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $news_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $news_picture;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $news_content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member")
     */
    private $news_editor;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $news_editDate;

    public function getId()
    {
        return $this->id;
    }

    public function getNewsTitle(): ?string
    {
        return $this->news_title;
    }

    public function setNewsTitle(string $news_title): self
    {
        $this->news_title = $news_title;

        return $this;
    }

    public function getNewsSource(): ?string
    {
        return $this->news_source;
    }

    public function setNewsSource(?string $news_source): self
    {
        $this->news_source = $news_source;

        return $this;
    }

    public function getNewsUrl(): ?string
    {
        return $this->news_url;
    }

    public function setNewsUrl(?string $news_url): self
    {
        $this->news_url = $news_url;

        return $this;
    }

    public function getNewsPicture(): ?string
    {
        return $this->news_picture;
    }

    public function setNewsPicture(?string $news_picture): self
    {
        $this->news_picture = $news_picture;

        return $this;
    }

    public function getNewsContent(): ?string
    {
        return $this->news_content;
    }

    public function setNewsContent(?string $news_content): self
    {
        $this->news_content = $news_content;

        return $this;
    }

    public function getNewsEditor(): ?Member
    {
        return $this->news_editor;
    }

    public function setNewsEditor(?Member $news_editor): self
    {
        $this->news_editor = $news_editor;

        return $this;
    }

    public function getNewsEditDate(): ?\DateTimeInterface
    {
        return $this->news_editDate;
    }

    public function setNewsEditDate(?\DateTimeInterface $news_editDate): self
    {
        $this->news_editDate = $news_editDate;

        return $this;
    }
}
