<?php

 

declare(strict_types=1);

 

namespace App\Controller\Back\Setting\Menu;

 

use App\Entity\PageMenu;
use Psr\Log\LoggerInterface;
use App\Repository\PageRepository;
use App\Repository\PageMenuRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AddPageOnMenuController extends AbstractController

{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly PageRepository $pageRepository,
        private readonly PageMenuRepository $pageMenuRepository,
        private readonly EntityManagerInterface $entityManager

    ){}

    #[Route('/ajax/save-pages-to-menu/{id}', name: 'ajax_save_pages_to_menu')]
    public function __invoke(PageMenu $menu,Request $request, PageMenuRepository $pageMenuRepository): JsonResponse {

        $data = json_decode($request->getContent(),true);

        // Tu peux utiliser un validator via Validation::createValidator() et employer les constraints SF si tu veux.

        if (!isset($data['pageIds']) || !is_array($data['pageIds']) || empty($data['pageIds'])) {

            return $this->json(
                ['error' => 'Les IDs des pages n\'ont pas été fournis ou sont invalides.'],
                JsonResponse::HTTP_BAD_REQUEST
            );

        }
        $this->logger->info('IDs des pages reçus depuis la requête:', ['pageIds' => $data['pageIds']]);
        $selectedPages = $this->pageRepository->findPagesByIds([1]);

        foreach ($selectedPages as $page) {
            $this->logger->info('Page liée au menu, ID de la page : ' . $page->getId());
            $menu->addPage($page);
        }

        
        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return $this->json(['success' => true,'message' => 'Enregistrement réussi.']);

    }

}
