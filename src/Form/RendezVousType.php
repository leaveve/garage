<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motif', ChoiceType::class, [
                'label' => 'Motif du rendez-vous',
                'choices' => $options['motifs'],
            ])
            ->add('dateHeure', DateTimeType::class, [
                'label' => 'Date et heure souhaitées',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('dateDebutLocation', DateType::class, [
                'label' => 'Début de la location',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])
            ->add('dateFinLocation', DateType::class, [
                'label' => 'Fin de la location',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message (facultatif)',
                'required' => false,
                'attr' => ['rows' => 4],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
            'motifs' => [],
        ]);
    }
}