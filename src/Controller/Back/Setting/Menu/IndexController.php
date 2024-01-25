<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\PageMenu;
use App\Repository\PageMenuRepository;
use App\Repository\PageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/admin/parametres/menu/{id}/ajouter-pages', name: 'app_menu_add_pages')]
    public function addPagesToMenu(int $id, Request $request, PageRepository $pageMenuRepository, ManagerRegistry $doctrine, PageMenuRepository $pageRepository)
    {
        // Récupérer la liste des pages à partir du repository
        $pages = $pageMenuRepository->findAll(); // Remplacez cela par la méthode appropriée selon votre logique

        // Retrieve the PageMenu entity by id
        $menu = $pageRepository->find($id);

        if (!$menu instanceof PageMenu) {
            throw $this->createNotFoundException('Menu not found');
        }

        // Access the associated pages
        $pagesMenu = $menu->getPages();

    
        return $this->render('back/setting/menu/add_page_menu.html.twig', [
            'pages' => $pages, // Passer la liste des pages à la vue
            'pagesMenu' => $pagesMenu
        ]);
    }
}
