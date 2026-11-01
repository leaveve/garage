<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Form\ModeleType;
use App\Repository\ModeleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/modele')]
final class ModeleController extends AbstractController
{
    #[Route(name: 'app_admin_modele_index', methods: ['GET'])]
    public function index(ModeleRepository $modeleRepository): Response
    {
        // Tri par nom de marque puis par nom de modèle
        $modeles = $modeleRepository->createQueryBuilder('m')
            ->join('m.marque', 'ma')
            ->orderBy('ma.libelle', 'ASC')
            ->addOrderBy('m.libelle', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('admin/modele/index.html.twig', [
            'modeles' => $modeles,
        ]);
    }

    #[Route('/new', name: 'app_admin_modele_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $modele = new Modele();

      
        if ($marqueId = $request->query->get('marque')) {
            $modele->setMarque($entityManager->getRepository(Marque::class)->find($marqueId));
        }

        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($modele);
            $entityManager->flush();

            $this->addFlash('success', 'Le modèle a été ajouté.');
            return $this->redirectToRoute('app_admin_modele_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/modele/new.html.twig', [
            'modele' => $modele,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_modele_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Modele $modele, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le modèle a été modifié.');
            return $this->redirectToRoute('app_admin_modele_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/modele/edit.html.twig', [
            'modele' => $modele,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_modele_delete', methods: ['POST'])]
    public function delete(Request $request, Modele $modele, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$modele->getId(), $request->getPayload()->getString('_token'))) {
            // On ne supprime pas un modèle qui a encore des voitures
            if (count($modele->getVoitures()) > 0) {
                $this->addFlash('warning', 'Impossible de supprimer ce modèle : des voitures y sont rattachées.');
                return $this->redirectToRoute('app_admin_modele_index');
            }
            $entityManager->remove($modele);
            $entityManager->flush();
            $this->addFlash('success', 'Le modèle a été supprimé.');
        }

        return $this->redirectToRoute('app_admin_modele_index', [], Response::HTTP_SEE_OTHER);
    }
}
