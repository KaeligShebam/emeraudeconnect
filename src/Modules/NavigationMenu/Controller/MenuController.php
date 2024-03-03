<?php

namespace App\Modules\NavigationMenu\Controller;

use App\Modules\NavigationMenu\Repository\NavigationMenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{

    private $navigationMenuRepository;

    public function __construct(NavigationMenuRepository $navigationMenuRepository)
    {
        $this->navigationMenuRepository = $navigationMenuRepository;
    }

    #[Route('/admin/modules/menu-de-navigation', name: 'app_menu_admin')]
    public function index(NavigationMenuRepository $navigationMenuRepository): Response
    {
        $menus = $navigationMenuRepository->findAll();

        return $this->render('@NavigationMenu/index.html.twig', [
            'menus' => $menus,
        ]);
    }
    
}
