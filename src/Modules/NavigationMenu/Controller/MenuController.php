<?php

namespace App\Controller\Back\Setting\Menu;

use App\Service\PageMenuService;
use App\Repository\PageMenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{

    private $pageMenuRepository;

    public function __construct(PageMenuRepository $pageMenuRepository)
    {
        $this->pageMenuRepository = $pageMenuRepository;
    }

    #[Route('/admin/parametres/menu', name: 'app_menu_admin')]
    public function index(PageMenuRepository $pageMenuRepository): Response
    {
        $menus = $pageMenuRepository->findAll();

        return $this->render('back/setting/menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }
    
}
