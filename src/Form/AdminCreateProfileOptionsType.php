<?php

namespace App\Form;

use App\Entity\ProfileOptions;
use App\Entity\User;
use App\myPHPClasses\FormUserManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AdminCreateProfileOptionsType extends AbstractType
{
    private $manager;
    public function __construct(FormUserManager $manager)
    {
        $this->manager = $manager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('PublicContact')
            ->add('ShowStatus')
            ->add('Hidden')
            ->add('Darkmode')
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choices' => $this->manager->getAllUsersWithoutProfOptions()
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfileOptions::class,
        ]);
    }
}
