<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password', RepeatedType::class, [
                'attr' => ['class' => 'w-50 form-control'],
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et sa confirmation ne corresponde pas',
                'first_options'  => [
                    'label' => 'Password',
                    'attr' => ['class' => 'w-50 form-control']
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'attr' => ['class' => 'w-50 form-control']
                ]
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('address')
            ->add('phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
