<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\Page;
use App\Entity\PageMenu;
use App\Service\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/add_pages_to_menu/{menuId}", name="add_pages_to_menu", methods={"POST"})
     */
    public function addPagesToMenu(Request $request, $menuId): Response
    {
        $entityManager = $this->doctrine->getManager();
        $menu = $entityManager->getRepository(PageMenu::class)->find($menuId);
    
        if (!$menu) {
            return new Response('Menu not found', Response::HTTP_NOT_FOUND);
        }
    
        $data = json_decode($request->getContent(), true);
    
        if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
            return new Response('Invalid JSON data', Response::HTTP_BAD_REQUEST);
        }
    
        $pageIds = $data['pageIds'];
    
        foreach ($pageIds as $pageId) {
            $page = $entityManager->getRepository(Page::class)->find($pageId);
    
            if (!$page) {
                return new Response('Page not found for id: ' . $pageId, Response::HTTP_NOT_FOUND);
            }
    
            // Check if the page is already in the menu
            if ($menu->getPages()->contains($page)) {
                continue;
            }
    
            $menu->addPage($page);
        }
    
        try {
            $entityManager->flush();
        } catch (\Exception $e) {
            // Handle errors and display an error message if necessary
            $this->addFlash('error', 'Failed to add pages to menu: ' . $e->getMessage());
    
            // Redirect user to the same page
            return $this->redirectToRoute('nom_de_la_route_pour_cette_page');
        }
    
    }
    
    
}
