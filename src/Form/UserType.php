<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Skill;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname', TextType::class, [
            'attr' => [
                'class' => 'w-50 form-control'
            ],
        ])
        ->add('firstname', TextType::class, [
            'attr' => [
                'class' => 'w-50 form-control'
        ],
        ])
        ->add('address', TextType::class, [
            'attr' => [
                'class' => 'w-50 form-control'
        ],
        ])
        ->add('phone', TextType::class, [
            'attr' => [
                'class' => 'w-50 form-control'
        ],
        ])
        ->add('register', SubmitType::class, [
            'attr' => [
                'class' => 'mt-2 btn-danger'
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
