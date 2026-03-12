# Cahier de Tests - CESIZen

**Version :** 1.6  
**Date :** 12 Mars 2026  
**Projet :** Application de gestion du stress et de la santé mentale

---

## Table des Matières

1. [Cahier de Tests](#1-cahier-de-tests)
   - 1.1 [Module Comptes Utilisateurs](#11-module-comptes-utilisateurs)
   - 1.2 [Module Informations](#12-module-informations)
   - 1.3 [Module Facultatif - Tableau de Bord](#13-module-facultatif---tableau-de-bord)

---

## 1. Cahier de Tests

### 1.1 Module Comptes Utilisateurs

#### 1.1.1 Inscription d'un Nouvel Utilisateur

**Objectif :** Vérifier que l'inscription fonctionne correctement

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-INSC-01** | Inscription réussie | - Aller sur la page d'inscription<br>- Saisir un email valide<br>- Saisir un nom valide<br>- Saisir un mot de passe valide (min. 8 caractères)<br>- Cliquer sur le bouton d'inscription | ✅ Compte créé<br>✅ Redirection vers dashboard | **Haute** |
| **US-INSC-02** | Email déjà utilisé | - Aller sur la page d'inscription<br>- Saisir un email déjà enregistré dans le système<br>- Saisir un nom valide<br>- Saisir un mot de passe valide<br>- Cliquer sur le bouton d'inscription | ❌ Erreur affichée : "Cet email est déjà utilisé"<br>❌ Compte non créé | **Haute** |
| **US-INSC-03** | Email invalide | - Aller sur la page d'inscription<br>- Saisir un email au format invalide<br>- Saisir un nom valide<br>- Saisir un mot de passe valide<br>- Observer la validation du formulaire | ❌ Erreur de validation en temps réel | **Moyenne** |
| **US-INSC-04** | Mot de passe trop court | - Aller sur la page d'inscription<br>- Saisir un email valide<br>- Saisir un nom valide<br>- Saisir un mot de passe trop court (moins de 8 caractères)<br>- Cliquer sur le bouton d'inscription | ❌ Erreur : "Le mot de passe doit contenir au moins 8 caractères" | **Haute** |
| **US-INSC-05** | Champs vides | - Aller sur la page d'inscription<br>- Laisser tous les champs vides<br>- Cliquer sur le bouton d'inscription | ❌ Messages d'erreur sur chaque champ obligatoire | **Haute** |
| **US-INSC-06** | Injection SQL tentée | - Aller sur la page d'inscription<br>- Saisir un email valide<br>- Saisir un nom contenant une tentative d'injection SQL<br>- Saisir un mot de passe valide<br>- Cliquer sur le bouton d'inscription | ✅ Données traitées en toute sécurité<br>❌ Aucune injection réussie | **Critique** |

#### 1.1.2 Connexion Utilisateur

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-CONN-01** | Connexion réussie (user) | - Aller sur la page de connexion<br>- Saisir un email utilisateur valide<br>- Saisir le mot de passe associé<br>- Cliquer sur le bouton de connexion | ✅ Connexion réussie<br>✅ Redirection vers le tableau de bord | **Haute** |
| **US-CONN-02** | Connexion réussie (admin) | - Aller sur la page de connexion<br>- Saisir un email administrateur valide<br>- Saisir le mot de passe associé<br>- Cliquer sur le bouton de connexion | ✅ Connexion réussie<br>✅ Redirection vers l'espace administrateur<br>✅ Accès aux fonctions admin | **Haute** |
| **US-CONN-03** | Mot de passe incorrect | - Aller sur la page de connexion<br>- Saisir un email valide<br>- Saisir un mot de passe incorrect<br>- Cliquer sur le bouton de connexion | ❌ Erreur : "Identifiants incorrects"<br>❌ Reste sur la page de connexion | **Haute** |
| **US-CONN-04** | Email inexistant | - Aller sur la page de connexion<br>- Saisir un email non enregistré<br>- Saisir un mot de passe<br>- Cliquer sur le bouton de connexion | ❌ Erreur : "Identifiants incorrects" (message générique) | **Haute** |

#### 1.1.3 Gestion du Profil

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-PROF-01** | Modifier le nom | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Modifier le nom avec une nouvelle valeur<br>- Cliquer sur enregistrer | ✅ Nom modifié avec succès<br>✅ Message de succès affiché<br>✅ Nouveau nom visible immédiatement | **Moyenne** |
| **US-PROF-02** | Modifier l'email | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Modifier l'email avec une nouvelle adresse valide<br>- Cliquer sur enregistrer | ✅ Email modifié avec succès<br>✅ Email de vérification envoyé | **Haute** |
| **US-PROF-03** | Changer le mot de passe | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Saisir l'ancien mot de passe correct<br>- Saisir un nouveau mot de passe valide<br>- Confirmer le nouveau mot de passe (identique)<br>- Cliquer sur enregistrer | ✅ Mot de passe modifié avec succès<br>✅ Message de succès affiché<br>✅ Connexion possible avec le nouveau mot de passe | **Haute** |
| **US-PROF-04** | Ancien mot de passe incorrect | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Saisir un ancien mot de passe incorrect<br>- Saisir un nouveau mot de passe valide<br>- Cliquer sur enregistrer | ❌ Erreur : "Mot de passe actuel incorrect"<br>❌ Mot de passe non changé | **Haute** |
| **US-PROF-05** | Confirmation MDP différente | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Saisir un nouveau mot de passe<br>- Saisir une confirmation différente<br>- Cliquer sur enregistrer | ❌ Erreur : "Les mots de passe ne correspondent pas" | **Moyenne** |

#### 1.1.4 Déconnexion

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-DECO-01** | Déconnexion simple | - Se connecter en tant qu'utilisateur<br>- Cliquer sur le bouton "Déconnexion" | ✅ Déconnexion réussie<br>✅ Redirection vers la page de connexion<br>✅ Message "Vous êtes déconnecté" affiché | **Haute** |
| **US-DECO-02** | Accès page protégée après déco | - Se connecter en tant qu'utilisateur<br>- Se déconnecter<br>- Tenter d'accéder à /dashboard directement | ❌ Redirection automatique vers la page de connexion<br>❌ Message "Veuillez vous connecter" affiché | **Haute** |

#### 1.1.5 Permissions et Rôles

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-PERM-01** | Admin accède à /admin | - Se connecter en tant qu'administrateur<br>- Naviguer vers la page /admin | ✅ Page affichée<br>✅ Liste des utilisateurs visible | **Haute** |
| **US-PERM-02** | User tente d'accéder à /admin | - Se connecter en tant qu'utilisateur standard<br>- Tenter d'accéder à la page /admin | ❌ Accès interdit<br>❌ Message "Accès refusé" affiché | **Critique** |
| **US-PERM-03** | Admin désactive un user | - Se connecter en tant qu'administrateur<br>- Aller sur la page de gestion des utilisateurs<br>- Sélectionner un utilisateur actif<br>- Cliquer sur désactiver le compte | ✅ Compte désactivé avec succès<br>✅ L'utilisateur ne peut plus se connecter | **Haute** |
| **US-PERM-04** | User désactivé tente connexion | - Aller sur la page de connexion<br>- Saisir l'email d'un compte désactivé<br>- Saisir le mot de passe correct<br>- Cliquer sur connexion | ❌ Erreur : "Votre compte a été désactivé"<br>❌ Connexion refusée | **Haute** |

---

### 1.2 Module Informations (Content Pages)

#### 1.2.1 Consultation des Pages d'Information

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-CONS-01** | Afficher page publiée | - Naviguer vers une page d'information publiée<br>- Observer le contenu affiché | ✅ Contenu affiché<br>✅ Titre correct<br>✅ Design responsive | **Haute** |
| **INFO-CONS-02** | Tenter d'afficher page non publiée | - En tant qu'utilisateur simple, naviguer vers une page non publiée<br>- Observer le résultat | ❌ Erreur 404 pour users<br>✅ Visible pour admins (prévisualisation) | **Haute** |
| **INFO-CONS-03** | Page inexistante | - Naviguer vers une URL de page qui n'existe pas<br>- Observer le résultat | ❌ Erreur 404<br>❌ Message "Page non trouvée" | **Moyenne** |

#### 1.2.2 Création de Pages (Admin)

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-CREA-01** | Créer une nouvelle page | - Se connecter en tant qu'administrateur<br>- Aller sur la page de gestion des contenus<br>- Cliquer sur "Créer une nouvelle page"<br>- Saisir un titre<br>- Saisir un slug unique<br>- Rédiger le contenu<br>- Laisser le statut en "brouillon" (non publié)<br>- Cliquer sur enregistrer | ✅ Page créée avec succès<br>✅ Page visible dans la liste des brouillons | **Haute** |
| **INFO-CREA-02** | Slug déjà existant | - Se connecter en tant qu'administrateur<br>- Créer une nouvelle page<br>- Saisir un slug déjà utilisé dans le système<br>- Tenter d'enregistrer | ❌ Erreur : "Ce slug est déjà utilisé"<br>❌ Page non créée | **Haute** |
| **INFO-CREA-03** | Publier une page | - Se connecter en tant qu'administrateur<br>- Ouvrir une page en brouillon<br>- Cocher l'option "Publier"<br>- Enregistrer les modifications | ✅ Page publiée avec succès<br>✅ Page visible publiquement | **Haute** |

#### 1.2.3 Modification de Pages (Admin)

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-MODIF-01** | Modifier le titre | - Se connecter en tant qu'administrateur<br>- Ouvrir une page existante<br>- Modifier le titre avec une nouvelle valeur<br>- Enregistrer les modifications | ✅ Titre modifié avec succès<br>✅ Lien de la page reste inchangé | **Moyenne** |
| **INFO-MODIF-02** | Modifier le contenu | - Se connecter en tant qu'administrateur<br>- Ouvrir une page existante<br>- Ajouter un nouveau paragraphe au contenu<br>- Enregistrer les modifications | ✅ Contenu modifié avec succès<br>✅ Modifications visibles sur la page | **Haute** |
| **INFO-MODIF-03** | Dépublier une page | - Se connecter en tant qu'administrateur<br>- Ouvrir une page publiée<br>- Décocher l'option "Publier"<br>- Enregistrer les modifications | ✅ Page dépubliée avec succès<br>✅ Page n'apparaît plus pour le public | **Haute** |

#### 1.2.4 Suppression de Pages (Admin)

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-SUPP-01** | Supprimer une page | - Se connecter en tant qu'administrateur<br>- Aller sur la liste des pages<br>- Sélectionner une page<br>- Cliquer sur "Supprimer"<br>- Confirmer la suppression dans le modal | ✅ Page supprimée avec succès<br>✅ Message de confirmation affiché<br>✅ Page n'est plus accessible | **Haute** |
| **INFO-SUPP-02** | Confirmation avant suppression | - Se connecter en tant qu'administrateur<br>- Aller sur la liste des pages<br>- Sélectionner une page<br>- Cliquer sur "Supprimer"<br>- Observer l'affichage du modal | ✅ Modal de confirmation apparaît<br>✅ Possibilité d'annuler | **Moyenne** |

---

### 1.3 Tableau de Bord

#### 1.3.1 Utilisateur

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **DASH-USER-01** | Afficher le dashboard user | - Se connecter en tant qu'utilisateur standard<br>- Observer le tableau de bord | ✅ Widget "Bienvenue"<br>✅ Dernières activités<br>✅ Statistiques personnelles | **Moyenne** |

#### 1.3.2 Admin

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **DASH-ADMIN-01** | Vue d'ensemble admin | - Se connecter en tant qu'administrateur<br>- Observer le tableau de bord admin | ✅ Nombre total d'utilisateurs<br>✅ Nouveaux inscrits (7j)<br>✅ Pages publiées/brouillons<br>✅ Graphiques visuels | **Haute** |
| **DASH-ADMIN-02** | Liste des utilisateurs | - Se connecter en tant qu'administrateur<br>- Cliquer sur l'onglet "Utilisateurs"<br>- Observer la liste des utilisateurs | ✅ Tableau paginé<br>✅ Colonnes : Nom, Email, Rôle, Statut<br>✅ Actions : Modifier, Désactiver | **Haute** |
| **DASH-ADMIN-03** | Recherche utilisateur | - Se connecter en tant qu'administrateur<br>- Aller sur l'onglet "Utilisateurs"<br>- Saisir un terme de recherche dans la barre de recherche<br>- Observer les résultats | ✅ Filtrage<br>✅ Résultats pertinents | **Moyenne** |

---
