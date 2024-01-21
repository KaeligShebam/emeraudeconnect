<?php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class RestoreIdController extends AbstractController
{

    #[Route('/restaurer/{id}', name: 'page_restore_id_admin')]
    public function restore(Page $page, ManagerRegistry $doctrine): Response
    {
        $page->setIsDeleted(false);

        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('page_list_admin');
    }
}
