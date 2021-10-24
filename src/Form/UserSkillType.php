<?php

namespace App\Form;

use App\Entity\UserSkill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSkillType extends SkillType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('liked')
            ->add('user_id')
            ->add('skill_id')
                        ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
            ])
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-2 btn-danger'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSkill::class,
        ]);
    }
}
