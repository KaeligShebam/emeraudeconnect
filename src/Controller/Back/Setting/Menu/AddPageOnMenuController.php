<?php

namespace App\Controller\Back\Setting\Menu;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PageMenu;
use App\Entity\Page;
use Doctrine\Persistence\ManagerRegistry;

class AddPageOnMenuController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
    * @Route("/add_pages_to_menu/{menuId}", name="add_pages_to_menu", methods={"GET", "POST"})
     */
    public function addPagesToMenu(Request $request, $menuId): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            $errorMessage = 'JSON decoding error: ' . json_last_error_msg();
            // Ajoutez ce message à la réponse pour le voir dans la console du navigateur
            return new Response($errorMessage, Response::HTTP_BAD_REQUEST);
        }
        

       // $data = json_decode('{"pageIds":["7"]}', true);
    
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            // Ajoutez un message de débogage pour afficher l'erreur JSON
            echo 'JSON decoding error: ' . json_last_error_msg();
            return new Response('Invalid data format', Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $this->doctrine->getManager();
        $menu = $entityManager->getRepository(PageMenu::class)->find($menuId);

        if (!$menu) {
            return new Response('Menu not found', Response::HTTP_NOT_FOUND);
        }

        $pageIds = $data['pageIds'];

        foreach ($pageIds as $pageId) {
            $page = $entityManager->getRepository(Page::class)->find($pageId);
        
            if (!$page) {
                return new Response('Page not found for id: ' . $pageId, Response::HTTP_NOT_FOUND);
            }
        
            // Check if the page is already in the menu
            if ($menu->getPages()->contains($page)) {
                continue;  // Ignorer cette page et passer à la suivante
            }
        
            $menu->addPage($page);
        }

        $entityManager->flush();

    }
}
