<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/marque')]
final class MarqueController extends AbstractController
{
    #[Route(name: 'app_admin_marque_index', methods: ['GET'])]
    public function index(MarqueRepository $marqueRepository): Response
    {
        return $this->render('admin/marque/index.html.twig', [
            'marques' => $marqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_marque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($marque);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_marque_show', methods: ['GET'])]
    public function show(Marque $marque): Response
    {
        return $this->render('admin/marque/show.html.twig', [
            'marque' => $marque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_marque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Marque $marque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_marque_delete', methods: ['POST'])]
    public function delete(Request $request, Marque $marque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->getPayload()->getString('_token'))) {
            // On ne supprime pas une marque qui a encore des modèles
            if (count($marque->getModeles()) > 0) {
                $this->addFlash('warning', 'Impossible de supprimer cette marque : elle a encore des modèles.');
                return $this->redirectToRoute('app_admin_marque_index');
            }
            $entityManager->remove($marque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_marque_index', [], Response::HTTP_SEE_OTHER);
    }
}
