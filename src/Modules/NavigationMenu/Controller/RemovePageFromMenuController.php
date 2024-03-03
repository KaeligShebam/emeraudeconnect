<?php

namespace App\Modules\NavigationMenu\Controller;

use App\Repository\PageRepository;
use App\Modules\NavigationMenu\Repository\NavigationMenuRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Modules\NavigationMenu\Repository\PageMenuPageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemovePageFromMenuController extends AbstractController
{
    private $doctrine;
    private $navigationMenuRepository;

    public function __construct(ManagerRegistry $doctrine, NavigationMenuRepository $navigationMenuRepository)
    {
        $this->doctrine = $doctrine;
        $this->navigationMenuRepository = $navigationMenuRepository;
    }

    #[Route('/remove_page_from_menu/{menuId}/{pageId}', name: 'remove_page_from_menu', methods: "GET")]
    public function removePageFromMenu($menuId, $pageId, NavigationMenuRepository $navigationMenuRepository, PageRepository $pageRepository, PageMenuPageRepository $pageMenuPageRepository): Response
    {
        $entityManager = $this->doctrine->getManager();
        $menu = $navigationMenuRepository->find($menuId);
        $page = $pageRepository->find($pageId);

        if (!$menu || !$page) {
            return new Response('Menu or page not found', Response::HTTP_NOT_FOUND);
        }

        $pageMenuPage = $pageMenuPageRepository->findOneBy(['navigationMenu' => $menu, 'page' => $page]);

        if ($pageMenuPage) {
            // Supprimer la relation
            $entityManager->remove($pageMenuPage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_menu_add_pages', ['id' => $menu->getId()]);
    }

}
