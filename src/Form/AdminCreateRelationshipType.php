<?php

namespace App\Form;

use App\Entity\UserRelationship;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCreateRelationshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isFriend')
            ->add('isBlocked')
            ->add('priority', IntegerType::class, [
                    'attr' => [
                        'min' => 0,
                        'max' => 4,
                    ]
                ])
            ->add('referingUser')
            ->add('referencedUser')
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRelationship::class,
        ]);
    }
}
