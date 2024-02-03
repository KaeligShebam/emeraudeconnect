<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\PageMenu;
use App\Repository\PageRepository;
use App\Service\TranslationService;
use App\Repository\PageMenuRepository;
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

    #[Route('/admin/parametres/menu/{id}', name: 'app_menu_add_pages')]
    public function addPagesToMenu(int $id, Request $request, PageRepository $pageRepository, ManagerRegistry $doctrine, PageMenuRepository $pageMenuRepository)
    {
        $entityManager = $doctrine->getManager();
        
        // Récupérer la liste des pages à partir du repository
        $pages = $pageRepository->findAll(); // Remplacez cela par la méthode appropriée selon votre logique

        // Retrieve the PageMenu entity by id
        $menu = $pageMenuRepository->find($id);

        if (!$menu instanceof PageMenu) {
            throw $this->createNotFoundException('Menu not found');
        }

        // Access the associated pages
        $pagesMenu = $menu->getPages();

        $translationBtnAddPages = $this->translationService->findTranslation('btn_add_pages');
        $translationBtnAddPage = $this->translationService->findTranslation('btn_add_page');
        $translationNoPageSelected = $this->translationService->findTranslation('no_page_selected');
        
        return $this->render('back/setting/menu/add_page_menu.html.twig', [
            'pages' => $pages,
            'pagesMenu' => $pagesMenu,
            'menu' => $menu,
            'btn_add_pages' => $translationBtnAddPages,
            'btn_add_page' => $translationBtnAddPage,
            'no_page_selected' => $translationNoPageSelected,
        ]);
    }
}
