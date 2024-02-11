<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\Page;
use App\Entity\PageMenu;
use App\Entity\PageMenuPage; // Importez l'entité PageMenuPage
use App\Service\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;

class AddPageOnMenuController extends AbstractController
{
    private $doctrine;
    private $translationService;

    public function __construct(ManagerRegistry $doctrine, TranslationService $translationService)
    {
        $this->doctrine = $doctrine;
        $this->translationService = $translationService;
    }

    /**
     * @Route("/add_pages_to_menu/{menuId}", name="add_pages_to_menu", methods={"GET", "POST"})
     */
    public function addPagesToMenu(Request $request, $menuId): Response
    {
        $data = json_decode($request->getContent(), true);
        $translationbBtnAddPages = $this->translationService->findTranslation('btn_add_pages');

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            $errorMessage = 'JSON decoding error: ' . json_last_error_msg();
            return new Response($errorMessage, Response::HTTP_BAD_REQUEST);
        }

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON decoding error: ' . json_last_error_msg();
            return new Response('Invalid data format', Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $this->doctrine->getManager();
        $menu = $entityManager->getRepository(PageMenu::class)->find($menuId);

        if (!$menu) {
            return new Response('Menu not found', Response::HTTP_NOT_FOUND);
        }
        
        // Vérifiez si la collection de pages est null
        $pagesMenu = $menu->getPages();
        if ($pagesMenu === null) {
            // Si la collection est null, initialisez-la avec une nouvelle collection
            $menu->setPages(new ArrayCollection());
            $pagesMenu = $menu->getPages();
        }

        $pageIds = $data['pageIds'];

        foreach ($pageIds as $pageId) {
            $page = $entityManager->getRepository(Page::class)->find($pageId);

            if (!$page) {
                return new Response('Page not found for id: ' . $pageId, Response::HTTP_NOT_FOUND);
            }

            if ($menu->getPages()->contains($page)) {
                continue;
            }

            $menu->addPage($page);
            
            // Créez une nouvelle entité PageMenuPage pour représenter la relation
            $pageMenuPage = new PageMenuPage();
            $pageMenuPage->setPageMenu($menu);
            $pageMenuPage->setPage($page);
            $entityManager->persist($pageMenuPage);
        }

        try {
            $entityManager->flush();
            return $this->redirectToRoute('app_menu_add_pages', ['id' => $menu->getId()]);
        } catch (\Exception $e) {
            return $this->redirectToRoute('app_menu_add_pages', ['id' => $menu->getId()]);
        }
    }
}
