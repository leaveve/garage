<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\VoitureRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
        public function index(VoitureRepository $voitureRepository): Response
    {
            // Les 3 dernières voitures disponibles ajoutées
            $dernieresVoitures = $voitureRepository->findBy(
            ['statut' => 'disponible'],
            ['id' => 'DESC'],
            3
        );

            return $this->render('home/index.html.twig', [
            'dernieresVoitures' => $dernieresVoitures,
        ]);
    }
}
