<?php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use App\Entity\PageStatus;
use App\Repository\PageStatusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class DeleteIdController extends AbstractController
{
    #[Route('/corbeille/{id}', name: 'page_delete_admin')]
    public function deleteId(Page $page, ManagerRegistry $doctrine, PageStatusRepository $pageStatusRepository): Response
    {
        $entityManager = $doctrine->getManager();

        // Vérifier si le statut de la page est "Publié"
        $publishedStatus = $pageStatusRepository->findOneBy(['name' => 'Publié']);
        if ($page->getStatus() === $publishedStatus) {
            // Mettre à jour le statut en "Brouillon"
            $draftStatus = $pageStatusRepository->findOneBy(['name' => 'Brouillon']);
            $page->setStatus($draftStatus);
        }

        // Mettre la page dans la corbeille
        $page->setIsDeleted(true);

        $entityManager->flush();

        return $this->redirectToRoute('page_list_admin');
    }
}
