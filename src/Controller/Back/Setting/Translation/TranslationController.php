<?php

namespace App\Controller\Back\Setting\Translation;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TranslationController extends AbstractController
{
    #[Route('/admin/parametres/traduction', name: 'translation_back')]
    public function translationPage()
    {
        $yamlFilePath = $this->getParameter('kernel.project_dir') . '/translations/validators.fr.yaml';
        $content = Yaml::parse(file_get_contents($yamlFilePath));

        return $this->render('back/settings/translation/index.html.twig', [
            'content' => $content,
        ]);
    }
    
}
