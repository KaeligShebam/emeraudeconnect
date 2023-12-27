<?php
// src/Controller/TeamController.php

namespace App\Controller\Front\Auth;

use App\Entity\Team;
use App\Form\Front\Auth\Register\TeamRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamRegisterController extends AbstractController
{
    #[Route('/authentitfication/equipe/inscription', name: 'register_team')]
    public function register(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamRegisterType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($team);
            $entityManager->flush();


            return $this->redirectToRoute('home'); // Remplacez 'home' par le nom de la route souhaitée
        }

        return $this->render('/front/auth/register/team.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
