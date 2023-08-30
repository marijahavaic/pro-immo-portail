<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Description')
            ->add('Type')
            ->add('Price')
            ->add('Surface')
            ->add('address')
            ->add('Town')
            ->add('PostalCode')
            ->add('Country')
            ->add('Photo')
            ->add('isRent')
            ->add('isOnSale')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('favorite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
