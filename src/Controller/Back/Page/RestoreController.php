<?php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use App\Repository\PageRepository;
use App\Service\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class RestoreController extends AbstractController
{

    private $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;

    }

    #[Route('/corbeille', name: 'page_trash_admin')]
    public function restore(PageRepository $pageRepository): Response
    {
        $returnButton = $this->translationService->findTranslation('btn_return_page');

        return $this->render('back/page/trash.html.twig', [
            'pages' => $pageRepository->findBy(['isDeleted' => true]),
            'returnButton' => $returnButton
        ]);
    }
}
