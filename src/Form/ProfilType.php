<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'empty_data' => '',
                'constraints' => [new NotBlank(message: 'Indiquez votre prénom.')],
            ])
            ->add('nom', TextType::class, [
                'empty_data' => '',
                'constraints' => [new NotBlank(message: 'Indiquez votre nom.')],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('adresse', TextType::class, ['required' => false])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
            ])
            ->add('ville', TextType::class, ['required' => false])
            ->add('datePermis', DateType::class, [
                'label' => 'Date d\'obtention du permis',
                'widget' => 'single_text',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
