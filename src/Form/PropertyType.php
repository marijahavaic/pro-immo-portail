<?php

namespace App\Form;

use App\Entity\Property;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'required' => true,
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Entrez un titre', 'class' => 'mb-3 form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un titre',
                    ]),
                ],
        ])
            ->add('Description', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez une description',
                    'rows' => 10,
                    'class' => 'mb-3 form-control'
                ],
                'label' => 'Rédigez votre message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'écrire une description',
                    ]),
                    new Length([
                        'min' => 100,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères',
                        'max' => 2000,
                        'maxMessage' => 'La description doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('Type', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Choisir...' => null,
                    'Maison' => 'house',
                    'Appartement' => 'appartment',
                    'Château' => 'castle'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Merci de choisir le type de bien immobilier.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Sélectionnez le type de bien immobilier', // Update the placeholder text
                    'class' => 'mb-3 form-control'
                ],
            ])
            ->add('Price', MoneyType::class, [
                'required' => true,
                'divisor' => 1,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un montant valide.',
                    ]),
                ],
                'label' => 'Prix',
                'attr' => ['class' => 'form-control', ]
            ])
            ->add('Surface', NumberType::class, [
                'required' => true,
                'label' => 'Surface',
                'attr' => [
                    'placeholder' => 'Entrez une surface', 'class' => 'mb-3 form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une surface valide.',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'label' => 'Addresse',
                'attr' => [
                    'placeholder' => 'Entrez une adresse', 'class' => 'mb-3 form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse',
                    ]),
                ],
        ])
            ->add('Town', TextType::class, [
                'required' => true,
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Entrez ville', 'class' => 'mb-3 form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une ville',
                    ]),
                ],
        ])
            ->add('PostalCode', NumberType::class, [
                'required' => true,
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => 'Entrez un code postal', 'class' => 'mb-3 form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un code postal valide.',
                    ]),
                ],
            ])
            ->add('Country',CountryType::class, [
                'required' => true,
                'label' => 'Pays',
                'attr' => [
                    'class' => 'mb-3 form-control'
                ],
        ])
            ->add('Photo', FileType::class, array(
                    'required' => false,
                    'mapped' => false,
                    'required' => false,
                ))
            ->add('isRent', CheckboxType::class, [
            'label' => 'Vous souhaitez mettre votre bien en location ?',
            'required' => false,
        ])
            // ->add('isRent', CheckboxType::class, [
            //         'label' => 'Au loyer',
            //         'attr' => [
            //         'class' => 'form-check-input'
            //     ],
            //     ])
            // ->add('isOnSale', CheckboxType::class, [
            //         'label' => 'En vent',
            //         'attr' => [
            //         'class' => 'form-check-input'
            //     ],
            //     ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
