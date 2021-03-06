<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', RepeatedType::class, [
            'attr' => ['class' => 'w-50 form-control'],
            'type' => PasswordType::class,
            'invalid_message' => 'Le mot de passe et sa confirmation ne corresponde pas',
            'first_options'  => [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'w-50 form-control']
            ],
            'second_options' => [
                'label' => 'Confirmation de mot de passe',
                'attr' => ['class' => 'w-50 form-control']
            ]
        ])
        ->add('register', SubmitType::class, [
            'attr' => [
                'class' => 'mt-2 btn-danger'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
