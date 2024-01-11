<?php

namespace App\Controller\Front\Auth;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Front\Auth\Register\TeamRegisterType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TeamRegisterController extends AbstractController

{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/authentification/inscription/equipe', name: 'register_team', methods: ['GET', 'POST'])]
    public function register(Security $security, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {

        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }
        $team = new Team();
        $form = $this->createForm(TeamRegisterType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team->setRoles(['ROLE_ADMIN']);
            
            $hashedPassword = $passwordHasher->hashPassword(
                $team,
                $form->get('password')->getData()
            );
            $team->setPassword($hashedPassword);
            $entityManager->persist($team);
            $entityManager->flush();

            $successMessage = $this->translator->trans('success_message', [], 'validators');
        } else {
            $successMessage = null;
        }
        return $this->render('/front/auth/register/team.html.twig', [
            'form' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}
