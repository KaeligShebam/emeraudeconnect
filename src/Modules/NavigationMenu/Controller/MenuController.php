<?php

namespace App\Modules\NavigationMenu\Controller;

use App\Modules\NavigationMenu\Repository\PageMenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{

    private $pageMenuRepository;

    public function __construct(PageMenuRepository $pageMenuRepository)
    {
        $this->pageMenuRepository = $pageMenuRepository;
    }

    #[Route('/admin/modules/menu-de-navigation', name: 'app_menu_admin')]
    public function index(PageMenuRepository $pageMenuRepository): Response
    {
        $menus = $pageMenuRepository->findAll();

        return $this->render('back/setting/menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }
    
}
