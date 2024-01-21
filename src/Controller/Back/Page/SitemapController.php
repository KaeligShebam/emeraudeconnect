<?php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use App\Repository\PageRepository;
use App\Repository\PageSeoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    
    #[Route('/sitemap.xml', name: 'app_sitemap', format: 'xml')]
    public function generateSitemap(PageRepository $pageRepository): Response
    {
        $pages = $pageRepository->findForSitemap();

        $response = $this->render('front/page/sitemap.xml.twig', [
            'pages' => $pages,
        ]);

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
