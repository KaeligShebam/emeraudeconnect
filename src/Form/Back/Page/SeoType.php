<?php
// src/Form/Back/Page/SeoType.php

namespace App\Form\Back\Page;

use App\Entity\PageSeo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SeoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('metaTitle', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-input', 'placeholder' => 'Meta titre']
            ])
            ->add('metaDescription', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-input', 'placeholder' => 'Meta description']
            ])
            ->add('indexation', ChoiceType::class, [
                'label' => 'Indexer la page', // Customize label as needed
                'required' => true, // Set to true if the indexAction should be required
                'choices' => [
                    'Oui' => 'oui',
                    'Non' => 'non',
                ],
                'expanded' => true, // Render as checkboxes
                'multiple' => false, // Allow only one option to be selected
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageSeo::class,
        ]);
    }
}
