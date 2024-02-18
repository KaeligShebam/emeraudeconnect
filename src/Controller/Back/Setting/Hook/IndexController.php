<?php
namespace App\Controller\Back\Setting\Hook;

use App\Repository\HookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/admin/points-accroches", name="hook_admin")
     */
    #[Route('/admin/points-accroches', name: 'app_hook_admin')]
    public function index(HookRepository $hookRepository): Response
    {
        $hooks = $hookRepository->findAll();

        return $this->render('back/setting/hook/index.html.twig', [
            'hooks' => $hooks,
        ]);
    }
}