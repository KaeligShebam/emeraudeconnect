<?php

namespace App\Controller\Back\Setting\Menu;

use Psr\Log\LoggerInterface;
use App\Repository\PageRepository;
use App\Repository\PageMenuRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddPageOnMenuController extends AbstractController
{
    private $serializer;
    private $logger; // Ajoutez la propriété $logger

    public function __construct(SerializerInterface $serializer, LoggerInterface $logger) // Ajoutez LoggerInterface ici
    {
        $this->serializer = $serializer;
        $this->logger = $logger; // Initialisez $logger
    }

    #[Route('/ajax/save-pages-to-menu/{id}', name: 'ajax_save_pages_to_menu')]
    public function savePagesToMenu(Request $request, ManagerRegistry $doctrine, $id, PageMenuRepository $pageMenuRepository, PageRepository $pageRepository): JsonResponse
    {
        $menuId = is_numeric($id) ? (int)$id : $id;
    
        // Vérifier si l'ID du menu a été fourni
        if ($menuId === null) {
            return new JsonResponse(['error' => 'L\'ID du menu n\'a pas été fourni.'], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        // Utiliser le Serializer pour désérialiser les données JSON
        $data = json_decode($request->getContent(), true);
    
        // Vérifier si les IDs des pages ont été fournis
        if (!isset($data['pageIds']) || !is_array($data['pageIds'])) {
            return new JsonResponse(['error' => 'Les IDs des pages n\'ont pas été fournis ou sont invalides.'], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        // Récupérer le menu et les pages depuis la base de données
        $entityManager = $doctrine->getManager();
        $menu = $pageMenuRepository->find($menuId);
    
        // Vérifier si le menu a été trouvé
        if (!$menu) {
            return new JsonResponse(['error' => 'Le menu spécifié n\'a pas été trouvé.'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        $pages = $pageRepository->findAll();
    
        // Ajouter des logs pour déboguer
        $this->logger->info('Pages récupérées depuis la base de données:', ['pages' => $pages]);
    
        // Ajouter les pages au menu
        foreach ($pages as $page) {
            $this->logger->info('Page liée au menu, ID de la page : ' . $page->getId());
            $menu->addPage($page);
            $entityManager->persist($page); // Persistez chaque page
        }
    
        $this->logger->info('Nombre total de pages liées au menu : ' . count($menu->getPages()));
    
        $entityManager->persist($menu);
        $entityManager->flush();
    
        $this->logger->info('Flush effectué.');
    
        // Répondre à la requête AJAX avec un JSON
        return new JsonResponse(['success' => true, 'message' => 'Enregistrement réussi.']);
    }
    
    
}
