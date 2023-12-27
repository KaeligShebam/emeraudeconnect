<?php

namespace App\Controller\Front\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/authentification', name: 'login')]
    public function index(): Response
    {
        return $this->render('front/security/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}
