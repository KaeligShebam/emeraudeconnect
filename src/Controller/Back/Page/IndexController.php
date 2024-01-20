<?php

namespace App\Controller\Back\Page;

use Symfony\Component\Yaml\Yaml;
use App\Repository\PageRepository;
use App\Service\TranslationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class IndexController extends AbstractController
{
    private $translator;
    private $translationService;

    public function __construct(TranslatorInterface $translator, TranslationService $translationService)
    {
        $this->translator = $translator;
        $this->translationService = $translationService;

    }
    #[Route('/',  name: 'admin_page')]
    public function index(PageRepository $pageRepository): Response
    {
        $addPageButtonLabel = $this->translationService->findTranslation('btn_add_page');

        return $this->render('back/page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
            'addPageButtonLabel' => $addPageButtonLabel,
        ]);
    }

}
