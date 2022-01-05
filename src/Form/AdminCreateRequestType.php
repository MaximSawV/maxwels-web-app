<?php

namespace App\Form;

use App\Entity\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCreateRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Status')
            ->add('Created_on', DateType::class, [
                'data'   => new \DateTime(),
                    'attr'   => [
                        'min' => ( new \DateTime() )->format('Y-m-d'),
                    ],
                    'widget' => 'single_text'
                ])
            ->add('Deadline', DateType::class,
                ['data'   => new \DateTime(),
                'attr'   => [
                    'min' => ( new \DateTime() )->format('Y-m-d'),
                ],
                'widget' => 'single_text'
            ])
            ->add('Context')
            ->add('Vote')
            ->add('Created_by')
            ->add('Working_on')
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
