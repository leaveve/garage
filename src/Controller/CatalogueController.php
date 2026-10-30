<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Voiture;

final class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(VoitureRepository $voitureRepository): Response
    {
        // récupère seulement les voitures disponibles les plus récentes d'abord
        $voitures = $voitureRepository->findBy(
            ['statut' => 'disponible'],
            ['annee' => 'DESC']
        );

        return $this->render('catalogue/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/catalogue/{id}', name: 'app_voiture_show', requirements: ['id' => '\d+'])]
    public function show(Voiture $voiture): Response {
        return $this->render('catalogue/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}