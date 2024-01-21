<?php

namespace App\Controller\Front\Page;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route("/{slug}", name:"app_page")]
    public function detail(Page $page): Response
    {
        return $this->render('front/page/detail.html.twig', [
            'page' => $page,
        ]);
    }
}
