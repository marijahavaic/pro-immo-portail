<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // form to reset password
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['autocomplete' => 'email', 'placeholder' => 'Entrez votre adresse email', 'class' => 'mb-3 form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Saisissez votre e-mail',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
