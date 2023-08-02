<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // supprime email quand fini le test 
            ->add('email', EmailType::class)
            ->add('job', TextType::class,[
                'label' => 'Votre métier',
                'attr' =>[
                    'class'=>'form-control mb-3',
                ]
            ])
            ->add('bio', TextareaType::class,[
                'label' => 'Votre bio',
                'attr' =>[
                    'class'=>'form-control mb-3',
                ]
            ])
            ->add('town', TextType::class,[
                'label' => 'Votre town',
                'attr' =>[
                    'class'=>'form-control mb-3',
                ]
            ])
            ->add('country', TextType::class,[
                'label' => 'Votre country',
                'attr' =>[
                    'class'=>'form-control mb-3',
                ]
            ])
            ->add('Enregistrer', SubmitType::class,[
                'attr' =>[
                    'class'=>'btn btn-dark mb-3',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
