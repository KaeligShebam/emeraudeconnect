<?php

namespace App\Controller\Back\Page;

use DateTime;
use App\Entity\Page;
use App\Repository\PageRepository;
use App\Form\Back\Page\AddPageType;
use App\Service\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/page')]
class AddController extends AbstractController
{

    private $translator;
    private $translationService;

    public function __construct(TranslatorInterface $translator, TranslationService $translationService)
    {
        $this->translator = $translator;
        $this->translationService = $translationService;
    }
    
    #[Route('/ajouter', name: 'page_add_admin')]
    public function new(Request $request, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $page = new Page();
        $form = $this->createForm(AddPageType::class, $page);
        $form->handleRequest($request);

        $successMessage = null;

        if ($form->isSubmitted() && $form->isValid()) {
            // Générez le slug à partir du titre
            $page->setSlug($page->getTitle(), $slugger);

            // Définissez la date de création
            $page->setCreatedAt(new DateTime());

            // Persistez l'entité dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            $successMessage = $this->translationService->findTranslation('success_add_page');
        }

        return $this->render('back/page/add.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}
