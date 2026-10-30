<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Entity\Voiture;
use App\Form\RendezVousType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mon-compte/rendez-vous')]
final class RendezVousController extends AbstractController
{
    #[Route('/nouveau/{id}', name: 'app_rendez_vous_new', requirements: ['id' => '\d+'])]
    public function new(Voiture $voiture, Request $request, EntityManagerInterface $em): Response
    {
        // On ne peut pas demander un rendez-vous pour une voiture plus disponible
        if ($voiture->getStatut() !== 'disponible') {
            $this->addFlash('warning', 'Cette voiture n\'est plus disponible.');
            return $this->redirectToRoute('app_voiture_show', ['id' => $voiture->getId()]);
        }

        // Les motifs possibles dépendent de la voiture
        $motifs = ['Essai' => 'essai'];
        if ($voiture->isAVendre()) {
            $motifs['Achat'] = 'achat';
        }
        if ($voiture->isALouer()) {
            $motifs['Location'] = 'location';
        }

        $rdv = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rdv, ['motifs' => $motifs]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Les dates de location sont obligatoires seulement pour une location
            if ($rdv->getMotif() === 'location' && (!$rdv->getDateDebutLocation() || !$rdv->getDateFinLocation())) {
                $this->addFlash('danger', 'Indiquez les dates de début et de fin de location.');
            } else {
                // Si ce n'est pas une location, on vide les dates de location
                if ($rdv->getMotif() !== 'location') {
                    $rdv->setDateDebutLocation(null)->setDateFinLocation(null);
                }

                // Les champs que le client ne choisit pas
                $rdv->setClient($this->getUser())
                    ->setVoiture($voiture)
                    ->setStatut('en_attente')
                    ->setDateCreation(new \DateTimeImmutable());

                $em->persist($rdv);
                $em->flush();

                $this->addFlash('success', 'Votre demande de rendez-vous a bien été envoyée. Le garage vous recontactera.');
                return $this->redirectToRoute('app_voiture_show', ['id' => $voiture->getId()]);
            }
        }

        return $this->render('rendez_vous/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }
}