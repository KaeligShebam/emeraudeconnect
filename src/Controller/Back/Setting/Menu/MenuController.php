<?php

namespace App\Controller\Back\Setting\Menu;

use App\Entity\PageMenu;
use App\Service\TranslationService;
use App\Repository\PageMenuRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Back\Setting\Menu\AddMenuType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    #[Route('/admin/parametres/menu', name: 'app_menu_admin')]
    public function index(PageMenuRepository $pageMenuRepository): Response
    {
        $menus = $pageMenuRepository->findAll();

        return $this->render('back/setting/menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }
}
