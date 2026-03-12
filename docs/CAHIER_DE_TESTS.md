# Cahier de Tests - CESIZen

**Version :** 1.3  
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
| **US-01** | Inscription réussie | - Aller sur la page d'inscription<br>- Saisir l'email <nouvel.user@test.fr><br>- Saisir le nom "Jean Dupont"<br>- Saisir le mot de passe "Test123!@#"<br>- Cliquer sur le bouton d'inscription | ✅ Compte créé<br>✅ Redirection vers dashboard | **Haute** |
| **US-02** | Email déjà utilisé | - Aller sur la page d'inscription<br>- Saisir l'email <admin@cesizen.com> (déjà existant)<br>- Saisir le nom "Test User"<br>- Saisir le mot de passe "Test123!@#"<br>- Cliquer sur le bouton d'inscription | ❌ Erreur affichée : "Cet email est déjà utilisé"<br>❌ Compte non créé | **Haute** |
| **US-03** | Email invalide | - Aller sur la page d'inscription<br>- Saisir l'email "invalide-email" (format incorrect)<br>- Saisir le nom "Test User"<br>- Saisir le mot de passe "Test123!@#"<br>- Observer la validation du formulaire | ❌ Erreur de validation en temps réel | **Moyenne** |
| **US-04** | Mot de passe trop court | - Aller sur la page d'inscription<br>- Saisir l'email <test@test.fr><br>- Saisir le nom "Test User"<br>- Saisir le mot de passe "123" (trop court)<br>- Cliquer sur le bouton d'inscription | ❌ Erreur : "Le mot de passe doit contenir au moins 8 caractères" | **Haute** |
| **US-05** | Champs vides | - Aller sur la page d'inscription<br>- Laisser tous les champs vides<br>- Cliquer sur le bouton d'inscription | ❌ Messages d'erreur sur chaque champ obligatoire | **Haute** |
| **US-06** | Injection SQL tentée | - Aller sur la page d'inscription<br>- Saisir l'email <test@test.fr><br>- Saisir le nom "' OR '1'='1" (tentative d'injection SQL)<br>- Saisir le mot de passe "Test123!@#"<br>- Cliquer sur le bouton d'inscription | ✅ Données échappées correctement<br>❌ Aucune injection réussie | **Critique** |

#### 1.1.2 Connexion Utilisateur

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-07** | Connexion réussie (user) | - Aller sur la page de connexion<br>- Saisir un email utilisateur valide<br>- Saisir le mot de passe associé<br>- Cliquer sur le bouton de connexion | ✅ Redirection vers /dashboard<br>✅ Session créée<br>✅ Token CSRF valide | **Haute** |
| **US-08** | Connexion réussie (admin) | - Aller sur la page de connexion<br>- Saisir l'email <admin@cesizen.com><br>- Saisir le mot de passe administrateur<br>- Cliquer sur le bouton de connexion | ✅ Redirection vers /admin<br>✅ Accès aux fonctions admin | **Haute** |
| **US-09** | Mot de passe incorrect | - Aller sur la page de connexion<br>- Saisir l'email <admin@cesizen.com><br>- Saisir un mot de passe incorrect "mauvais-mdp"<br>- Cliquer sur le bouton de connexion | ❌ Erreur : "Identifiants incorrects"<br>❌ Pas de session créée<br>❌ Reste sur /login | **Haute** |
| **US-10** | Email inexistant | - Aller sur la page de connexion<br>- Saisir l'email <inexistant@test.fr> (non enregistré)<br>- Saisir le mot de passe "Test123!@#"<br>- Cliquer sur le bouton de connexion | ❌ Erreur : "Identifiants incorrects" (message générique) | **Haute** |

#### 1.1.3 Gestion du Profil

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-11** | Modifier le nom | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Modifier le nom en "Marie Martin"<br>- Cliquer sur enregistrer | ✅ Nom mis à jour en BDD<br>✅ Message de succès<br>✅ Affichage immédiat du nouveau nom | **Moyenne** |
| **US-12** | Modifier l'email | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Modifier l'email en <marie.martin@test.fr><br>- Cliquer sur enregistrer | ✅ Email mis à jour<br>✅ Nouvel email de vérification envoyé | **Haute** |
| **US-13** | Changer le mot de passe | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Saisir l'ancien mot de passe "user123"<br>- Saisir le nouveau mot de passe "NewPass456!@"<br>- Confirmer le nouveau mot de passe "NewPass456!@"<br>- Cliquer sur enregistrer | ✅ Mot de passe hashé et stocké<br>✅ Message de succès<br>✅ Peut se reconnecter avec nouveau MDP | **Haute** |
| **US-14** | Ancien mot de passe incorrect | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Saisir un ancien mot de passe incorrect "mauvais-mdp"<br>- Saisir le nouveau mot de passe "NewPass456!@"<br>- Cliquer sur enregistrer | ❌ Erreur : "Mot de passe actuel incorrect"<br>❌ Mot de passe non changé | **Haute** |
| **US-15** | Confirmation MDP différente | - Se connecter en tant qu'utilisateur<br>- Aller sur la page de profil<br>- Saisir le nouveau mot de passe "NewPass456!@"<br>- Saisir une confirmation différente "Different123!@"<br>- Cliquer sur enregistrer | ❌ Erreur : "Les mots de passe ne correspondent pas" | **Moyenne** |

#### 1.1.4 Déconnexion

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-16** | Déconnexion simple | - Se connecter en tant qu'utilisateur<br>- Cliquer sur le bouton "Déconnexion" | ✅ Session détruite<br>✅ Redirection vers /login<br>✅ Message "Vous êtes déconnecté" | **Haute** |
| **US-17** | Accès page protégée après déco | - Se connecter en tant qu'utilisateur<br>- Se déconnecter<br>- Tenter d'accéder à /dashboard directement | ❌ Redirection automatique vers /login<br>❌ Message "Veuillez vous connecter" | **Haute** |

#### 1.1.5 Permissions et Rôles

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **US-18** | Admin accède à /admin | - Se connecter en tant qu'administrateur<br>- Naviguer vers la page /admin | ✅ Page affichée<br>✅ Liste des utilisateurs visible | **Haute** |
| **US-19** | User tente d'accéder à /admin | - Se connecter en tant qu'utilisateur standard<br>- Tenter d'accéder à la page /admin | ❌ Erreur 403 Forbidden<br>❌ Message "Accès refusé" | **Critique** |
| **US-20** | Admin désactive un user | - Se connecter en tant qu'administrateur<br>- Aller sur la page de gestion des utilisateurs<br>- Sélectionner l'utilisateur <user@cesizen.fr><br>- Cliquer sur désactiver le compte | ✅ Champ is_active = false en BDD<br>✅ User ne peut plus se connecter | **Haute** |
| **US-21** | User désactivé tente connexion | - Aller sur la page de connexion<br>- Saisir l'email d'un compte désactivé<br>- Saisir le mot de passe correct<br>- Cliquer sur connexion | ❌ Erreur : "Votre compte a été désactivé"<br>❌ Connexion refusée | **Haute** |

---

### 1.2 Module Informations (Content Pages)

#### 1.2.1 Consultation des Pages d'Information

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-01** | Afficher page publiée | - Naviguer vers une page d'information publiée (ex: /pages/a-propos)<br>- Observer le contenu affiché | ✅ Contenu affiché<br>✅ Titre correct<br>✅ Design responsive | **Haute** |
| **INFO-02** | Tenter d'afficher page non publiée | - En tant qu'utilisateur simple, naviguer vers /pages/brouillon (non publié)<br>- Observer le résultat | ❌ Erreur 404 pour users<br>✅ Visible pour admins (prévisualisation) | **Haute** |
| **INFO-03** | Page inexistante | - Naviguer vers une URL de page qui n'existe pas (ex: /pages/page-inexistante)<br>- Observer le résultat | ❌ Erreur 404<br>❌ Message "Page non trouvée" | **Moyenne** |

#### 1.2.2 Création de Pages (Admin)

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-04** | Créer une nouvelle page | - Se connecter en tant qu'administrateur<br>- Aller sur la page de gestion des contenus<br>- Cliquer sur "Créer une nouvelle page"<br>- Saisir le titre "Conseils bien-être"<br>- Saisir le slug "conseils-bien-etre"<br>- Rédiger le contenu<br>- Laisser le statut en "brouillon" (non publié)<br>- Cliquer sur enregistrer | ✅ Page créée en BDD<br>✅ UUID généré<br>✅ created_by = ID admin<br>✅ Slug unique | **Haute** |
| **INFO-05** | Slug déjà existant | - Se connecter en tant qu'administrateur<br>- Créer une nouvelle page<br>- Saisir un slug déjà utilisé (ex: "a-propos")<br>- Tenter d'enregistrer | ❌ Erreur : "Ce slug est déjà utilisé"<br>❌ Page non créée | **Haute** |
| **INFO-06** | Publier une page | - Se connecter en tant qu'administrateur<br>- Ouvrir une page en brouillon<br>- Cocher l'option "Publier"<br>- Enregistrer les modifications | ✅ is_published = 1<br>✅ published_at = timestamp actuel<br>✅ Page visible publiquement | **Haute** |

#### 1.2.3 Modification de Pages (Admin)

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-07** | Modifier le titre | - Se connecter en tant qu'administrateur<br>- Ouvrir la page "À propos"<br>- Modifier le titre en "À propos de nous"<br>- Enregistrer les modifications | ✅ Titre mis à jour<br>✅ Slug inchangé (stabilité des URLs) | **Moyenne** |
| **INFO-08** | Modifier le contenu | - Se connecter en tant qu'administrateur<br>- Ouvrir une page existante<br>- Ajouter un nouveau paragraphe au contenu<br>- Enregistrer les modifications | ✅ Contenu mis à jour<br>✅ updated_at changé | **Haute** |
| **INFO-09** | Dépublier une page | - Se connecter en tant qu'administrateur<br>- Ouvrir une page publiée<br>- Décocher l'option "Publier"<br>- Enregistrer les modifications | ✅ Page n'apparaît plus côté public<br>✅ published_at conservé (historique) | **Haute** |

#### 1.2.4 Suppression de Pages (Admin)

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **INFO-10** | Supprimer une page | - Se connecter en tant qu'administrateur<br>- Aller sur la liste des pages<br>- Sélectionner une page<br>- Cliquer sur "Supprimer"<br>- Confirmer la suppression dans le modal | ✅ Page supprimée de la BDD<br>✅ Message de confirmation<br>✅ 404 sur l'ancienne URL | **Haute** |
| **INFO-11** | Confirmation avant suppression | - Se connecter en tant qu'administrateur<br>- Aller sur la liste des pages<br>- Sélectionner une page<br>- Cliquer sur "Supprimer"<br>- Observer l'affichage du modal | ✅ Modal de confirmation apparaît<br>✅ Possibilité d'annuler | **Moyenne** |

---

### 1.3 Tableau de Bord

#### 1.3.1 Utilisateur

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **DASH-01** | Afficher le dashboard user | - Se connecter en tant qu'utilisateur standard<br>- Observer le tableau de bord | ✅ Widget "Bienvenue"<br>✅ Dernières activités<br>✅ Statistiques personnelles | **Moyenne** |

#### 1.3.2 Admin

| ID Test | Titre | Scénario | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **DASH-02** | Vue d'ensemble admin | - Se connecter en tant qu'administrateur<br>- Observer le tableau de bord admin | ✅ Nombre total d'utilisateurs<br>✅ Nouveaux inscrits (7j)<br>✅ Pages publiées/brouillons<br>✅ Graphiques visuels | **Haute** |
| **DASH-03** | Liste des utilisateurs | - Se connecter en tant qu'administrateur<br>- Cliquer sur l'onglet "Utilisateurs"<br>- Observer la liste des utilisateurs | ✅ Tableau paginé<br>✅ Colonnes : Nom, Email, Rôle, Statut<br>✅ Actions : Modifier, Désactiver | **Haute** |
| **DASH-04** | Recherche utilisateur | - Se connecter en tant qu'administrateur<br>- Aller sur l'onglet "Utilisateurs"<br>- Saisir "dupont" dans la barre de recherche<br>- Observer les résultats | ✅ Filtrage<br>✅ Résultats pertinents | **Moyenne** |

---
