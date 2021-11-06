<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Company;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddressType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nb_road', TextType::class, [
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
            ])
            ->add('road', TextType::class, [
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
            ])
            ->add('cp', TextType::class, [
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'w-50 form-control'
                ],
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
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
            'data_class' => Address::class,
        ]);
    }
}
