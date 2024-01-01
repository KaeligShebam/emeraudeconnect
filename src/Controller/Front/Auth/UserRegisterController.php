<?php

namespace App\Controller\Front\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Front\Auth\Register\UserRegisterType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterController extends AbstractController

{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/authentification/inscription', name: 'register_user', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            $successMessage = $this->translator->trans('success_message_register_user', [], 'validators');
        } else {
            $successMessage = null;
        }
        return $this->render('/front/auth/register/user.html.twig', [
            'form' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}
