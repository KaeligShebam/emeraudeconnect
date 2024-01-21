<?php
// src/Form/Back/Page/SeoType.php

namespace App\Form\Back\Page;

use App\Entity\PageSeo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SeoPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('metaTitle', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-input mt-2', 'placeholder' => 'Meta titre'],
                'required' => true,
                'constraints' => [
                    new Length([
                        'max' => 60,
                    ]),
                ],
            ])
            ->add('metaDescription', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-input', 'placeholder' => 'Meta description'],
                'required' => true,
                'constraints' => [
                    new Length([
                        'max' => 120,
                    ]),
                ],
            ])
            ->add('indexation', ChoiceType::class, [
                'label' => 'Indexer la page',
                'label_attr' => ['class' => 'pagelabel'],
                'required' => true,
                'attr' => ['class' => 'indexation'],
                'choices' => [
                    'Oui' => '1',
                    'Non' => '0',
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
