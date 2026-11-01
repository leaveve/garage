<?php

namespace App\Controller;

use App\Repository\MarqueRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(VoitureRepository $voitureRepository, MarqueRepository $marqueRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'dernieresVoitures' => $voitureRepository->findBy(['statut' => 'disponible'], ['id' => 'DESC'], 3),
            'nbDisponibles' => $voitureRepository->count(['statut' => 'disponible']),
            'nbLocation' => $voitureRepository->count(['statut' => 'disponible', 'aLouer' => true]),
            'marques' => $marqueRepository->findBy([], ['libelle' => 'ASC']),
        ]);
    }
}
