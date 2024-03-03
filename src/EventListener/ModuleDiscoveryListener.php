<?php
// src/EventListener/ModuleDiscoveryListener.php

namespace App\EventListener;

use App\Entity\Hook;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class ModuleDiscoveryListener implements EventSubscriberInterface
{
    private $params;
    private $doctrine;

    public function __construct(ParameterBagInterface $params, ManagerRegistry $doctrine)
    {
        $this->params = $params;
        $this->doctrine = $doctrine;
    }

    public function onKernelController(ControllerEvent $event)
    {
        // Récupérer le nom du contrôleur
        $controller = $event->getController();

        // Vérifier si le contrôleur est un contrôleur de découverte de module
        if ($this->isModuleController($controller)) {
            // Récupérer le chemin du fichier de configuration du module
            $moduleConfigPath = $this->getModuleConfigPath();

            // Si le chemin du fichier de configuration est trouvé
            if ($moduleConfigPath) {
                // Extraire le nom et la description du hook à partir du fichier de configuration
                $hookConfig = $this->getHookConfig($moduleConfigPath);

                // Ajouter le hook à la base de données
                $this->addHookToDatabase($hookConfig['name'], $hookConfig['description']);
            }
        }
    }

    private function isModuleController($controller)
    {
        // Votre logique pour vérifier si le contrôleur est un contrôleur de découverte de module
        // Par exemple, vérifiez le nom de la classe du contrôleur ou utilisez une autre logique de filtrage

        return true; // À adapter en fonction de votre logique
    }

    private function getModuleConfigPath()
    {
        // Chemin du fichier de configuration du module
        return dirname(__DIR__, 3) . '/emeraudeconnect/src/Modules/NavigationMenu/config.yaml';

    }

    private function getHookConfig($moduleConfigPath)
    {
        // Lire le fichier de configuration YAML du module
        $moduleConfig = Yaml::parseFile($moduleConfigPath);

        // Extraire le nom et la description du hook à partir du fichier de configuration
        return [
            'name' => $moduleConfig['hook_name'],
            'description' => $moduleConfig['hook_description'],
        ];
    }

    private function addHookToDatabase($name, $description)
    {
        // Vérifier si le hook existe déjà en base de données
        $existingHook = $this->doctrine->getRepository(Hook::class)->findOneBy(['name' => $name]);
    
        // Si le hook n'existe pas encore en base de données, ajoutez-le
        if (!$existingHook) {
            // Créer une nouvelle instance de l'entité Hook et attribuer le nom et la description extraits
            $hook = new Hook();
            $hook->setName($name);
            $hook->setDescription($description);
    
            // Persistez et flush l'entité dans la base de données
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($hook);
            $entityManager->flush();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
