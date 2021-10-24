<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company')
            ->add('start_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
            ))
            ->add('end_at', DateTimeType::class, array(
                'input' => 'datetime_immutable',
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
