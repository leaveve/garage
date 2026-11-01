<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangementMotDePasseType;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mon-compte/profil')]
final class ProfilController extends AbstractController
{
    #[Route('', name: 'app_profil', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Vos informations ont été mises à jour.');
            return $this->redirectToRoute('app_profil');
        }

        if ($form->isSubmitted()) {
            $em->refresh($user);
        }

        return $this->render('profil/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/mot-de-passe', name: 'app_profil_mot_de_passe', methods: ['GET', 'POST'])]
    public function motDePasse(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ChangementMotDePasseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($hasher->hashPassword($user, $form->get('nouveauMotDePasse')->getData()));
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a été modifié.');
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/mot_de_passe.html.twig', [
            'form' => $form,
        ]);
    }
}
