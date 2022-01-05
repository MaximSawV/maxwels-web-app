<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('isVerified')
            ->add('Subscribed')
            ->add('customer_or_programmer', ChoiceType::class, [
                'choices' => [
                    'Customer' => 'customer',
                    'Programmer' => 'programmer',
                    'Both' => 'both'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Online' => 'online',
                    'Offline' => 'offline',
                    'Busy' => 'Busy',

                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
