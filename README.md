# Drift Club — Vente & Location de voitures de sport et de luxe

Site web d'un garage qui vend et loue des voitures de sport et de luxe (JDM, muscle cars, supercars).
Les visiteurs consultent le catalogue, les clients demandent un rendez-vous (achat, location ou essai), et l'équipe du garage gère les annonces, les rendez-vous et les comptes depuis un espace de gestion.

## Technologies

- PHP 8.4 / Symfony 8.1
- PostgreSQL 16 / Doctrine ORM
- Twig, AssetMapper, Turbo
- Bootstrap 5.3 (CDN)
- Faker (fixtures)
- Symfony Mailer + MailDev (emails en local)
- symfonycasts/reset-password-bundle (mot de passe oublié et invitation du personnel)

## Fonctionnalités par rôle

### Visiteur (non connecté)
- Page d'accueil (dernières voitures, compteurs, marques)
- Catalogue avec filtres (marque, type de voiture, vente / location) et tri, plus une fiche détaillée pour chaque voiture
- Créer un compte / se connecter
- Mot de passe oublié (lien de réinitialisation par email)

### Client (`ROLE_USER`)
- Tout ce que peut faire un visiteur
- Demander un rendez-vous pour une voiture (achat, location avec dates, ou essai)
- Suivre ses rendez-vous dans « Mes rendez-vous » (affichage en colonnes par statut) et annuler une demande
- Modifier son profil et son mot de passe

### Personnel (`ROLE_STAFF`)
- Tout ce que peut faire un client (sauf prendre rendez-vous)
- Gérer les rendez-vous sur un tableau kanban (en attente → accepté / refusé → terminé)
- Modifier les annonces : infos, couleur en code hexa, photos (ajout, suppression, photo principale)

### Gérant (`ROLE_ADMIN`) — compte unique
- Tout ce que peut faire le personnel
- Ajouter et supprimer des voitures (suppression bloquée si des rendez-vous sont en cours)
- Gérer les marques (avec logo) et les modèles
- Gérer les comptes : filtre par rôle, bloquer / débloquer, supprimer
- Inviter un membre du personnel : le compte est créé et il reçoit un email pour choisir son mot de passe

## Installation

Prérequis : PHP 8.4, Composer, Symfony CLI, PostgreSQL 16, Node (pour MailDev).

```bash
git clone https://github.com/leaveve/garage.git
cd garage
composer install
```

Créer un fichier `.env.local` avec la connexion à la base :

```
DATABASE_URL="postgresql://utilisateur:motdepasse@127.0.0.1:5432/garage?serverVersion=16&charset=utf8"
MAILER_DSN=smtp://localhost:1025
```

Créer la base et la remplir :

```bash
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load
```

Lancer MailDev (emails visibles sur http://localhost:1080) puis le serveur :

```bash
npx maildev
symfony serve
```

Le fichier `php.ini` à la racine augmente la taille max des uploads (10 Mo par photo), il est lu automatiquement par `symfony serve`.

## Comptes de test

Après `symfony console doctrine:fixtures:load`, ces comptes sont disponibles.
Mot de passe pour tous : `password`

| Rôle | Email |
|------|-------|
| Gérant (`ROLE_ADMIN`) | gerant@garage.fr |
| Personnel (`ROLE_STAFF`) | staff1@garage.fr, staff2@garage.fr, staff3@garage.fr |
| Client (`ROLE_USER`) | client1@garage.fr à client9@garage.fr |
| Client bloqué | client10@garage.fr |

⚠️ `doctrine:fixtures:load` vide entièrement la base avant de la remplir.

## Documentation

- MCD : [docs/mcd.drawio.png](docs/mcd.drawio.png)
- Journal de bord : le détail de toutes mes étapes de travail est dans [docs/journal.md](docs/journal.md)
