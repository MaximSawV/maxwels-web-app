<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\User;
use App\myPHPClasses\FormUserManager;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CreateCustomerType extends AbstractType
{
    private $manager;

    public function __construct(FormUserManager $manager)
    {
        $this->manager = $manager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number_of_requests')
            ->add('user_id', EntityType::class, [
                'class' => User::class,
                'choices' => $this->manager->getAllNotCustomerUser()
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
