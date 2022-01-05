<?php

namespace App\Form;

use App\Entity\UserRelationship;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCreateRelationshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isFriend')
            ->add('isBlocked')
            ->add('priority')
            ->add('referingUser')
            ->add('referencedUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRelationship::class,
        ]);
    }
}
