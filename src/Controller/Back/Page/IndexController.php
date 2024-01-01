<?php

namespace App\Controller\Back\Page;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/page')]
class IndexController extends AbstractController
{
    #[Route('/',  name: 'admin_page')]
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('back/page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }
}
