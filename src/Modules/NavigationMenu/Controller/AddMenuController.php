<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\Page;
use App\Modules\NavigationMenu\Entity\PageMenu;
use App\Repository\PageRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Back\Setting\Menu\AddMenuType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Back\Setting\Menu\AddPagesToMenuType;
use App\Repository\PageMenuRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddMenuController extends AbstractController
{
    #[Route('/admin/parametres/menu/ajouter', name: 'app_menu_add_admin')]
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
