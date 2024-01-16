<?php
namespace App\Controller\Back\Setting\Translation;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModifyTranslationController extends AbstractController
{
    #[Route('/admin/parametres/traduction/modifier', name: 'modify_translation_back', methods: ['POST'])]
    public function modifyTranslation(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $key = $data['key'] ?? null;
        $value = $data['value'] ?? null;

        if (!$key || !$value) {
            return new JsonResponse(['error' => 'Clé et valeur requis.'], 400);
        }

        $yamlFilePath = $this->getParameter('kernel.project_dir') . '/translations/validators.fr.yaml';

        // Charger le fichier YAML
        $yamlContent = file_get_contents($yamlFilePath);
        $translations = Yaml::parse($yamlContent);

        // Recherche de la catégorie et mise à jour de la valeur
        $category = $this->findCategoryForKey($key, $translations);

        if ($category !== null) {
            $translations[$category][$key] = $value;

            // Réécrire le fichier YAML
            $yamlContentUpdated = Yaml::dump($translations);
            file_put_contents($yamlFilePath, $yamlContentUpdated);

            return new JsonResponse(['success' => true, 'category' => $category]);
        }

        return new JsonResponse(['error' => 'Clé non trouvée dans le fichier YAML.'], 400);
    }

    private function findCategoryForKey($key, $translations)
    {
        foreach ($translations as $category => $keysValues) {
            if (isset($keysValues[$key])) {
                return $category;
            }
        }

        return null;
    }
}
