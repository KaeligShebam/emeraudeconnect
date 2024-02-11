<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PageMenuPageRepository;

#[ORM\Entity(repositoryClass: PageMenuPageRepository::class)]
class PageMenuPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: PageMenu::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?PageMenu $pageMenu = null;
    
    #[ORM\ManyToOne(targetEntity: Page::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $page = null;

    #[ORM\Column(type: 'integer')]
    private ?int $position = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageMenu(): ?PageMenu
    {
        return $this->pageMenu;
    }

    public function setPageMenu(?PageMenu $pageMenu): self
    {
        $this->pageMenu = $pageMenu;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }
    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position = 0): self
    {
        $this->position = $position;

        return $this;
    }
    public function removePage(Page $page): self
    {
        if ($this->getPage() === $page) {
            $this->setPage(null);
        }
    
        return $this;
    }
}
