<?php

namespace App\Modules\NavigationMenu\Controller;

use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\NavigationMenu\Entity\PageMenu;
use Symfony\Component\Routing\Annotation\Route;
use App\Modules\NavigationMenu\Form\AddMenuType;
use App\Form\Back\Setting\Menu\AddPagesToMenuType;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Modules\NavigationMenu\Repository\PageRepository;
use App\Modules\NavigationMenu\Repository\PageMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddMenuController extends AbstractController
{
    #[Route('/admin/modules/menu-de-navigation/ajouter', name: 'app_menu_add_admin')]
    public function createMenu(Request $request, ManagerRegistry $doctrine)
    {
        $pageMenu = new PageMenu();
        
        $form = $this->createForm(AddMenuType::class, $pageMenu);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager(); // Correction de la variable
            $entityManager->persist($pageMenu);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_menu_add_pages', ['id' => $pageMenu->getId()]);
        }
    
        return $this->render('back/setting/menu/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
