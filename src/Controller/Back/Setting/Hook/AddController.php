<?php
namespace App\Controller\Back\Setting\Hook;

use App\Entity\Hook;
use App\Repository\HookRepository;
use App\Service\TranslationService;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Back\Setting\Hook\AddHookType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddController extends AbstractController
{

    private $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }
    
    #[Route('/admin/points-accroches/ajouter', name: 'app_hook_add_admin')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $hook = new Hook();
        $form = $this->createForm(AddHookType::class, $hook);
        $form->handleRequest($request);

        $successMessage = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($hook);
            $entityManager->flush();
            $successMessage = $this->translationService->findTranslation('success_add_hook');
        }

        return $this->render('back/setting/hook/add.html.twig', [
            'successMessage' => $successMessage,
            'form' => $form->createView(),
        ]);
    }
}