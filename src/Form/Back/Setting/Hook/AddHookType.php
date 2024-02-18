<?php

namespace App\Form\Back\Setting\Hook;

use App\Entity\Hook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddHookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-input', 'placeholder' => 'Nom du hook']
        ])
        ->add('description', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-input', 'placeholder' => 'Description du hook']
        ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'form-button mt-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hook::class,
        ]);
    }
}
