<?php

namespace App\Controller\Back\Setting\Translation;

use Symfony\Component\Yaml\Yaml;
use App\Service\TranslationService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TranslationController extends AbstractController
{
    private $translator;
    private $translationService;

    public function __construct(TranslatorInterface $translator, TranslationService $translationService)
    {
        $this->translator = $translator;
        $this->translationService = $translationService;

    }
    
    #[Route('/admin/parametres/traduction', name: 'translation_back')]
    public function translationPage()
    {

        $yamlFilePath = $this->getParameter('kernel.project_dir') . '/translations/validators.fr.yaml';
        $content = Yaml::parse(file_get_contents($yamlFilePath));

        $addButtonTranslate = $this->translationService->findTranslation('btn_add_translate');

        return $this->render('back/settings/translation/index.html.twig', [
            'content' => $content,
            'addButtonTranslate' => $addButtonTranslate,
        ]);
    }
    
}
