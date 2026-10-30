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
use App\Repository\RendezVousRepository;

#[Route('/mon-compte/rendez-vous')]
final class RendezVousController extends AbstractController
{
    #[Route('', name: 'app_rendez_vous_index')]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
         // Seulement les rendez-vous du client connecté, les plus récents d'abord
            $rendezVous = $rendezVousRepository->findBy(
            ['client' => $this->getUser()],
            ['dateCreation' => 'DESC']
            );

        return $this->render('rendez_vous/index.html.twig', [
        'rendezVous' => $rendezVous,
        ]);
    }


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
                return $this->redirectToRoute('app_rendez_vous_index');
            }
        }

        return $this->render('rendez_vous/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/annuler', name: 'app_rendez_vous_annuler', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function annuler(RendezVous $rdv, Request $request, EntityManagerInterface $em): Response
    {
        // Un client ne peut annuler que SES rendez-vous
        if ($rdv->getClient() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // Vérification du jeton CSRF 
        if (!$this->isCsrfTokenValid('annuler' . $rdv->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('danger', 'Action non autorisée.');
            return $this->redirectToRoute('app_rendez_vous_index');
        }

        // On ne peut annuler qu'une demande encore en attente
        if ($rdv->getStatut() !== 'en_attente') {
            $this->addFlash('warning', 'Ce rendez-vous ne peut plus être annulé.');
            return $this->redirectToRoute('app_rendez_vous_index');
        }

        $rdv->setStatut('annule');
        $em->flush();

        $this->addFlash('success', 'Votre demande de rendez-vous a été annulée.');
        return $this->redirectToRoute('app_rendez_vous_index');
    }
}