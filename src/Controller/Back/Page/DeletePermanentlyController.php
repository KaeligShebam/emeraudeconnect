<?php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/page')]
class DeletePermanentlyController extends AbstractController
{
    #[Route('/corbeille/definitvement/{id}', name: 'page_delete_permanently_admin')]
    public function deleteId(Page $page, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $entityManager->remove($page);
        $entityManager->flush();

        return $this->redirectToRoute('page_list_admin');
    }
}
