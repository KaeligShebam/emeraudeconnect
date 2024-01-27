<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\PageMenu;
use App\Repository\PageMenuRepository;
use App\Repository\PageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
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

        return $this->render('back/setting/menu/add_page_menu.html.twig', [
            'pages' => $pages, // Passer la liste des pages à la vue
            'pagesMenu' => $pagesMenu,
            'menu' => $menu
        ]);
    }
}
