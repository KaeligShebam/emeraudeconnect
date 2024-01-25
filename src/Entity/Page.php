<?php

namespace App\Entity;

use DateTime;
use App\Entity\PageSeo;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: PageStatus::class, inversedBy: 'pages')]
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', nullable: false)]
    private ?PageStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'pages', cascade: ['persist', 'remove'])]
    private ?PageSeo $seo = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isDeleted = null;
    
    #[ORM\ManyToMany(targetEntity: PageMenu::class, mappedBy: 'pages')]
    private Collection $pageMenus;
    

    public function __construct()
    {
        $this->pageMenus = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $title, SluggerInterface $slugger): self
    {
        $this->slug = $slugger->slug($title)->lower()->toString();

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function getStatus(): ?PageStatus
    {
        return $this->status;
    }

    public function setStatus(?PageStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSeo(): ?PageSeo
    {
        return $this->seo;
    }

    public function setSeo(?PageSeo $seo): static
    {
        $this->seo = $seo;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection<int, PageMenu>
     */
    public function getPageMenus(): Collection
    {
        return $this->pageMenus;
    }

    public function addPageMenu(PageMenu $pageMenu): static
    {
        if (!$this->pageMenus->contains($pageMenu)) {
            $this->pageMenus->add($pageMenu);
            $pageMenu->addPage($this);
        }

        return $this;
    }

    public function removePageMenu(PageMenu $pageMenu): static
    {
        if ($this->pageMenus->removeElement($pageMenu)) {
            $pageMenu->removePage($this);
        }

        return $this;
    }

}
