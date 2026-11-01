<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangementMotDePasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ancienMotDePasse', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'constraints' => [
                    new UserPassword(message: 'Le mot de passe actuel est incorrect.'),
                ],
            ])
            ->add('nouveauMotDePasse', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmer le nouveau mot de passe'],
                'invalid_message' => 'Les deux mots de passe ne correspondent pas.',
                'constraints' => [
                    new NotBlank(message: 'Choisissez un mot de passe.'),
                    new Length(min: 8, minMessage: 'Le mot de passe doit faire au moins {{ limit }} caractères.'),
                ],
            ]);
    }
}
