<?php

namespace App\Modules\NavigationMenu\Controller;

use App\Modules\NavigationMenu\Entity\PageMenuPage;
use App\Repository\PageMenuPageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateMenuPositionController extends AbstractController
{
    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    #[Route('/update-menu-position', name: 'update_menu_position', methods: 'POST')]
    public function updateMenuPositions(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid data format'], Response::HTTP_BAD_REQUEST);
        }
        
        foreach ($data as $item) {
            // Vérifiez si les clés "page_id" et "position" existent dans chaque objet
            if (isset($item['page_id']) && isset($item['position'])) {
                // Recherchez l'enregistrement de PageMenuPage correspondant à la page dans le menu
                $pageMenuPage = $entityManager->getRepository(PageMenuPage::class)->findOneBy(['page' => $item['page_id']]);
                
                // Si l'enregistrement existe, mettez à jour sa position
                if ($pageMenuPage) {
                    $pageMenuPage->setPosition($item['position']);
                    $entityManager->persist($pageMenuPage);
                }
            } else {
                return new JsonResponse(['error' => 'Missing required keys'], Response::HTTP_BAD_REQUEST);
            }
        }
    
        // Exécutez toutes les opérations d'enregistrement en une seule fois
        $entityManager->flush();
    
        return new JsonResponse(['success' => true]);
    }
    
    
    
 
}
