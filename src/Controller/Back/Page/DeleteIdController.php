<?php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/page')]
class DeleteIdController extends AbstractController
{
    #[Route('/corbeille/{id}', name: 'page_delete_admin')]
    public function deleteId(Page $page, ManagerRegistry $doctrine): Response
    {


        $page->setIsDeleted(true);

        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('page_list_admin');
    }
}
