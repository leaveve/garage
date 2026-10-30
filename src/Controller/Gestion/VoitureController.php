<?php

namespace App\Controller\Gestion;

use App\Entity\Photo;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Marque;

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
            $this->ajouterPhotos($form, $voiture, $entityManager);
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
            $this->ajouterPhotos($form, $voiture, $entityManager);
            $entityManager->flush();

            return $this->redirectToRoute('app_gestion_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gestion/voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/modeles/{id}', name: 'app_gestion_voiture_modeles', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function modelesParMarque(Marque $marque): Response
    {
        $modeles = [];
        foreach ($marque->getModeles() as $modele) {
            $modeles[] = [
                'id' => $modele->getId(),
                'libelle' => $modele->getLibelle(),
            ];
        }

        return $this->json($modeles);
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

    #[Route('/photo/{id}/supprimer', name: 'app_gestion_photo_supprimer', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function supprimerPhoto(Photo $photo, Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = $photo->getVoiture();

        if ($this->isCsrfTokenValid('photo' . $photo->getId(), $request->getPayload()->getString('_token'))) {
            // On supprime le fichier, sauf les images de démo qui servent à plusieurs voitures
            $chemin = $this->getParameter('kernel.project_dir') . '/public/uploads/voitures/' . $photo->getNomFichier();
            if (!str_starts_with($photo->getNomFichier(), 'demo-') && file_exists($chemin)) {
                unlink($chemin);
            }

            $voiture->removePhoto($photo); // orphanRemoval supprime la photo en base

            // On renumérote les photos restantes : 1, 2, 3...
            $ordre = 1;
            foreach ($voiture->getPhotos() as $autre) {
                $autre->setOrdre($ordre++);
            }

            $entityManager->flush();
            $this->addFlash('success', 'La photo a été supprimée.');
        }

        return $this->redirectToRoute('app_gestion_voiture_edit', ['id' => $voiture->getId()]);
    }

    #[Route('/photo/{id}/principale', name: 'app_gestion_photo_principale', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function photoPrincipale(Photo $photo, Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = $photo->getVoiture();

        if ($this->isCsrfTokenValid('photo' . $photo->getId(), $request->getPayload()->getString('_token'))) {
            // La photo choisie passe en 1, les autres suivent
            $photo->setOrdre(1);
            $ordre = 2;
            foreach ($voiture->getPhotos() as $autre) {
                if ($autre !== $photo) {
                    $autre->setOrdre($ordre++);
                }
            }

            $entityManager->flush();
            $this->addFlash('success', 'La photo principale a été changée.');
        }

        return $this->redirectToRoute('app_gestion_voiture_edit', ['id' => $voiture->getId()]);
    }

    // Enregistre les fichiers envoyés dans public/uploads/voitures et crée les Photo
    private function ajouterPhotos(FormInterface $form, Voiture $voiture, EntityManagerInterface $entityManager): void
    {
        $fichiers = $form->get('nouvellesPhotos')->getData() ?? [];
        $ordre = count($voiture->getPhotos());

        foreach ($fichiers as $fichier) {
            // Nom unique pour éviter que deux photos s'écrasent
            $nomFichier = uniqid('voiture-') . '.' . $fichier->guessExtension();

            $fichier->move(
                $this->getParameter('kernel.project_dir') . '/public/uploads/voitures',
                $nomFichier
            );

            $photo = new Photo();
            $photo->setNomFichier($nomFichier)
                ->setOrdre(++$ordre);
            $voiture->addPhoto($photo);
            $entityManager->persist($photo);
        }
    }
}
