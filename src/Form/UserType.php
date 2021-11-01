<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname', TextType::class, [
            'attr' => [
                'class' => 'form-control'
        ],
        ])
        ->add('firstname', TextType::class, [
            'attr' => [
                'class' => 'form-control'
        ],
        ])
        ->add('address', TextType::class, [
            'attr' => [
                'class' => 'form-control'
        ],
        ])
        ->add('phone', TextType::class, [
            'attr' => [
                'class' => 'form-control'
        ],
        ])
        ->add('register', SubmitType::class, [
            'attr' => [
                'class' => 'mt-1 btn-danger'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
