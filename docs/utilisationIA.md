# Utilisation de l'IA sur le projet

J'ai utilisé une IA (Claude) pendant tout le projet. Ce document explique à quoi elle m'a servi et ce que j'ai fait moi-même.

## Comme un outil 
Au début, je lui ai présenté mon idée du projet et les différents fontionalités que je voulais metttre en place ; 
### le prompt ; 

Salut, je suis developpeuse et je dois réaliser un site web avec Symfony 8.1 (PHP 8.4, PostgreSQL 16, Doctrine, Twig, Bootstrap 5.3) pour un projet de cours. Je dois suivre uniquement les méthodes vues en cours (commandes make:, fixtures avec Faker, sécurité avec les rôles, etc.).

Mon idée : « Drift Club », un garage qui vend et loue des voitures de sport et de luxe (JDM, muscle cars, supercars), inspiré de Fast & Furious. Je veux un style sombre, dynamique et moderne, avec des couleurs rouge et violet.

Les rôles :

-Visiteur : voit la page d’accueil et le catalogue, peut créer un compte et se connecter.
-Client (ROLE_USER) : peut demander un rendez-vous pour une voiture (achat, location avec des dates, ou essai), suivre ses rendez-vous, les annuler, et -modifier son profil et son mot de passe.
-Personnel (ROLE_STAFF) : gère les rendez-vous (accepter, refuser, terminer) et modifie les annonces des voitures (infos, couleur, photos).
-Gérant (ROLE_ADMIN, un seul compte) : fait tout ce que fait le personnel. En plus, il ajoute et supprime des voitures, gère les marques (avec leur logo) et -les modèles, bloque, débloque et supprime des comptes, et invite un nouveau membre du personnel par email.

Les fonctionnalités :

-Catalogue avec filtres (marque, type de voiture, vente ou location) et tri, plus une fiche détaillée pour chaque voiture, avec plusieurs photos.
-Une voiture peut être à vendre, à louer, ou les deux. Elle a un statut : disponible, louée ou vendue.
-Rendez-vous avec un statut (en attente, accepté, refusé, terminé, annulé), affichés en kanban.
-Mot de passe oublié avec un lien envoyé par email (testé avec MailDev).
-Blocage des comptes : un compte bloqué ne peut plus se connecter.
-Fixtures pour remplir la base avec des voitures, des comptes de test et des rendez-vous.

Mes entités : User, Marque, Modele, TypeVoiture, Transmission, Carburant, Voiture, Photo, RendezVous.

Ce que j’attends de toi : maintenant tu connais mon projet et ce que je veux faire.Si je bloque sur un bug ou une erreur, je reviendrai te demander de l’aide. Dans ce cas, explique-moi d’où vient le problème et comment le corriger, sans réécrire tout mon code

puis j'ai envoyé nun prompt pr expliquer ma méthode de travail , comment je m'organise et l'ordre des étapes.

### le prompt ; 
Voici comment je m’organise pour mon projet Drift Club, pour que tu comprennes ma méthode de travail.

Avant de coder :
J’ai d’abord réfléchi à l’idée du site et aux trois types de comptes (gérant, personnel, client).
J’ai fait le MCD sur draw.io pour définir mes entités et leurs relations.
J’ai écrit un README avec les fonctionnalités par rôle, pour avoir une vision claire de ce que je dois réaliser.

Mon organisation sur GitHub :
J’utilise un kanban dans l’onglet Projects de GitHub, avec les colonnes « Todo », « In Progress » et « Done ».
J’ai découpé chaque fonctionnalité en petites tâches. Chaque tâche est une issue (un ticket) avec un objectif précis, par exemple « Inscription des clients avec nom et prénom » ou « Annulation d’un rendez-vous par le client ».
Je travaille avec une branche par grande partie du projet : feature/entites, feature/auth, feature/fixtures, feature/layout, feature/rendez-vous, feature/gestion-voitures, feature/photos, feature/filtres-catalogue, feature/gestion-comptes, feature/profil, feature/design. Quand une partie est finie et qu’elle marche, je la fusionne dans main.
Mes commits sont petits, avec un message clair en français. J’écris closes #numéro dans le message pour que l’issue se ferme toute seule et passe dans « Done ».

Les étapes, dans l’ordre :
-Installation du projet, configuration de la base PostgreSQL, README et MCD.
-Création des entités et première migration.
-Authentification : connexion, déconnexion, inscription, hiérarchie des rôles, règles d’accès et blocage des comptes.
-Fixtures avec Faker pour avoir des données de test (marques, modèles, utilisateurs, voitures, rendez-vous, photos).
-Layout et pages publiques : accueil, catalogue et fiche voiture.
-Rendez-vous : demande par le client, page « Mes rendez-vous », annulation, et gestion par le personnel.
-Gestion des voitures, des marques et des modèles par le personnel et le gérant, avec l’upload des photos.
-Gestion des comptes, invitation du personnel par email et mot de passe oublié.
-Filtres du catalogue et page profil.
-Design final, nettoyage du code et README final.

Mes objectifs :
À chaque étape, mon objectif était d’avoir une fonctionnalité qui marche entièrement avant de passer à la suivante.
Je testais avec les différents comptes (gérant, personnel, client, client bloqué) pour vérifier que chacun voit seulement ce qu’il a le droit de voir.
Je tiens un journal de bord (docs/journal.md) où j’écris ce que j’ai fait à chaque étape, les problèmes que j’ai rencontrés et comment je les ai réglés.

Maintenant tu connais ma méthode. Quand je te demanderai de l’aide, garde en tête cette organisation une branche par fonctionnalité, des petits commits, et une tâche à la fois.

j'ai demander de l'aide pour pouvoir adapter le champs ,modele a la marque 
### le prompt ;
Dans mon projet Symfony Drift Club, j’ai un formulaire pour ajouter et modifier une voiture (VoitureType), utilisé dans l’espace Gestion. Pour l’instant, le champ « modèle » est une liste déroulante qui affiche tous les modèles de toutes les marques mélangés. Ce n’est pas pratique quand il y en a beaucoup.

Pour rappel, mes entités : une Marque a plusieurs Modele, et une Voiture est liée à un Modele (la voiture n’a pas de lien direct avec la marque).

Ce que je veux : Ajouter une liste déroulante « Marque » au-dessus de « Modèle » dans le formulaire.
Quand je choisis une marque, la liste des modèles se met à jour sans recharger la page, et n’affiche que les modèles de cette marque.
Tant qu’aucune marque n’est choisie, la liste des modèles est vide ou désactivée.
Quand je modifie une voiture qui existe déjà, la marque de son modèle doit déjà être sélectionnée, avec le bon modèle choisi.
Le champ « Marque » ne doit pas être enregistré dans Voiture (il ne sert qu’à filtrer). Ce qui est enregistré, c’est toujours le modèle.

Guide-moi étape par étape et explique-moi chaque partie (le formulaire, la route qui renvoie les modèles d’une marque, et le JavaScript)



## Les parties écrites par l'IA

Ensuite, pour avancer plus vite, je lui ai demandé d'écrire directement certaines parties. Je les ai testées et relues, et je lui ai demandé de m'expliquer le code que je ne comprenais pas :
-le design complet du site (thème sombre rouge/violet, navbar, page d'accueil, cartes des voitures, animations, footer) et le nom « Drift Club »
-les pages de rendez-vous en kanban (côté client et côté personnel)
-l'upload des photos des voitures(ajout, suppression, photo principale) et la limite de taille avec le `php.ini`
-la couleur en code hexa dans le formulaire des voitures
-les logos des marques
-l'invitation du personnel par email (le gérant crée le compte et l'employé choisit son mot de passe avec le lien)
-la correction du filtre du catalogue
-les fixtures avec mes vraies voitures et mes photos à partir d'un export de ma base

## Ce que j'en retiens

L'IA m'a fait gagner beaucoup de temps, surtout sur le design et pour comprendre les erreurs. Mais j'ai quand même dû tester chaque fonctionnalité, repérer ce qui ne marchait pas et lui expliquer ce que je voulais changer
