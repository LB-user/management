<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname', TextType::class, [
            'attr' => ['class' => 'w-50 form-control'],
        ])
        ->add('firstname', TextType::class, [
            'attr' => ['class' => 'w-50 form-control'],
        ])
        ->add('email', EmailType::class, [
            'attr' => ['class' => 'w-50 form-control'],
        ])
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
        ->add('register', SubmitType::class, [
            'attr' => ['class' => 'mt-2 btn-danger']
        ])
        ->add('address', TextType::class, [
            'attr' => ['class' => 'w-50 form-control'],
        ])
        ->add('phone', TextType::class, [
            'attr' => ['class' => 'w-50 form-control'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
