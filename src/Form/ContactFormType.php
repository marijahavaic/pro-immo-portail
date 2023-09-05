<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

//Create contact form for the home page
class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Votre nom'], 'label' => 'Quel est votre nom ?',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre nom doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],

            ])
            ->add('Prenom', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Votre prenom'], 'label' => 'Quel est votre prénom ?',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre prénom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre prénom doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])

            ->add('Email', EmailType::class, [
                'label' => 'Saisissez votre adresse email',
                'attr' => ['placeholder' => 'Votre email'],
                'constraints' => [
                    new Email([
                        'message' => 'Veuillez saisir une adresse email valide'
                    ])
                ]
            ])
            ->add('Telephone', TelType::class, [
                'label' => 'Avez-vous un numéro de téléphone ?',
                'attr' => ['placeholder' => 'Votre numéro de téléphone'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/[+]{1}[3]{2}[1-7]{1}[0-9]{8}/',
                        'message' => 'Veuillez saisir un numéro de téléphone valide commençant par +33'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre numéro de téléphone doit contenir au moins {{ limit }} caractères',
                        'max' => 15,
                        'maxMessage' => 'Votre numéro de téléphone doit contenir au maximum {{ limit }} caractères',
                    ]),
                ]
            ])

            ->add('Message', TextareaType::class, [
                'label' => 'Rédigez votre message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'écrire un message',
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Votre message doit contenir au moins {{ limit }} caractères',
                        'max' => 2000,
                        'maxMessage' => 'Votre message doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success rounded-pill']
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
