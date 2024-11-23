<?php

namespace App\Form;

use App\DataTransferObject\UserAddressDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address1')
            ->add('address2',
                null, array(
                    'required' => false
                ))
            ->add('city')
            ->add('postalCode')
            ->add('state')
            ->add('country',
                CountryType::class, array(
                    "label" => "Country",
                    "required" => true,
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAddressDto::class,
        ]);
    }
}
