<?php

namespace App\Form;

use App\Entity\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditRequestType extends AbstractType
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction($this->request->getMainRequest()->getBaseUrl())
            ->add('Status', TextType::class)
            ->add('Deadline', DateType::class,
                ['data'   => new \DateTime(),
                    'attr'   => [
                        'min' => ( new \DateTime() )->format('Y-m-d'),
                    ],
                    'widget' => 'single_text'
                ])
            ->add('Context')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
