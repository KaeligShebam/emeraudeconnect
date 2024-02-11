<?php
// src/Controller/Back/Setting/Menu/RemovePageFromMenuController.php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\Page;
use App\Repository\MenuRepository;
use App\Repository\PageRepository;
use App\Repository\PageMenuRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PageMenuPageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemovePageFromMenuController extends AbstractController
{
    private $doctrine;
    private $pageMenuRepository;

    public function __construct(ManagerRegistry $doctrine, PageMenuRepository $pageMenuRepository)
    {
        $this->doctrine = $doctrine;
        $this->pageMenuRepository = $pageMenuRepository;
    }

/**
 * @Route("/remove_page_from_menu/{menuId}/{pageId}", name="remove_page_from_menu", methods={"GET"})
 */
public function removePageFromMenu($menuId, $pageId, PageMenuRepository $pageMenuRepository, PageRepository $pageRepository, PageMenuPageRepository $pageMenuPageRepository): Response
{
    // Vous devez implémenter la logique pour supprimer la page du menu ici
    // Utilisez le $menuId et $pageId pour trouver le menu et la page dans la base de données

    // Exemple (à adapter selon votre modèle de données) :
    $entityManager = $this->doctrine->getManager();
    $menu = $pageMenuRepository->find($menuId);
    $page = $pageRepository->find($pageId);

    if (!$menu || !$page) {
        return new Response('Menu or page not found', Response::HTTP_NOT_FOUND);
    }

    // Trouver la relation entre la page et le menu
    $pageMenuPage = $pageMenuPageRepository->findOneBy(['pageMenu' => $menu, 'page' => $page]);

    if ($pageMenuPage) {
        // Supprimer la relation
        $entityManager->remove($pageMenuPage);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_menu_add_pages', ['id' => $menu->getId()]);
}

}
