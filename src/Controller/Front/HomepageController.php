<?php

namespace App\Controller\Front;

use App\Service\MenuNavigationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    #[Route('/',  name: 'homepage')]
    public function show(MenuNavigationService $menuNavigationService): Response
    {
        $menuItems = $menuNavigationService->getMenuItems();
        return $this->render('/front/homepage/index.html.twig', [
            'menuItems' => $menuItems,
        ]);
    }

}