<?php

namespace App\Modules\NavigationMenu\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\NavigationMenu\Entity\NavigationMenu;
use Symfony\Component\Routing\Annotation\Route;
use App\Modules\NavigationMenu\Form\AddMenuType;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddMenuController extends AbstractController
{
    #[Route('/admin/modules/menu-de-navigation/ajouter', name: 'app_menu_add_admin')]
    public function createMenu(Request $request, ManagerRegistry $doctrine)
    {
        $navigationMenu = new NavigationMenu();

        $form = $this->createForm(AddMenuType::class, $navigationMenu);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager(); // Correction de la variable
            $entityManager->persist($navigationMenu);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_menu_add_pages', ['id' => $navigationMenu->getId()]);
        }
    
        return $this->render('@NavigationMenu/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
