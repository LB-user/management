<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Skill;
use App\Form\UserSkillType;
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
