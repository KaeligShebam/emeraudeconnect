<?php

namespace App\Modules\NavigationMenu\Controller;

use App\Modules\NavigationMenu\Entity\PageMenu;
use App\Repository\PageRepository;
use App\Service\TranslationService;
use App\Modules\NavigationMenu\Repository\PageMenuRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{

    private $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    #[Route('/admin/modules/menu-de-navigation/{id}', name: 'app_menu_add_pages')]
    public function addPagesToMenu(int $id, Request $request, PageRepository $pageRepository, ManagerRegistry $doctrine, PageMenuRepository $pageMenuRepository)
    {
        $entityManager = $doctrine->getManager();
        
        // Récupérer le menu
        $menu = $pageMenuRepository->find($id);

        // Vérifier si le menu existe
        if (!$menu instanceof PageMenu) {
            throw $this->createNotFoundException('Menu not found');
        }
        
        // Récupérer les pages disponibles pour être ajoutées au menu
        $pages = $pageRepository->findPagesNotInMenu($menu->getId());

        // Récupérer les pages associées au menu
        $pagesInMenu = $pageRepository->findPagesInMenu($id);


        // Récupérer les traductions pour les boutons
        $translationBtnAddPages = $this->translationService->findTranslation('btn_add_pages');
        $translationBtnAddPage = $this->translationService->findTranslation('btn_add_page');
        $translationNoPageSelected = $this->translationService->findTranslation('no_page_selected');

        return $this->render('back/setting/menu/add_page_menu.html.twig', [
            'pages' => $pages,
            'pagesMenu' => $pagesInMenu,
            'menu' => $menu,
            'btn_add_pages' => $translationBtnAddPages,
            'btn_add_page' => $translationBtnAddPage,
            'no_page_selected' => $translationNoPageSelected,
        ]);
    }
}
