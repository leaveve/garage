<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\MarqueRepository;
use App\Repository\TypeVoitureRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(
        Request $request,
        VoitureRepository $voitureRepository,
        MarqueRepository $marqueRepository,
        TypeVoitureRepository $typeVoitureRepository,
    ): Response {
        $filtres = [
            'marque' => (int) $request->query->get('marque'),
            'type' => (int) $request->query->get('type'),
            'mode' => $request->query->getString('mode'),
            'tri' => $request->query->getString('tri'),
        ];

        return $this->render('catalogue/index.html.twig', [
            'voitures' => $voitureRepository->findCatalogue($filtres),
            'filtres' => $filtres,
            'marques' => $marqueRepository->findBy([], ['libelle' => 'ASC']),
            'types' => $typeVoitureRepository->findBy([], ['libelle' => 'ASC']),
        ]);
    }

    #[Route('/catalogue/{id}', name: 'app_voiture_show', requirements: ['id' => '\d+'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('catalogue/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}
