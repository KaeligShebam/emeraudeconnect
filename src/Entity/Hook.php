<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\HookRepository;
use App\Modules\NavigationMenu\Entity\NavigationMenu;

#[ORM\Entity(repositoryClass: HookRepository::class)]
class Hook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'hook')]
    private ?NavigationMenu $navigationMenu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

        public function getNavigationMenu(): ?NavigationMenu
        {
            return $this->navigationMenu;
        }
    
        public function setNavigationMenu(?NavigationMenu $navigationMenu): self
        {
            $this->navigationMenu = $navigationMenu;
    
            return $this;
        }
}
