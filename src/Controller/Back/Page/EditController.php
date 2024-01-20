<?php
// src/Controller/Back/Page/EditController.php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use App\Form\Back\Page\EditPageType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class EditController extends AbstractController
{
    #[Route('/modifier/{id}', name: 'admin_edit_page')]
    public function edit(Request $request, Page $page, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(EditPageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Générez le slug à partir du titre
            $page->setSlug($page->getTitle(), $slugger);

            // Mettez à jour la date de modification
            $page->setUpdatedAt(new \DateTime());

            // Persistez l'entité dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            // Redirigez l'utilisateur vers une page de confirmation, ou où vous voulez
        }

        return $this->render('back/page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView()
        ]);
    }
}
