<?php

namespace App\Modules\NavigationMenu\Controller;

use App\Entity\Hook;
use App\Repository\HookRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\NavigationMenu\Entity\NavigationMenu;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Modules\NavigationMenu\Repository\NavigationMenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AssignHookToMenuController extends AbstractController
{
    #[Route('/admin/modules/menu-de-navigation/assigner-hook/{id}/', name: 'app_menu_assign_hook')]
    public function assignHookToMenu(
        int $id,
        Request $request,
        NavigationMenuRepository $navigationMenuRepository,
        HookRepository $hookRepository,
        EntityManagerInterface $entityManager
    ): RedirectResponse {
        // Récupérer le menu de navigation à associer au hook
        $menu = $navigationMenuRepository->find($id);

        // Vérifier si le menu existe
        if (!$menu instanceof NavigationMenu) {
            throw $this->createNotFoundException('Menu not found');
        }

        // Récupérer le nom du hook sélectionné à partir des données du formulaire
        $hookName = $request->request->get('hook_select');

        // Récupérer l'entité Hook correspondante en fonction du nom
        $hook = $hookRepository->findOneBy(['name' => $hookName]);

        // Si un hook correspondant est trouvé, l'associer au menu de navigation
        if ($hook instanceof Hook) {
            // Vérifier si le hook est déjà assigné à un autre menu
            $otherMenuWithHook = $hook->getNavigationMenu();

            if ($otherMenuWithHook !== null) {
                // Dissocier le hook de l'autre menu
                $otherMenuWithHook->setHook(null);
                $entityManager->persist($otherMenuWithHook);
            }

            // Assigner le nouveau hook au menu
            $menu->setHook($hook);

            // Enregistrer les modifications dans la base de données
            $entityManager->flush();
        } else {
            // Gérer le cas où aucun hook correspondant n'est trouvé
            // Par exemple, afficher un message d'erreur ou effectuer une action appropriée
            // ...
        }

        // Rediriger l'utilisateur vers une autre page après avoir traité le formulaire
        return $this->redirectToRoute('app_menu_add_pages', ['id' => $id]);
    }
}
