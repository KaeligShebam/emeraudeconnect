<?php

namespace App\Controller\Front\Auth;

use App\Entity\User;
use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Front\Auth\Register\UserRegisterType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/authentification/inscription', name: 'register_user', methods: ['GET', 'POST'])]
    public function register(Security $security, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);

        $form->handleRequest($request);

        $successMessage = null;
        $errorMessage = null;
        

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user->setRoles(['ROLE_USER']);

                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                );
                $user->setPassword($hashedPassword);

                $entityManager->persist($user);
                $entityManager->flush();

                $successMessage = $this->translator->trans('success_message_register_user', [], 'validators');
            } catch (UniqueConstraintViolationException $e) {
                // Gérer l'exception de contrainte d'unicité (doublon d'e-mail)
                $errorMessage = $this->findTranslation('email_already_used_message');

                // Utilisez un message d'erreur par défaut si la clé n'est pas trouvée
                if ($errorMessage === null) {
                    $errorMessage = $this->findTranslation('error_generic_message');
                }
            } catch (\Exception $e) {
                // Gérer d'autres exceptions, si nécessaire
                $errorMessage = $this->findTranslation('error_generic_message');
            }
            
        }

        return $this->render('/front/auth/register/user.html.twig', [
            'form' => $form->createView(),
            'successMessage' => $successMessage,
            'errorMessage' => $errorMessage,
        ]);
    }

    private function findTranslation(string $key): ?string
    {
        // Chemin vers le fichier de traduction YAML
        $yamlFilePath = $this->getParameter('kernel.project_dir') . '/translations/validators.fr.yaml';

        // Charger le fichier YAML
        $yamlContent = file_get_contents($yamlFilePath);
        $translations = Yaml::parse($yamlContent);

        // Recherche de la clé dans le tableau multidimensionnel
        $result = $this->searchKeyInArray($key, $translations);

        return $result;
    }

    private function searchKeyInArray(string $key, array $array): ?string
    {
        foreach ($array as $k => $v) {
            if ($k === $key) {
                return $v;
            } elseif (is_array($v)) {
                $result = $this->searchKeyInArray($key, $v);
                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    }
}
