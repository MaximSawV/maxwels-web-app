<?php

namespace App\Form;

use App\Entity\Chat;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateChatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('group_checkbox', CheckboxType::class, [
                'label' => 'Group chat'
            ])
            ->add('user1', EntityType::class, [
                'class' => User::class,
                'required' => true,
                'label' => 'First User',
            ])
            ->add('user1', EntityType::class, [
                'class' => User::class,
                'required' => true,
                'label' => 'Second User',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
