<?php

namespace App\Controller\Gestion;

use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gestion/rendez-vous')]
final class RendezVousController extends AbstractController
{
    // Les changements de statut autorisés 
    private const TRANSITIONS = [
        'en_attente' => ['accepte', 'refuse'],
        'accepte'    => ['termine', 'refuse'],
    ];

    #[Route('', name: 'app_gestion_rdv_index')]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('gestion/rendez_vous/index.html.twig', [
            'rendezVous' => $rendezVousRepository->findBy([], ['dateHeure' => 'ASC']),
        ]);
    }

    #[Route('/{id}/statut', name: 'app_gestion_rdv_statut', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function changerStatut(RendezVous $rdv, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('statut' . $rdv->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('danger', 'Action non autorisée.');
            return $this->redirectToRoute('app_gestion_rdv_index');
        }

        $nouveauStatut = $request->getPayload()->getString('statut');
        $autorises = self::TRANSITIONS[$rdv->getStatut()] ?? [];

        // On vérifie que le changement est logique 
        if (!in_array($nouveauStatut, $autorises, true)) {
            $this->addFlash('warning', 'Ce changement de statut n\'est pas possible.');
            return $this->redirectToRoute('app_gestion_rdv_index');
        }

        $rdv->setStatut($nouveauStatut);
        $em->flush();

        $this->addFlash('success', 'Le rendez-vous a été mis à jour.');
        return $this->redirectToRoute('app_gestion_rdv_index');
    }
}