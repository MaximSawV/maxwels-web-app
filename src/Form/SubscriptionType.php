<?php

namespace App\Form;

use App\Entity\Subscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'John'

                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Doe'
                ]
            ])
            ->add('email')
            ->add('donation',RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100
                ]
            ])
            ->add('donationInterval', ChoiceType::class, [
                'choices' => [
                    'Onetime' => 'O',
                    'Monethly' => 'M',
                    'Yearly' => 'Y',
                ],
            ])
            ->add('formOfDonation', TextType::class, [
                'attr' => [
                    'placeholder'
                ]
            ])

            ->add('Subscibe', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscriber::class,
        ]);
    }
}
