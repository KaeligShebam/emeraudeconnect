<?php

namespace App\Modules\NavigationMenu\Controller;

use Symfony\Component\Yaml\Yaml;
use App\Repository\PageRepository;
use App\Service\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\NavigationMenu\Entity\NavigationMenu;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Modules\NavigationMenu\Repository\NavigationMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{

    private $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    #[Route('/admin/modules/menu-de-navigation/{id}', name: 'app_menu_add_pages')]
    public function addPagesToMenu(int $id, Request $request, PageRepository $pageRepository, ManagerRegistry $doctrine, NavigationMenuRepository $navigationMenuRepository, KernelInterface $kernel)
    {
        $entityManager = $doctrine->getManager();
        
        // Récupérer le menu
        $menu = $navigationMenuRepository->find($id);

        // Vérifier si le menu existe
        if (!$menu instanceof NavigationMenu) {
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
        $translationBtnSave = $this->translationService->findTranslation('btn_save');


        $moduleDirectory = $kernel->getProjectDir() . '/src/Modules/NavigationMenu';
        $moduleConfig = Yaml::parseFile($moduleDirectory . '/config.yaml');

        // Liste des hooks disponibles dans la configuration
        $availableHooks = [$moduleConfig['hook_name']];

        // Liste des hooks déjà utilisés dans votre application
        $usedHooks = []; // À compléter avec vos hooks utilisés

        // Liste des hooks non utilisés
        $unusedHooks = array_diff($availableHooks, $usedHooks);

        return $this->render('@NavigationMenu/add_page_menu.html.twig', [
            'pages' => $pages,
            'pagesMenu' => $pagesInMenu,
            'menu' => $menu,
            'btn_add_pages' => $translationBtnAddPages,
            'btn_add_page' => $translationBtnAddPage,
            'no_page_selected' => $translationNoPageSelected,
            'btn_save' => $translationBtnSave,
            'unusedHooks' => $unusedHooks,
        ]);
    }
}
