<?php

namespace App\Form;

use App\Entity\Property;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                    'placeholder' => 'Entrez titre', 'class' => 'mb-3 form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre prénom',
                    ]),
                ],
        ])
            ->add('Description', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez description',
                    'rows' => 10,
                    'class' => 'mb-3 form-control'
                ],
                'label' => 'Rédigez votre message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'écrire un message',
                    ]),
                    new Length([
                        'min' => 100,
                        'minMessage' => 'Votre message doit contenir au moins {{ limit }} caractères',
                        'max' => 2000,
                        'maxMessage' => 'Votre message doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('Type', ChoiceType::class,[
                'required' => true,
                'choices' => [
                    'Choisir...' => null,
                    'Maison' => 'maison',
                    'Appartement' => 'appartement',
                    'Château' => 'castle'

                ],
                'attr' => [ 'placeholder' => 'Entrez prix', 'class' => 'mb-3 form-control'
            ],
            ])
            ->add('Price', MoneyType::class, [
                'required' => true,
                'divisor' => 1,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'écrire valide prix',
                    ]),
                ],
                'label' => 'Prix',
                'attr' => ['class' => 'mb-3 form-control', ]
            ])
            ->add('Surface', NumberType::class, [
                'required' => true,
                'label' => 'Surface',
                'attr' => [
                    'placeholder' => 'Entrez surface', 'class' => 'mb-3 form-control'
                ],
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'label' => 'Address',
                'attr' => [
                    'placeholder' => 'Entrez address', 'class' => 'mb-3 form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez address',
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
                        'message' => 'Entrez ville',
                    ]),
                ],
        ])
            ->add('PostalCode', NumberType::class, [
                'required' => true,
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => 'Entrez code postal', 'class' => 'mb-3 form-control'
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
            ->add('createdAt', DateType::class, [
                'label' => 'Créée',
                'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                'attr' => [
                    'class' => 'mb-3'
                ]
            ])
            // TODO montre pour edit
            // ->add('updatedAt', DateType::class, [
            //     'label' => 'Modifié',
            //     'placeholder' => [
            //     'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
            //     ],
            //     'attr' => [
            //         'class' => 'mb-3'
            //     ]
            // ])
            ->add('button', SubmitType::class, [
                'label' => 'Créer ma annonce',
                'attr' => [
                    'class' => 'mb-3 btn btn-primary'
                ]
            ])
            // ->add('favorite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
