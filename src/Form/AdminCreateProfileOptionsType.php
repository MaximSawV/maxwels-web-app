<?php

namespace App\Form;

use App\Entity\ProfileOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCreateProfileOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('PublicContact')
            ->add('ShowStatus')
            ->add('Hidden')
            ->add('Darkmode')
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfileOptions::class,
        ]);
    }
}
