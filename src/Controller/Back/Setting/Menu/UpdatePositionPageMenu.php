<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\PageMenu;
use App\Repository\PageMenuRepository;
use App\Repository\PageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdatePositionPageMenu extends AbstractController
{
    #[Route('/update_page_position', name: 'update_page_position')]
    public function updatePagePosition(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
    
        $menuId = $data['menuId'];
        $pageId = $data['pageId'];
        $newPosition = $data['newPosition'];
    
        // Mettez à jour la position de la page dans la base de données
    
        return new Response('Page position updated successfully', Response::HTTP_OK);
    }
}
