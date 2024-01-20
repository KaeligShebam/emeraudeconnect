<?php

namespace App\Controller\Back\Page;

use DateTime;
use App\Entity\Page;
use App\Repository\PageRepository;
use App\Form\Back\Page\AddPageType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class AddController extends AbstractController
{
    #[Route('/ajouter', name: 'admin_add_page')]
    public function new(Request $request, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $page = new Page();
        $form = $this->createForm(AddPageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Générez le slug à partir du titre
            $page->setSlug($page->getTitle(), $slugger);

            // Définissez la date de création
            $page->setCreatedAt(new DateTime());

            // Persistez l'entité dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            // Redirigez l'utilisateur vers une page de confirmation, ou où vous voulez
        }

        return $this->render('back/page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }
}
