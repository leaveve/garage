<?php

namespace App\Controller\Gestion;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/gestion/voiture')]
final class VoitureController extends AbstractController
{
    #[Route(name: 'app_gestion_voiture_index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('gestion/voiture/index.html.twig', [
            'voitures' => $voitureRepository->findBy([], ['id' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_gestion_voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('app_gestion_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gestion/voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gestion_voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('gestion/voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gestion_voiture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gestion_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gestion/voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gestion_voiture_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $voiture->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('danger', 'Action non autorisée.');
            return $this->redirectToRoute('app_gestion_voiture_index');
        }

        // On compte les rendez-vous encore en cours
        $rdvEnCours = $voiture->getRendezVouses()->filter(
            fn ($rdv) => in_array($rdv->getStatut(), ['en_attente', 'accepte'], true)
        );

        if (count($rdvEnCours) > 0) {
            $this->addFlash('warning', sprintf(
                'Impossible de supprimer cette voiture : elle a %d rendez-vous en cours. Traitez-les d\'abord dans la gestion des rendez-vous.',
                count($rdvEnCours)
            ));
            return $this->redirectToRoute('app_gestion_voiture_edit', ['id' => $voiture->getId()]);
        }

        // Tous les rendez-vous sont traités
        foreach ($voiture->getRendezVouses() as $rdv) {
            $entityManager->remove($rdv);
        }

        // Les photos sont supprimées automatiquement grâce à orphanRemoval
        $entityManager->remove($voiture);
        $entityManager->flush();

        $this->addFlash('success', 'La voiture a été supprimée.');
        return $this->redirectToRoute('app_gestion_voiture_index');
    }
}
