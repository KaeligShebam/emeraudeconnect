<?php

namespace App\Controller\Back\Users\Team;

use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/utilisateurs/equipe')]
class IndexController extends AbstractController
{
    #[Route('/',  name: 'users_team_admin')]
    public function index(TeamRepository $teamRepository): Response
    {

        return $this->render('back/user/team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

}
