<?php

namespace App\Controller\Back\Setting\Translation;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddTranslationController extends AbstractController
{


    #[Route('/admin/parametres/traduction/ajouter', name: 'add_translation_back')]
    public function addTranslation(Request $request)
    {
        try {
            $key = $request->request->get('key');
            $value = $request->request->get('value');
    
            // Load the current content of the YAML file
            $yamlFilePath = $this->getParameter('kernel.project_dir') . '/translations/validators.fr.yaml';
            $content = Yaml::parse(file_get_contents($yamlFilePath));
    
            // Add the new key-value pair
            $content[$key] = $value;
    
            // Save the modifications to the YAML file
            file_put_contents($yamlFilePath, Yaml::dump($content));
    
            return new JsonResponse(['message' => 'Nouvelle traduction ajoutée avec succès.']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Une erreur inattendue s\'est produite lors de l\'ajout de la traduction.']);
        }
    }
    
}
