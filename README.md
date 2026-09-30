# Garage  Vente & Location de voitures

Site web pour un garage automobile qui vend et loue des voitures.
Les visiteurs peuvent consulter le catalogue, les clients peuvent réserver une location ou demander un rendez-vous (essai ou achat), et l'équipe du garage gère les annonces, les réservations et les comptes depuis un espace de gestion.


## Fonctionnalités par rôle

### Visiteur (non connecté)
- Consulter la page d'accueil
- Parcourir le catalogue des voitures
- Créer un compte / se connecter

### Client (`ROLE_USER`)
- Tout ce que peut faire un visiteur
- Réserver une voiture en location
- Demander un rendez-vous (essai ou achat)
- Consulter l'onglet « Mes locations »

### Personnel (`ROLE_STAFF`)
- Tout ce que peut faire un client
- Gérer les demandes de rendez-vous (accepter / refuser)
- Gérer les réservations de location
- Modifier les annonces du catalogue

### Manager (`ROLE_ADMIN`) — compte unique
- Tout ce que peut faire le personnel
- Ajouter et supprimer des voitures du catalogue
- Bloquer / débloquer l'accès d'un client ou d'un membre du personnel
- Supprimer des comptes
