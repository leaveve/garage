<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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
            'marques' => $marqueRepository->findBy([], ['libelle' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_admin_marque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->enregistrerLogo($form, $marque);
            $entityManager->persist($marque);
            $entityManager->flush();

            $this->addFlash('success', 'La marque ' . $marque->getLibelle() . ' a été ajoutée.');
            return $this->redirectToRoute('app_admin_marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_marque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Marque $marque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->enregistrerLogo($form, $marque);
            $entityManager->flush();

            $this->addFlash('success', 'La marque ' . $marque->getLibelle() . ' a été modifiée.');
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
        if ($this->isCsrfTokenValid('delete' . $marque->getId(), $request->getPayload()->getString('_token'))) {
            if (count($marque->getModeles()) > 0) {
                $this->addFlash('warning', 'Impossible de supprimer cette marque : elle a encore des modèles.');
                return $this->redirectToRoute('app_admin_marque_index');
            }

            $this->supprimerFichierLogo($marque);
            $entityManager->remove($marque);
            $entityManager->flush();
            $this->addFlash('success', 'La marque a été supprimée.');
        }

        return $this->redirectToRoute('app_admin_marque_index', [], Response::HTTP_SEE_OTHER);
    }

    private function enregistrerLogo(FormInterface $form, Marque $marque): void
    {
        $fichier = $form->get('logoFichier')->getData();
        if (!$fichier) {
            return;
        }

        $nomFichier = uniqid('marque-') . '.' . ($fichier->guessExtension() ?? 'png');
        $fichier->move($this->getParameter('kernel.project_dir') . '/public/uploads/marques', $nomFichier);

        $this->supprimerFichierLogo($marque);
        $marque->setLogo($nomFichier);
    }

    private function supprimerFichierLogo(Marque $marque): void
    {
        if (!$marque->getLogo()) {
            return;
        }

        $chemin = $this->getParameter('kernel.project_dir') . '/public/uploads/marques/' . $marque->getLogo();
        if (file_exists($chemin)) {
            unlink($chemin);
        }
    }
}
