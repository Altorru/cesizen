# Cahier de Tests - CESIZen

**Version :** 1.0  
**Date :** 9 Mars 2026  
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

| ID Test | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|------------------|----------|
| **US-01** | Inscription réussie | **Email:** nouvel.user@test.fr<br>**Nom:** Jean Dupont<br>**Mot de passe:** Test123!@# | ✅ Compte créé<br>✅ Email de confirmation envoyé<br>✅ Redirection vers dashboard<br>✅ Message de succès affiché | **Haute** |
| **US-02** | Email déjà utilisé | **Email:** admin@cesizen.fr (existant)<br>**Nom:** Test User<br>**Mot de passe:** Test123!@# | ❌ Erreur affichée : "Cet email est déjà utilisé"<br>❌ Compte non créé | **Haute** |
| **US-03** | Email invalide | **Email:** invalide-email<br>**Nom:** Test User<br>**Mot de passe:** Test123!@# | ❌ Erreur de validation en temps réel<br>❌ Bouton soumission désactivé | **Moyenne** |
| **US-04** | Mot de passe trop court | **Email:** test@test.fr<br>**Nom:** Test User<br>**Mot de passe:** 123 | ❌ Erreur : "Le mot de passe doit contenir au moins 8 caractères" | **Haute** |
| **US-05** | Champs vides | Tous les champs vides | ❌ Messages d'erreur sur chaque champ obligatoire | **Haute** |
| **US-06** | Injection SQL tentée | **Email:** test@test.fr<br>**Nom:** ' OR '1'='1<br>**Mot de passe:** Test123!@# | ✅ Données échappées correctement<br>❌ Aucune injection réussie | **Critique** |

#### 1.1.2 Connexion Utilisateur

| ID Test | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|------------------|----------|
| **US-07** | Connexion réussie (user) | **Email:** user@cesizen.fr<br>**Mot de passe:** user123 | ✅ Redirection vers /dashboard<br>✅ Session créée<br>✅ Token CSRF valide | **Haute** |
| **US-08** | Connexion réussie (admin) | **Email:** admin@cesizen.fr<br>**Mot de passe:** admin123 | ✅ Redirection vers /admin<br>✅ Accès aux fonctions admin | **Haute** |
| **US-09** | Mot de passe incorrect | **Email:** user@cesizen.fr<br>**Mot de passe:** mauvais-mdp | ❌ Erreur : "Identifiants incorrects"<br>❌ Pas de session créée<br>❌ Reste sur /login | **Haute** |
| **US-10** | Email inexistant | **Email:** inexistant@test.fr<br>**Mot de passe:** Test123!@# | ❌ Erreur : "Identifiants incorrects" (message générique) | **Haute** |
| **US-11** | Brute force (5 tentatives) | 5 tentatives avec mauvais mot de passe | ❌ Compte bloqué temporairement (15 min)<br>❌ Message : "Trop de tentatives" | **Critique** |
| **US-12** | Remember me activé | **Email:** user@cesizen.fr<br>**Mot de passe:** user123<br>**Remember:** Coché | ✅ Cookie "remember_token" créé<br>✅ Session persiste après fermeture navigateur | **Moyenne** |

#### 1.1.3 Gestion du Profil

| ID Test | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|------------------|----------|
| **US-13** | Modifier le nom | **Nouveau nom:** Marie Martin | ✅ Nom mis à jour en BDD<br>✅ Message de succès<br>✅ Affichage immédiat du nouveau nom | **Moyenne** |
| **US-14** | Modifier l'email | **Nouvel email:** marie.martin@test.fr | ✅ Email mis à jour<br>✅ email_verified_at réinitialisé<br>✅ Nouvel email de vérification envoyé | **Haute** |
| **US-15** | Changer le mot de passe | **Ancien:** user123<br>**Nouveau:** NewPass456!@<br>**Confirmation:** NewPass456!@ | ✅ Mot de passe hashé et stocké<br>✅ Message de succès<br>✅ Peut se reconnecter avec nouveau MDP | **Haute** |
| **US-16** | Ancien mot de passe incorrect | **Ancien:** mauvais-mdp<br>**Nouveau:** NewPass456!@ | ❌ Erreur : "Mot de passe actuel incorrect"<br>❌ Mot de passe non changé | **Haute** |
| **US-17** | Confirmation MDP différente | **Nouveau:** NewPass456!@<br>**Confirmation:** Different123!@ | ❌ Erreur : "Les mots de passe ne correspondent pas" | **Moyenne** |

#### 1.1.4 Déconnexion

| ID Test | Scénario | Action | Résultat Attendu | Priorité |
|---------|----------|--------|------------------|----------|
| **US-18** | Déconnexion simple | Clic sur "Déconnexion" | ✅ Session détruite<br>✅ Redirection vers /login<br>✅ Message "Vous êtes déconnecté" | **Haute** |
| **US-19** | Accès page protégée après déco | Visiter /dashboard après déconnexion | ❌ Redirection automatique vers /login<br>❌ Message "Veuillez vous connecter" | **Haute** |

#### 1.1.5 Permissions et Rôles

| ID Test | Scénario | Utilisateur | Action | Résultat Attendu | Priorité |
|---------|----------|-------------|--------|------------------|----------|
| **US-20** | Admin accède à /admin | Admin | Visiter /admin | ✅ Page affichée<br>✅ Liste des utilisateurs visible | **Haute** |
| **US-21** | User tente d'accéder à /admin | User | Visiter /admin | ❌ Erreur 403 Forbidden<br>❌ Message "Accès refusé" | **Critique** |
| **US-22** | Admin désactive un user | Admin | Désactiver user@cesizen.fr | ✅ Champ is_active = false en BDD<br>✅ User ne peut plus se connecter | **Haute** |
| **US-23** | User désactivé tente connexion | User désactivé | Se connecter | ❌ Erreur : "Votre compte a été désactivé"<br>❌ Connexion refusée | **Haute** |

---

### 1.2 Module Informations (Content Pages)

#### 1.2.1 Consultation des Pages d'Information

| ID Test | Scénario | Données | Résultat Attendu | Priorité |
|---------|----------|---------|------------------|----------|
| **INFO-01** | Afficher page publiée | Slug: "a-propos"<br>is_published: true | ✅ Contenu affiché<br>✅ Titre correct<br>✅ Design responsive | **Haute** |
| **INFO-02** | Tenter d'afficher page non publiée | Slug: "brouillon"<br>is_published: false | ❌ Erreur 404 pour users<br>✅ Visible pour admins (prévisualisation) | **Haute** |
| **INFO-03** | Page inexistante | Slug: "page-inexistante" | ❌ Erreur 404<br>❌ Message "Page non trouvée" | **Moyenne** |
| **INFO-04** | Affichage responsive mobile | Page quelconque | ✅ Lisible sur mobile (< 768px)<br>✅ Navigation adaptée<br>✅ Images redimensionnées | **Haute** |
| **INFO-05** | Performance de chargement | Page avec 5000 mots | ✅ Temps de chargement < 2 secondes<br>✅ Lighthouse Score > 90 | **Moyenne** |

#### 1.2.2 Création de Pages (Admin)

| ID Test | Scénario | Données | Résultat Attendu | Priorité |
|---------|----------|---------|------------------|----------|
| **INFO-06** | Créer une nouvelle page | **Titre:** Conseils bien-être<br>**Slug:** conseils-bien-etre<br>**Contenu:** Lorem ipsum...<br>**Publié:** Non | ✅ Page créée en BDD<br>✅ UUID généré<br>✅ created_by = ID admin<br>✅ Slug unique | **Haute** |
| **INFO-07** | Slug déjà existant | **Slug:** a-propos (existant) | ❌ Erreur : "Ce slug est déjà utilisé"<br>❌ Page non créée | **Haute** |
| **INFO-08** | Prévisualiser avant publication | Page en brouillon | ✅ Mode prévisualisation accessible<br>✅ Bandeau "Brouillon" affiché | **Moyenne** |
| **INFO-09** | Publier une page | is_published: false → true | ✅ is_published = 1<br>✅ published_at = timestamp actuel<br>✅ Page visible publiquement | **Haute** |
| **INFO-10** | Markdown rendu correctement | **Contenu:** # Titre\n\n**Gras**\n\n- Liste | ✅ HTML généré correct<br>✅ Styles appliqués | **Moyenne** |

#### 1.2.3 Modification de Pages (Admin)

| ID Test | Scénario | Action | Résultat Attendu | Priorité |
|---------|----------|--------|------------------|----------|
| **INFO-11** | Modifier le titre | Changer "À propos" → "À propos de nous" | ✅ Titre mis à jour<br>✅ Slug inchangé (stabilité des URLs) | **Moyenne** |
| **INFO-12** | Modifier le contenu | Ajouter un paragraphe | ✅ Contenu mis à jour<br>✅ updated_at changé | **Haute** |
| **INFO-13** | Dépublier une page | is_published: true → false | ✅ Page n'apparaît plus côté public<br>✅ published_at conservé (historique) | **Haute** |
| **INFO-14** | Modification simultanée | 2 admins modifient en même temps | ⚠️ Dernier enregistrement gagne<br>✅ Possibilité de conflit (acceptable) | **Basse** |

#### 1.2.4 Suppression de Pages (Admin)

| ID Test | Scénario | Action | Résultat Attendu | Priorité |
|---------|----------|---------|------------------|----------|
| **INFO-15** | Supprimer une page | Supprimer page ID X | ✅ Page supprimée de la BDD<br>✅ Message de confirmation<br>✅ 404 sur l'ancienne URL | **Haute** |
| **INFO-16** | Confirmation avant suppression | Clic sur "Supprimer" | ✅ Modal de confirmation apparaît<br>✅ Possibilité d'annuler | **Moyenne** |
| **INFO-17** | User supprimé = pages en cascade | Supprimer le créateur | ✅ Toutes ses pages supprimées (CASCADE)<br>⚠️ Alternative : réassigner les pages | **Moyenne** |

---

### 1.3 Module Facultatif - Tableau de Bord

#### 1.3.1 Statistiques Utilisateur

| ID Test | Scénario | Contexte | Résultat Attendu | Priorité |
|---------|----------|----------|------------------|----------|
| **DASH-01** | Afficher le dashboard user | User connecté | ✅ Widget "Bienvenue"<br>✅ Dernières activités<br>✅ Statistiques personnelles | **Moyenne** |
| **DASH-02** | Afficher statistiques vides | Nouveau compte | ✅ Message "Aucune activité"<br>✅ Call-to-action pour commencer | **Basse** |
| **DASH-03** | Graphique d'évolution | User avec historique | ✅ Graphique (Chart.js/Unovis)<br>✅ Données des 7 derniers jours<br>✅ Responsive | **Moyenne** |

#### 1.3.2 Dashboard Admin

| ID Test | Scénario | Action | Résultat Attendu | Priorité |
|---------|----------|--------|------------------|----------|
| **DASH-04** | Vue d'ensemble admin | Admin se connecte | ✅ Nombre total d'utilisateurs<br>✅ Nouveaux inscrits (7j)<br>✅ Pages publiées/brouillons<br>✅ Graphiques visuels | **Haute** |
| **DASH-05** | Liste des utilisateurs | Onglet "Utilisateurs" | ✅ Tableau paginé<br>✅ Colonnes : Nom, Email, Rôle, Statut<br>✅ Actions : Modifier, Désactiver | **Haute** |
| **DASH-06** | Recherche utilisateur | Rechercher "dupont" | ✅ Filtrage en temps réel<br>✅ Résultats pertinents | **Moyenne** |
| **DASH-07** | Tri des colonnes | Clic sur en-tête "Date création" | ✅ Tri ascendant/descendant<br>✅ Indicateur de tri visible | **Basse** |
| **DASH-08** | Export données (bonus) | Clic "Exporter CSV" | ✅ Fichier users_export.csv téléchargé<br>✅ Format correct | **Basse** |

#### 1.3.3 Notifications

| ID Test | Scénario | Déclencheur | Résultat Attendu | Priorité |
|---------|----------|-------------|------------------|----------|
| **DASH-09** | Toast de succès | Action réussie | ✅ Toast vert en haut à droite<br>✅ Disparaît après 3s<br>✅ Bouton fermeture manuel | **Moyenne** |
| **DASH-10** | Toast d'erreur | Action échouée | ❌ Toast rouge<br>❌ Message d'erreur clair | **Haute** |
| **DASH-11** | Toast d'info | Action en cours | ℹ️ Toast bleu<br>ℹ️ "Traitement en cours..." | **Basse** |

---