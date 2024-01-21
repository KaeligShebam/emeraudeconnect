<?php

namespace App\Form\Back\Page;

use App\Entity\Page;
use App\Entity\PageStatus;
use Symfony\Component\Yaml\Yaml;
use App\Form\Back\Page\SeoPageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EditPageType extends AbstractType
{
    private $kernel;
    private $translator;

    // Inject the KernelInterface in the constructor
    public function __construct(TranslatorInterface $translator, KernelInterface $kernel)
    {
        $this->translator = $translator;
        $this->kernel = $kernel;
    }

    private function findTranslation(string $key): ?string
    {
        // Chemin vers le fichier de traduction YAML
        $yamlFilePath = $this->getKernelProjectDir() . '/translations/validators.fr.yaml';

        // Charger le fichier YAML
        $yamlContent = file_get_contents($yamlFilePath);
        $translations = Yaml::parse($yamlContent);

        // Recherche de la clé dans le tableau multidimensionnel
        $result = $this->searchKeyInArray($key, $translations);

        return $result;
    }

    private function getKernelProjectDir(): string
    {
        // Use the KernelInterface to get the project directory
        return $this->kernel->getProjectDir();
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
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $buttonLabel = $this->findTranslation('btn_modify_page');
    
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-input', 'placeholder' => 'Titre de la page']
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'ckeditor form-input mt-2 tinymce']
            ])
            ->add('status', EntityType::class, [
                'class' => PageStatus::class,
                'label' => 'Statut de la page',
                'choice_label' => 'name',
                'attr' => ['class' => 'form-input mt-2'],
                'label_attr' => [ 'class' => 'mt-2 pagelabel']
            ])
            ->add('seo', SeoPageType::class, [
                'label' => false, // You can customize this label as needed
                
            ])
            ->add('submit', SubmitType::class, [
                'label' => $buttonLabel,
                'attr' => ['class' => 'form-button mt-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }

}
