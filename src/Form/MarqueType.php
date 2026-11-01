<?php

namespace App\Form;

use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Nom de la marque',
            ])
            ->add('logoFichier', FileType::class, [
                'label' => 'Logo',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'image/png,image/jpeg,image/webp,image/svg+xml'],
                'constraints' => [
                    new File(
                        maxSize: '2M',
                        mimeTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                        mimeTypesMessage: 'Le logo doit être une image PNG, JPG, WEBP ou SVG de 2 Mo maximum.',
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marque::class,
        ]);
    }
}
