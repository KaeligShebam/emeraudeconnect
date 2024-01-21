<?php

namespace App\Controller\Back\Page;

use App\Entity\Page;
use Symfony\Component\Yaml\Yaml;
use App\Repository\PageRepository;
use App\Service\TranslationService;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/',  name: 'page_list_admin')]
    public function index(PageRepository $pageRepository, EntityManagerInterface $entityManager): Response
    {
        $addPageButtonLabel = $this->translationService->findTranslation('btn_add_page');
        $trashButton = $this->translationService->findTranslation('btn_trash_page');
        $sitemapButton = $this->translationService->findTranslation('btn_sitemap_page');

        $countPagesDeleted = $pageRepository->count(['isDeleted' => 1]);

        $pages = $pageRepository->findActivePages();

        return $this->render('back/page/index.html.twig', [
            'pages' => $pages,
            'addPageButtonLabel' => $addPageButtonLabel,
            'trashButton' => $trashButton,
            'sitemapButton' => $sitemapButton,
            'countPagesDeleted' => $countPagesDeleted
        ]);
    }

}
