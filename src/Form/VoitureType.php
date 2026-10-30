<?php

namespace App\Form;

use App\Entity\Carburant;
use App\Entity\Modele;
use App\Entity\Transmission;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\Marque;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // La voiture
                        ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisir une marque',
                // Ce champ n'existe pas dans Voiture : il sert juste à filtrer les modèles
                'mapped' => false,
                // En modification, on pré-sélectionne la marque du modèle actuel
                'data' => $options['data']?->getModele()?->getMarque(),
            ])
            ->add('modele', EntityType::class, [
                'class' => Modele::class,
                'label' => 'Modèle',
                'choice_label' => 'libelle',
                'placeholder' => 'Choisir un modèle',
            ])
            
            ->add('annee', IntegerType::class, ['label' => 'Année'])
            ->add('kilometrage', IntegerType::class, ['label' => 'Kilométrage (km)'])
            ->add('puissanceCh', IntegerType::class, ['label' => 'Puissance (ch)'])
            ->add('transmission', EntityType::class, [
                'class' => Transmission::class,
                'choice_label' => 'libelle',
            ])
            ->add('carburant', EntityType::class, [
                'class' => Carburant::class,
                'choice_label' => 'libelle',
            ])
            ->add('couleur', TextType::class, ['label' => 'Nom de la couleur'])
            ->add('couleurHex', ColorType::class, [
                'label' => 'Couleur exacte',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => ['rows' => 5],
            ])

            // Vente / location
            ->add('aVendre', CheckboxType::class, [
                'label' => 'À vendre',
                'required' => false,
            ])
            ->add('prixVente', IntegerType::class, [
                'label' => 'Prix de vente (€)',
                'required' => false,
            ])
            ->add('aLouer', CheckboxType::class, [
                'label' => 'À louer',
                'required' => false,
            ])
            ->add('prixLocationJour', IntegerType::class, [
                'label' => 'Prix de location par jour (€)',
                'required' => false,
            ])
            ->add('caution', IntegerType::class, [
                'label' => 'Caution (€)',
                'required' => false,
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Disponible' => 'disponible',
                    'Louée' => 'louee',
                    'Vendue' => 'vendue',
                ],
            ])

            // Photos (gérées à la main dans le contrôleur)
            ->add('nouvellesPhotos', FileType::class, [
                'label' => 'Ajouter des photos',
                'mapped' => false,      // ce n'est pas un champ de Voiture
                'required' => false,
                'multiple' => true,     // plusieurs fichiers d'un coup
                'attr' => ['accept' => 'image/*'],
                'constraints' => [
                    new All(constraints: [
                        new File(
                            maxSize: '5M',
                            mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                            mimeTypesMessage: 'Seules les images JPG, PNG ou WEBP sont acceptées.',
                        ),
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}