<?php

namespace App\Modules\NavigationMenu\Entity;


use App\Entity\Hook;
use App\Entity\Page;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Modules\NavigationMenu\Repository\NavigationMenuRepository;

#[ORM\Entity(repositoryClass: NavigationMenuRepository::class)]
class NavigationMenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]   
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @ORM\ManyToMany(targetEntity=Page::class, cascade={"remove"})
     * @ORM\JoinTable(name="page_menu_page",
     *      joinColumns={@ORM\JoinColumn(name="page_menu_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")}
     *      )
     */
    private $pages;

    #[ORM\OneToOne(targetEntity: Hook::class)]
    private ?Hook $hook = null;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        // Retourne la collection de pages si elle existe, sinon initialise une nouvelle collection
        return $this->pages ?? new ArrayCollection();
    }

    public function addPage(Page $page): self
    {
        // Vérifier si la collection pages est null
        if ($this->pages === null) {
            // Si elle est null, initialiser avec une nouvelle ArrayCollection
            $this->pages = new ArrayCollection();
        }
    
        // Vérifier si la page existe déjà dans la collection
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
        }
    
        return $this;
    }

    public function removePage(Page $page): self
    {
        // Vérifiez d'abord si $this->pages est nulle
        if ($this->pages instanceof ArrayCollection) {
            $this->pages->removeElement($page);
        }
        
        return $this;
    }

    public function getHook(): ?Hook
    {
        return $this->hook;
    }

    public function setHook(?Hook $hook): self
    {
        $this->hook = $hook;

        return $this;
    }

}
