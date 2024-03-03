<?php
// src/Twig/AppExtension.php

namespace App\Twig;

use App\Repository\HookRepository;
use Psr\Log\LoggerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $hookRepository;
    private $logger;

    public function __construct(HookRepository $hookRepository, LoggerInterface $logger)
    {
        $this->hookRepository = $hookRepository;
        $this->logger = $logger;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('renderHook', [$this, 'renderHook'], ['is_safe' => ['html']]),
        ];
    }

    public function renderHook(string $hookName): string
    {
        // Récupérer le menu de navigation associé au hook
        $hook = $this->hookRepository->findOneBy(['name' => $hookName]);

        // Vérifier si le hook existe
        if ($hook) {
            // Enregistrer les informations du hook dans les logs
            $this->logger->info('Hook found:', ['hook' => $hook]);

            $menu = $hook->getMenuPage();
            
            $menuContent = '';

            // Si le menu existe, récupérer les pages associées
            if ($menu) {
                // Enregistrer les informations du menu dans les logs
                $this->logger->info('Menu found:', ['menu' => $menu]);

                $pages = $menu->getPages();
                
                // Enregistrer les informations des pages dans les logs
                $this->logger->info('Pages found:', ['pages' => $pages]);

                // Parcourir les pages et récupérer les titres
                foreach ($pages as $page) {
                    $menuContent .= '<li>' . $page->getTitle() . '</li>';
                }
            }

            return '<ul>' . $menuContent . '</ul>';
        } else {
            // Le hook n'existe pas, retourner une chaîne vide
            return '';
        }
    } 
}
