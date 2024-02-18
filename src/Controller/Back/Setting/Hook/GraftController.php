<?php
namespace App\Controller\Back\Setting\Hook;

use App\Repository\HookRepository;
use App\Repository\PageMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraftController extends AbstractController
{
    #[Route('/admin/points-accroches/ajouter/greffe', name: 'app_hook_graft_add_admin')]
    public function index(HookRepository $hookRepository, PageMenuRepository $pageMenuRepository): Response
    {
        $hooks = $hookRepository->findAll();
        $pageMenus = $pageMenuRepository->findAll();

        return $this->render('back/setting/hook/add_graft.html.twig', [
            'hooks' => $hooks,
            'pageMenus' => $pageMenus,
        ]);
    }
}
