<?php

namespace App\Form;

use App\DataTransferObject\UserPaymentDto;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

class UserPaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ccNumber', TextType::class, array(
                'required' => true,
                'constraints' => array(
                    new Assert\CardScheme(array(
                        'schemes' => array('VISA', 'MASTERCARD', 'DISCOVER'),
                        'message' => 'The credit card number you entered is invalid.')
                        )),
                'empty_data' => null
           ))
            ->add('cvv', TextType::class, array(
                'required' => true,
                'constraints' => array(
                    new Length(array('min' => 3)),
                     new Length(array('max' => 3))),
                     'empty_data' => null
            ))
            ->add('expirationDate',
            null,array('required' => true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserPaymentDto::class,
        ]);
    }
}
