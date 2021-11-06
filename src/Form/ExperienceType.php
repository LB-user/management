<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Company;
use App\Entity\Experience;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ExperienceType extends AbstractType
{
    protected $auth;

    public function __construct(AuthorizationCheckerInterface $auth) {
        $this->auth = $auth;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($this->auth->isGranted('ROLE_SUPER_ADMIN')) {
        $builder
            ->add('user', EntityType::class, [
                    'class' => User::class,
                    'expanded' => false,
                    'multiple' => false,
                    'choice_label' => 'lastname',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')                 
                        ->orderBy('u.lastname', 'ASC');
                    }
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')                 
                    ->orderBy('u.name', 'ASC');
                }
        ])
            ->add('start_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
                'date_widget' =>'single_text',
            ))
            ->add('end_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
                'date_widget' =>'single_text',
                'required' => false,
            ))
            ->add('details')
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-2 btn-danger'
                ]
            ]);
        ;} else {
            $builder
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')                 
                    ->orderBy('u.name', 'ASC');
                }
        ])
            ->add('start_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
                'date_widget' =>'single_text',
            ))
            ->add('end_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
                'date_widget' =>'single_text',
                'required' => false,
            ))
            ->add('details')
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-2 btn-danger'
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
