<?php

namespace App\Controller\Front\Auth;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Front\Auth\Register\TeamRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamRegisterController extends AbstractController
{

    #[Route('/authentification/equipe/inscription', name: 'register_team', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamRegisterType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team->setPassword('plain_password');
            $team->setRoles(['ROLE_ADMIN']);
            $entityManager->persist($team);
            $entityManager->flush();
        }

        return $this->render('/front/auth/register/team.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
