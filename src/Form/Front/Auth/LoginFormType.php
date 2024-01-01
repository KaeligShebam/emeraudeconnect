<?php
// src/Form/LoginType.php
namespace App\Form\Front\Auth;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-input',
                    'name' => '_email'
                ]
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('_remember_me', CheckboxType::class, [
                'label' => 'Remember Me', 'required' => false,
                'attr' => [
                    'class' => 'form-input'
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Login',                
            'attr' => [
                'class' => 'form-button'
            ]]);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'auth_provider' => 'app_user_provider', // Valeur par défaut
        ]);
    }
}
