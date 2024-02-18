<?php
// src/Service/NavigationMenuService.php
namespace App\Service;

use App\Entity\PageMenu;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PageMenuService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function setPageMenu(PageMenu $pageMenu): void
    {
        // Stocker le PageMenu sélectionné dans la session de l'utilisateur
        $this->session->set('selected_page_menu', $pageMenu);
    }

    public function getPageMenu(): ?PageMenu
    {
        // Récupérer le PageMenu depuis la session de l'utilisateur
        return $this->session->get('selected_page_menu');
    }
}
