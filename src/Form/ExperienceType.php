<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Experience;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ->add('company')
            ->add('start_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
                'date_widget' =>'single_text',
            ))
            ->add('end_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
                'date_widget' =>'single_text',
            ))
            ->add('details')
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
            'data_class' => Experience::class,
        ]);
    }
}
