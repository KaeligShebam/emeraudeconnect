<?php

namespace App\Controller\Back;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    #[Route('/admin',  name: 'admin')]
    public function show(): Response
    {

        return $this->render('/back/base.html.twig');
    }

}