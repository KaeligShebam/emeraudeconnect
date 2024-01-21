<?php

namespace App\Controller\Back\Users\User;

use App\Entity\Page;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/utilisateurs/client')]
class IndexController extends AbstractController
{
    #[Route('/',  name: 'users_customer_admin')]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('back/user/customer/index.html.twig', [
            'customers' => $userRepository->findAll(),
        ]);
    }

}
