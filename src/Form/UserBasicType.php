<?php

namespace App\Form;

use App\DataTransferObject\UserBasicDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class UserBasicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
            ->add('phoneNumber', TelType::class,[
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\+?[0-9]{10,14}$/',
                        'message' => 'Please enter a valid phone number',
                    ])
                ],
                ])
            ->add('subscriptionType',
                ChoiceType::class, 
                    [
                        'choices' => [
                            'Basic' => '1',
                            'Premium' => '2',
                        ],
                    'expanded' => true
                    ]
                );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserBasicDto::class,
        ]);
    }
}
