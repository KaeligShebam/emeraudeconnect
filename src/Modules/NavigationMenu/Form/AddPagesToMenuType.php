<?php

namespace App\Modules\NavigationMenu\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use App\Modules\NavigationMenu\Entity\NavigationMenu;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddPagesToMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pages', EntityType::class, [
            'label' => false,
            'class' => Page::class,
            'choice_label' => 'title', // Remplacez 'title' par le champ approprié de votre entité Page
            'multiple' => true,
            'expanded' => true,
            'attr' => ['class' => 'page-list']
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Enregistrer',
            'attr' => ['class' => 'form-button mt-2']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NavigationMenu::class,
        ]);
    }
}
