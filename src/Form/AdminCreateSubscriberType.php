<?php

namespace App\Form;

use App\Entity\Subscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminCreateSubscriberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email', EmailType::class)
            ->add('Donation', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ]
            ])
            ->add('donation_interval')
            ->add('form_of_donation')
            ->add('active')
            ->add('first_donation', DateType::class, [
                'data'   => new \DateTime(),
                'attr'   => [
                    'min' => ( new \DateTime() )->format('Y-m-d'),
                ],
                'widget' => 'single_text'
            ])
            ->add('last_donation', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('number_of_donations', IntegerType::class, [
                'attr' => [
                    'min' => 0
                ]
            ])
            ->add('user')
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscriber::class,
        ]);
    }
}
