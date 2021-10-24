<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Skill;
use App\Form\SkillType;
use App\Entity\UserSkill;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserSkillType extends SkillType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user_id', EntityType::class, [
                'class' => User::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'lastname',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')                 
                    ->orderBy('u.lastname', 'ASC');
                }
            ])
            ->add('skill_id', EntityType::class, [
                'class' => Skill::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')                 
                    ->orderBy('s.name', 'ASC');
                }
            ])
            ->add('liked', ChoiceType::class, array(
                'choices'  => array(
                    'Aime' => 1,
                    'N\'aime pas' => 0
                )
            ))
            ->add('level', ChoiceType::class, [
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
                'choices'  => array(
                    'Mauvais' => 0,
                    'Débutant' => 1,
                    'Normal' => 2,
                    'Bon' => 3,
                    'Très bon' => 4,
                    'Expert' => 5,
                )
                ,
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
