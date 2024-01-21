<?php

namespace App\Controller\Front\Page;

use App\Entity\Page;
use App\Service\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends AbstractController
{
    private $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    #[Route("/{slug}", name:"app_page")]
    public function detail(string $slug, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $errorMessage = $this->translationService->findTranslation('error_404');
    
        // Recherche de la page par le slug
        $page = $entityManager->getRepository(Page::class)->findOneBy(['slug' => $slug]);
    
        // Si la page n'est pas trouvée, déclencher une exception 404
        if (!$page) {
            throw new NotFoundHttpException($errorMessage);
        }
    
        // Vérifier si le statut de la page est "Publié"
        if ($page->getStatus() !== null && $page->getStatus()->getName() !== 'Publié') {
            // Lever une exception NotFoundHttpException pour renvoyer une erreur 404
            throw $this->createNotFoundException($errorMessage);
        }
    
        return $this->render('front/page/detail.html.twig', [
            'page' => $page,
        ]);
    }
    
}

