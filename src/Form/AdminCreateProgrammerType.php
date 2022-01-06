<?php

namespace App\Form;

use App\Entity\Programmer;
use App\Entity\User;
use App\myPHPClasses\FormUserManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AdminCreateProgrammerType extends AbstractType
{
    private $manager;

    public function __construct(FormUserManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Done_Requests', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('Rating', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 4,
                ]
            ])
            ->add('user', EntityType::class, [
        'class' => User::class,
        'choices' => $this->manager->getAllNotCustomerUser()
    ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programmer::class,
        ]);
    }
}
