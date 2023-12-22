<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', methods: ['GET', 'HEAD'])]
    public function show(): Response
    {
        return $this->render('/front/homepage/index.html.twig');
    }

}