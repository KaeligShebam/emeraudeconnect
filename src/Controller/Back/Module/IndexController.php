<?php
// src/Controller/Back/Module/IndexController.php

namespace App\Controller\Back\Module;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;

class IndexController extends AbstractController
{

    #[Route('/admin/modules', name: 'app_module_admin')]
    public function index(): Response
    {
        // Récupérer le répertoire des modules
        $modulesDir = __DIR__ . '/../../../Modules'; // Changer le chemin pour accéder à src/Modules

        // Initialiser le Finder pour parcourir les répertoires
        $finder = new Finder();
        $finder->directories()->in($modulesDir);

        // Stocker les informations sur les modules
        $modules = [];

        // Parcourir les répertoires des modules
        foreach ($finder as $moduleDir) {
            // Chemin du fichier de configuration
            $configFile = $moduleDir->getPathname() . '/config.yaml';

            // Vérifier si le fichier de configuration existe
            if (file_exists($configFile)) {
                // Lire le contenu du fichier de configuration
                $configContent = file_get_contents($configFile);

                // Parser le contenu YAML
                $configData = Yaml::parse($configContent);

                // Récupérer le nom et la description du module à partir du fichier de configuration
                if (isset($configData['module_name']) && isset($configData['module_description']) && isset($configData['module_version'])) {
                    $moduleName = $configData['module_name'];
                    $moduleDescription = $configData['module_description'];
                    $moduleVersion = $configData['module_version'];

                    // Ajouter le nom et la description du module à la liste des modules
                    $modules[] = ['name' => $moduleName, 'description' => $moduleDescription, 'version' => $moduleVersion];
                }
            }
        }

        // Retourner la réponse, par exemple, afficher les noms et descriptions des modules
        return $this->render('back/module/index.html.twig', [
            'modules' => $modules,
        ]);
    }
}
