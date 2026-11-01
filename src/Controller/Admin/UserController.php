<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\StaffType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/compte')]
final class UserController extends AbstractController
{
    #[Route('', name: 'app_admin_user_index', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['nom' => 'ASC', 'prenom' => 'ASC']);

        // Filtre par rôle 
        $role = $request->query->get('role');
        if ($role === 'staff') {
            $users = array_filter($users, fn (User $u) => in_array('ROLE_STAFF', $u->getRoles(), true)
                && !in_array('ROLE_ADMIN', $u->getRoles(), true));
        } elseif ($role === 'client') {
            $users = array_filter($users, fn (User $u) => $u->getRoles() === ['ROLE_USER']);
        }

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
            'roleActuel' => $role,
        ]);
    }

    #[Route('/nouveau-personnel', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(StaffType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_STAFF'])
                ->setPassword($hasher->hashPassword($user, $form->get('plainPassword')->getData()));

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le compte de ' . $user->getPrenom() . ' a été créé.');
            return $this->redirectToRoute('app_admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/bloquer', name: 'app_admin_user_bloquer', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function bloquer(User $user, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('bloquer' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('danger', 'Action non autorisée.');
            return $this->redirectToRoute('app_admin_user_index');
        }

        // Le gérant  peut pas se bloquer 
        if ($user === $this->getUser()) {
            $this->addFlash('warning', 'Vous ne pouvez pas bloquer votre propre compte.');
            return $this->redirectToRoute('app_admin_user_index');
        }

        $user->setActif(!$user->isActif());
        $em->flush();

        $this->addFlash('success', sprintf(
            'Le compte de %s %s a été %s.',
            $user->getPrenom(),
            $user->getNom(),
            $user->isActif() ? 'débloqué' : 'bloqué'
        ));
        return $this->redirectToRoute('app_admin_user_index');
    }

    #[Route('/{id}/supprimer', name: 'app_admin_user_supprimer', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function supprimer(User $user, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('supprimer' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('danger', 'Action non autorisée.');
            return $this->redirectToRoute('app_admin_user_index');
        }

        // Le gérant ne peut pas se supprimer 
        if ($user === $this->getUser()) {
            $this->addFlash('warning', 'Vous ne pouvez pas supprimer votre propre compte.');
            return $this->redirectToRoute('app_admin_user_index');
        }

        // Même règle que pour les voitures  pas de suppression s'il reste des rdv en cours
        $rdvEnCours = $user->getRendezVouses()->filter(
            fn ($rdv) => in_array($rdv->getStatut(), ['en_attente', 'accepte'], true)
        );
        if (count($rdvEnCours) > 0) {
            $this->addFlash('warning', 'Ce client a des rendez-vous en cours. Traitez-les avant de supprimer son compte, ou bloquez-le.');
            return $this->redirectToRoute('app_admin_user_index');
        }

        // On supprime ses anciens rdv puis le compte
        foreach ($user->getRendezVouses() as $rdv) {
            $em->remove($rdv);
        }
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'Le compte a été supprimé.');
        return $this->redirectToRoute('app_admin_user_index');
    }
}