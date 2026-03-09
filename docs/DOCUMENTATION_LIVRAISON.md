# Documentation de Livraison - CESIZen

**Version :** 1.0  
**Date :** 9 Mars 2026  
**Projet :** Application de gestion du stress et de la santé mentale

---

## Table des Matières

1. [Cahier de Tests](#1-cahier-de-tests)
   - 1.1 [Module Comptes Utilisateurs](#11-module-comptes-utilisateurs)
   - 1.2 [Module Informations](#12-module-informations)
   - 1.3 [Module Facultatif - Tableau de Bord](#13-module-facultatif---tableau-de-bord)
2. [Procédure de Validation](#2-procédure-de-validation)
3. [Modèle de PV de Recette](#3-modèle-de-pv-de-recette)

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

**Procédure de Test US-01 (Détaillée) :**

```gherkin
ETANT DONNÉ que je suis sur la page d'inscription (/register)
ET que je suis déconnecté

QUAND je saisis "nouvel.user@test.fr" dans le champ "Email"
ET je saisis "Jean Dupont" dans le champ "Nom complet"
ET je saisis "Test123!@#" dans le champ "Mot de passe"
ET je saisis "Test123!@#" dans le champ "Confirmation du mot de passe"
ET je clique sur le bouton "S'inscrire"

ALORS je suis redirigé vers "/dashboard"
ET je vois le message "Bienvenue sur CESIZen !"
ET un email de confirmation est envoyé à "nouvel.user@test.fr"
ET un nouvel enregistrement existe dans la table "users" avec :
  - email = "nouvel.user@test.fr"
  - name = "Jean Dupont"
  - role = "user"
  - is_active = true
  - email_verified_at = NULL (en attente de vérification)
```

**Données de Vérification (Base de Données) :**

```sql
-- Vérifier la création du compte
SELECT id, uuid, name, email, role, is_active, email_verified_at, created_at
FROM users
WHERE email = 'nouvel.user@test.fr';

-- Résultat attendu :
-- id: 2 (ou suivant)
-- uuid: [UUID valide]
-- name: Jean Dupont
-- email: nouvel.user@test.fr
-- role: user
-- is_active: 1
-- email_verified_at: NULL
-- created_at: [Timestamp actuel]
```

#### 1.1.2 Connexion Utilisateur

| ID Test | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|------------------|----------|
| **US-07** | Connexion réussie (user) | **Email:** user@cesizen.fr<br>**Mot de passe:** user123 | ✅ Redirection vers /dashboard<br>✅ Session créée<br>✅ Token CSRF valide | **Haute** |
| **US-08** | Connexion réussie (admin) | **Email:** admin@cesizen.fr<br>**Mot de passe:** admin123 | ✅ Redirection vers /admin<br>✅ Accès aux fonctions admin | **Haute** |
| **US-09** | Mot de passe incorrect | **Email:** user@cesizen.fr<br>**Mot de passe:** mauvais-mdp | ❌ Erreur : "Identifiants incorrects"<br>❌ Pas de session créée<br>❌ Reste sur /login | **Haute** |
| **US-10** | Email inexistant | **Email:** inexistant@test.fr<br>**Mot de passe:** Test123!@# | ❌ Erreur : "Identifiants incorrects" (message générique) | **Haute** |
| **US-11** | Brute force (5 tentatives) | 5 tentatives avec mauvais mot de passe | ❌ Compte bloqué temporairement (15 min)<br>❌ Message : "Trop de tentatives" | **Critique** |
| **US-12** | Remember me activé | **Email:** user@cesizen.fr<br>**Mot de passe:** user123<br>**Remember:** Coché | ✅ Cookie "remember_token" créé<br>✅ Session persiste après fermeture navigateur | **Moyenne** |

**Procédure de Test US-07 (Détaillée) :**

```gherkin
ETANT DONNÉ que je suis sur la page de connexion (/login)
ET que le compte "user@cesizen.fr" existe avec mot de passe "user123"
ET que je suis déconnecté

QUAND je saisis "user@cesizen.fr" dans le champ "Email"
ET je saisis "user123" dans le champ "Mot de passe"
ET je clique sur le bouton "Se connecter"

ALORS je suis redirigé vers "/dashboard"
ET la navigation affiche "Mon compte"
ET je peux voir mon nom "User CESIZen" dans l'en-tête
ET une session est créée dans la table "sessions" avec :
  - user_id = [ID de l'utilisateur]
  - ip_address = [IP du client]
  - user_agent = [Navigateur utilisé]
```

#### 1.1.3 Gestion du Profil

| ID Test | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|------------------|----------|
| **US-13** | Modifier le nom | **Nouveau nom:** Marie Martin | ✅ Nom mis à jour en BDD<br>✅ Message de succès<br>✅ Affichage immédiat du nouveau nom | **Moyenne** |
| **US-14** | Modifier l'email | **Nouvel email:** marie.martin@test.fr | ✅ Email mis à jour<br>✅ email_verified_at réinitialisé<br>✅ Nouvel email de vérification envoyé | **Haute** |
| **US-15** | Changer le mot de passe | **Ancien:** user123<br>**Nouveau:** NewPass456!@<br>**Confirmation:** NewPass456!@ | ✅ Mot de passe hashé et stocké<br>✅ Message de succès<br>✅ Peut se reconnecter avec nouveau MDP | **Haute** |
| **US-16** | Ancien mot de passe incorrect | **Ancien:** mauvais-mdp<br>**Nouveau:** NewPass456!@ | ❌ Erreur : "Mot de passe actuel incorrect"<br>❌ Mot de passe non changé | **Haute** |
| **US-17** | Confirmation MDP différente | **Nouveau:** NewPass456!@<br>**Confirmation:** Different123!@ | ❌ Erreur : "Les mots de passe ne correspondent pas" | **Moyenne** |

**Procédure de Test US-15 (Détaillée) :**

```gherkin
ETANT DONNÉ que je suis connecté en tant que "user@cesizen.fr"
ET que je suis sur la page "/profile/security"

QUAND je saisis "user123" dans le champ "Mot de passe actuel"
ET je saisis "NewPass456!@" dans le champ "Nouveau mot de passe"
ET je saisis "NewPass456!@" dans le champ "Confirmer le mot de passe"
ET je clique sur "Mettre à jour le mot de passe"

ALORS je vois le message "Mot de passe modifié avec succès"
ET je suis déconnecté automatiquement
ET je suis redirigé vers "/login"

QUAND je me reconnecte avec "NewPass456!@"
ALORS la connexion réussit

ET en base de données :
  - La colonne "password" de l'utilisateur a changé
  - Le hash bcrypt est différent de l'ancien
```

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

**Procédure de Test US-21 (Sécurité Critique) :**

```gherkin
ETANT DONNÉ que je suis connecté en tant que "user@cesizen.fr" (rôle = user)

QUAND je tente d'accéder directement à "https://cesizen.altorru.fr/admin"

ALORS je reçois une erreur HTTP 403
ET je vois le message "Vous n'avez pas les permissions pour accéder à cette page"
ET je suis redirigé vers "/dashboard"

ET dans les logs :
  - Un événement de tentative d'accès non autorisé est enregistré
  - L'IP et user_id sont loggés
```

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

**Procédure de Test INFO-01 (Détaillée) :**

```gherkin
ETANT DONNÉ qu'une page "À propos" existe avec :
  - slug: "a-propos"
  - title: "À propos de CESIZen"
  - content: "[Contenu Markdown]"
  - is_published: true
  - published_at: "2026-03-01 10:00:00"

QUAND je visite "https://cesizen.altorru.fr/infos/a-propos"

ALORS je vois le titre "À propos de CESIZen"
ET le contenu Markdown est rendu en HTML
ET les titres H1, H2, H3 sont stylisés
ET les liens sont cliquables
ET les images (le cas échéant) sont chargées
ET le footer affiche "Publié le 1er mars 2026"

ET la requête SQL exécutée est :
SELECT * FROM content_pages 
WHERE slug = 'a-propos' 
AND is_published = 1;
```

#### 1.2.2 Création de Pages (Admin)

| ID Test | Scénario | Données | Résultat Attendu | Priorité |
|---------|----------|---------|------------------|----------|
| **INFO-06** | Créer une nouvelle page | **Titre:** Conseils bien-être<br>**Slug:** conseils-bien-etre<br>**Contenu:** Lorem ipsum...<br>**Publié:** Non | ✅ Page créée en BDD<br>✅ UUID généré<br>✅ created_by = ID admin<br>✅ Slug unique | **Haute** |
| **INFO-07** | Slug déjà existant | **Slug:** a-propos (existant) | ❌ Erreur : "Ce slug est déjà utilisé"<br>❌ Page non créée | **Haute** |
| **INFO-08** | Prévisualiser avant publication | Page en brouillon | ✅ Mode prévisualisation accessible<br>✅ Bandeau "Brouillon" affiché | **Moyenne** |
| **INFO-09** | Publier une page | is_published: false → true | ✅ is_published = 1<br>✅ published_at = timestamp actuel<br>✅ Page visible publiquement | **Haute** |
| **INFO-10** | Markdown rendu correctement | **Contenu:** # Titre\n\n**Gras**\n\n- Liste | ✅ HTML généré correct<br>✅ Styles appliqués | **Moyenne** |

**Procédure de Test INFO-06 (Détaillée) :**

```gherkin
ETANT DONNÉ que je suis connecté en tant qu'admin
ET que je suis sur "/admin/content-pages/create"

QUAND je remplis le formulaire :
  - Titre: "Conseils bien-être"
  - Slug: "conseils-bien-etre" (auto-généré depuis titre)
  - Contenu: "## Introduction\n\nLorem ipsum dolor sit amet..."
  - Publié: "Non" (case décochée)

ET je clique sur "Enregistrer"

ALORS je suis redirigé vers "/admin/content-pages"
ET je vois le message "Page créée avec succès"
ET dans la liste, la page "Conseils bien-être" apparaît avec :
  - Badge "Brouillon"
  - Date de création
  - Bouton "Modifier" et "Prévisualiser"

ET en base de données :
INSERT INTO content_pages VALUES (
  '[UUID]',
  'conseils-bien-etre',
  'Conseils bien-être',
  '## Introduction\n\nLorem ipsum...',
  0,  -- is_published
  NULL,  -- published_at
  [ID_ADMIN],  -- created_by
  NOW(),
  NOW()
);
```

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

**Procédure de Test DASH-04 (Détaillée) :**

```gherkin
ETANT DONNÉ que je suis connecté en tant qu'admin
ET qu'il existe :
  - 127 utilisateurs au total
  - 12 nouveaux inscrits dans les 7 derniers jours
  - 8 pages publiées
  - 3 pages en brouillon

QUAND je visite "/admin"

ALORS je vois 4 cartes statistiques :
  │ Utilisateurs │ Nouveaux (7j) │ Pages publiées │ Brouillons │
  │     127      │      12       │       8        │     3      │

ET je vois un graphique "Évolution des inscriptions"
  - Axe X : 7 derniers jours
  - Axe Y : Nombre d'inscriptions
  - Données correctes pour chaque jour

ET je vois un tableau "Dernières activités" avec :
  - 10 dernières actions (inscriptions, publications)
  - Date/Heure
  - Type d'action
  - Utilisateur concerné
```

#### 1.3.3 Notifications

| ID Test | Scénario | Déclencheur | Résultat Attendu | Priorité |
|---------|----------|-------------|------------------|----------|
| **DASH-09** | Toast de succès | Action réussie | ✅ Toast vert en haut à droite<br>✅ Disparaît après 3s<br>✅ Bouton fermeture manuel | **Moyenne** |
| **DASH-10** | Toast d'erreur | Action échouée | ❌ Toast rouge<br>❌ Message d'erreur clair | **Haute** |
| **DASH-11** | Toast d'info | Action en cours | ℹ️ Toast bleu<br>ℹ️ "Traitement en cours..." | **Basse** |

---

## 2. Procédure de Validation

### 2.1 Objectif

La procédure de validation vise à garantir que le système CESIZen répond aux exigences fonctionnelles et non-fonctionnelles définies dans le cahier des charges. Elle s'appuie sur l'exécution systématique du cahier de tests et la formalisation des résultats dans un Procès-Verbal (PV) de recette.

### 2.2 Acteurs

| Rôle | Responsabilité |
|------|---------------|
| **Maître d'Ouvrage (MOA)** | Valide la conformité métier, signe le PV de recette |
| **Chef de Projet MOE** | Coordonne les tests, présente les résultats |
| **Équipe Technique** | Exécute les tests, corrige les anomalies |
| **Testeurs** | Reproduisent les scénarios, documentent les bugs |

### 2.3 Environnements de Test

```
┌──────────────────────────────────────────────────┐
│          ENVIRONNEMENTS DE VALIDATION            │
├──────────────────────────────────────────────────┤
│ 1. Développement (localhost)                     │
│    → Tests unitaires et d'intégration            │
│    → Corrections rapides                         │
│                                                  │
│ 2. Recette/Staging (recette.cesizen.fr)         │
│    → Tests fonctionnels complets                 │
│    → Données anonymisées                         │
│    → Environnement ISO production                │
│                                                  │
│ 3. Production (cesizen.fr)                       │
│    → Tests de fumée post-déploiement             │
│    → Monitoring continu                          │
└──────────────────────────────────────────────────┘
```

### 2.4 Phases de Validation

#### Phase 1 : Validation Technique (Interne)

**Durée estimée :** 2 jours  
**Responsable :** Équipe Technique

**Actions :**
1. Exécution des tests automatisés (Pest PHP)
   ```bash
   php artisan test --coverage
   ```
   - **Objectif :** Couverture de code ≥ 80%
   
2. Tests de sécurité
   - Scan de vulnérabilités (OWASP Top 10)
   - Test d'injection SQL
   - Test XSS
   - Test CSRF
   
3. Tests de performance
   - Temps de réponse < 500ms (pages simples)
   - Temps de réponse < 2s (pages complexes)
   - Test de charge (100 utilisateurs simultanés)

4. Validation responsive
   - Desktop (1920x1080, 1366x768)
   - Tablette (768x1024)
   - Mobile (375x667, 414x896)

**Critères de passage :**
- ✅ 100% des tests unitaires passent
- ✅ 0 vulnérabilité critique
- ✅ Performance conforme aux objectifs

#### Phase 2 : Validation Fonctionnelle (Cahier de Tests)

**Durée estimée :** 3 jours  
**Responsable :** Testeurs + Chef de Projet

**Actions :**
1. Exécution systématique de tous les scénarios du cahier de tests (sections 1.1, 1.2, 1.3)
2. Documentation des résultats dans un fichier de suivi :

   ```markdown
   | ID Test | Statut | Commentaires | Capture | Anomalie ID |
   |---------|--------|--------------|---------|-------------|
   | US-01   | ✅ OK  | RAS          | screenshot_us01.png | - |
   | US-02   | ❌ KO  | Message d'erreur peu clair | - | BUG-001 |
   | ...     |        |              |         |             |
   ```

3. Classification des anomalies :
   - **Bloquant** : empêche l'utilisation d'une fonction essentielle
   - **Majeur** : fonction dégradée mais contournable
   - **Mineur** : problème d'ergonomie ou visuel
   - **Amélioration** : suggestion non bloquante

**Critères de passage :**
- ✅ 100% des tests "Haute Priorité" et "Critique" passent
- ✅ 0 anomalie bloquante
- ✅ < 3 anomalies majeures

#### Phase 3 : Recette Utilisateur (UAT)

**Durée estimée :** 2 jours  
**Responsable :** Maître d'Ouvrage + Utilisateurs Pilotes

**Actions :**
1. Démonstration guidée des fonctionnalités
2. Tests en conditions réelles (données métier)
3. Validation ergonomique et UX
4. Retours utilisateurs documentés

**Critères de passage :**
- ✅ Fonctionnalités conformes aux attentes métier
- ✅ Expérience utilisateur satisfaisante
- ✅ Formation utilisateurs prévue

#### Phase 4 : Validation de Sécurité

**Durée estimée :** 1 jour  
**Responsable :** Expert Sécurité ou Équipe Technique

**Actions :**
1. Audit de sécurité applicative
   - Authentification robuste (Laravel Fortify)
   - Gestion des sessions sécurisée
   - Protection CSRF
   - Échappement des données (XSS)
   - Hashage des mots de passe (bcrypt)
   
2. Audit infrastructure
   - HTTPS activé (TLS 1.3)
   - En-têtes de sécurité (CSP, X-Frame-Options, etc.)
   - Pare-feu configuré
   - Sauvegardes automatiques

**Critères de passage :**
- ✅ Audit de sécurité validé
- ✅ Conformité RGPD (données personnelles)

### 2.5 Gestion des Anomalies

**Processus de traitement :**

```
1. DÉTECTION
   ↓
2. DOCUMENTATION (dans le tableau de suivi)
   - Description
   - Étapes de reproduction
   - Capture d'écran
   - Criticité
   ↓
3. PRIORISATION
   - Bloquant → Correction immédiate
   - Majeur → Correction avant recette
   - Mineur → Correction avant production ou backlog
   ↓
4. CORRECTION
   - Développement du correctif
   - Tests unitaires
   ↓
5. VÉRIFICATION
   - Re-test du scénario
   - Validation de la correction
   ↓
6. CLÔTURE
   - Mise à jour du statut dans le tableau
```

### 2.6 Jalons de Validation

| Jalon | Date Cible | Livrables |
|-------|-----------|-----------|
| **J0** | 8 mars 2026 | Début des tests - Environnement de recette prêt |
| **J+2** | 10 mars 2026 | Validation technique terminée - Rapport de tests automatisés |
| **J+5** | 13 mars 2026 | Validation fonctionnelle terminée - Tableau de suivi complété |
| **J+7** | 15 mars 2026 | UAT terminée - Retours utilisateurs documentés |
| **J+8** | 16 mars 2026 | Audit de sécurité terminé - Rapport de sécurité |
| **J+9** | 17 mars 2026 | **Signature du PV de Recette** |
| **J+10** | 18 mars 2026 | Déploiement en production |

### 2.7 Critères de Réussite Globaux

Pour que la recette soit validée, les conditions suivantes doivent être remplies :

- [x] **Taux de réussite des tests fonctionnels ≥ 95%**
- [x] **0 anomalie bloquante**
- [x] **≤ 3 anomalies majeures**
- [x] **Couverture de code ≥ 80%**
- [x] **Performance conforme (< 2s chargement pages)**
- [x] **Compatibilité navigateurs : Chrome, Firefox, Safari, Edge (dernières versions)**
- [x] **Responsive : Mobile, Tablette, Desktop**
- [x] **Accessibilité : Niveau AA WCAG 2.1 (minimum)**
- [x] **Sécurité : 0 vulnérabilité critique**
- [x] **Documentation : Complète et à jour**

---

## 3. Modèle de PV de Recette

### PROCÈS-VERBAL DE RECETTE

---

**Projet :** CESIZen - Application de gestion du stress et de la santé mentale  
**Version :** 1.0  
**Date de recette :** [JJ/MM/AAAA]  
**Lieu :** [Localisation ou "Visioconférence"]

---

#### 1. Participants

| Nom | Fonction | Organisme | Signature |
|-----|----------|-----------|-----------|
| [Nom MOA] | Maître d'Ouvrage | [Client] | |
| [Nom Chef Projet] | Chef de Projet MOE | [Équipe Dev] | |
| [Nom Technique] | Responsable Technique | [Équipe Dev] | |
| [Testeur 1] | Testeur Fonctionnel | [Client/MOE] | |

---

#### 2. Objet de la Recette

La présente recette a pour objet de valider la conformité de l'application **CESIZen** version **1.0** par rapport au cahier des charges et aux spécifications fonctionnelles définies.

**Modules testés :**
- ✅ Module Comptes Utilisateurs (Inscription, Connexion, Profil, Permissions)
- ✅ Module Informations (Pages de contenu dynamiques)
- ✅ Module Tableau de Bord (Statistiques et administration)

---

#### 3. Environnement de Test

| Élément | Valeur |
|---------|--------|
| **URL de recette** | https://recette.cesizen.fr |
| **Version applicative** | 1.0.0 (Commit: `abc123def`) |
| **Base de données** | MySQL 8.0.35 |
| **Serveur** | Nginx 1.24.0, PHP 8.2.16 |
| **Navigateurs testés** | Chrome 122, Firefox 123, Safari 17 |
| **Devices testés** | Desktop, iPhone 13, iPad Pro, Samsung Galaxy S23 |

---

#### 4. Résultats des Tests

##### 4.1 Tests Automatisés

```bash
Commande : php artisan test --coverage

Résultats :
✅ 157 tests passés sur 157
✅ Couverture de code : 84.3%
⏱️ Durée d'exécution : 12.45s
```

##### 4.2 Tests Fonctionnels

| Module | Total Tests | Réussis | Échoués | Taux Réussite |
|--------|-------------|---------|---------|---------------|
| **Comptes Utilisateurs** | 23 | 23 | 0 | ✅ 100% |
| **Informations** | 17 | 17 | 0 | ✅ 100% |
| **Tableau de Bord** | 11 | 10 | 1 | ⚠️ 91% |
| **TOTAL** | **51** | **50** | **1** | **✅ 98%** |

##### 4.3 Tests de Performance

| Métrique | Objectif | Résultat | Statut |
|----------|----------|----------|--------|
| Temps page accueil | < 2s | 1.2s | ✅ |
| Temps page dashboard | < 2s | 1.8s | ✅ |
| Temps login | < 1s | 0.6s | ✅ |
| Score Lighthouse | > 90 | 94 | ✅ |
| Charge 100 users | < 3s | 2.4s | ✅ |

##### 4.4 Tests de Sécurité

| Test | Résultat | Commentaire |
|------|----------|-------------|
| Injection SQL | ✅ Protégé | Eloquent ORM + Prepared Statements |
| XSS | ✅ Protégé | Échappement automatique Vue.js |
| CSRF | ✅ Protégé | Tokens Laravel Fortify |
| Authentification | ✅ Conforme | Bcrypt, rate limiting |
| HTTPS | ✅ Actif | TLS 1.3, certificat Let's Encrypt |
| Headers sécurité | ✅ Configurés | CSP, X-Frame-Options, HSTS |

---

#### 5. Anomalies Détectées

##### 5.1 Anomalies Bloquantes

**Aucune anomalie bloquante détectée** ✅

##### 5.2 Anomalies Majeures

| ID | Module | Description | Criticité | Statut | Correctif prévu |
|----|--------|-------------|-----------|--------|-----------------|
| **BUG-001** | Dashboard Admin | Export CSV génère un fichier vide pour > 1000 lignes | Majeure | 🔧 En cours | V1.0.1 (J+3) |

##### 5.3 Anomalies Mineures

| ID | Module | Description | Criticité | Statut | Correctif prévu |
|----|--------|-------------|-----------|--------|-----------------|
| **BUG-002** | Profil | Avatar utilisateur ne s'affiche pas sur Safari 16 | Mineure | 📋 Backlog | V1.1.0 |
| **BUG-003** | Informations | Espacement trop important entre paragraphes sur mobile | Mineure | 📋 Backlog | V1.1.0 |

##### 5.4 Améliorations Suggérées

- **AMÉLIO-001** : Ajouter un indicateur de force du mot de passe lors de l'inscription
- **AMÉLIO-002** : Permettre la recherche des pages dans le back-office admin
- **AMÉLIO-003** : Ajouter un mode sombre (dark mode)

---

#### 6. Conformité aux Exigences

| Exigence | Conforme | Commentaire |
|----------|----------|-------------|
| **Fonctionnalités spécifiées** | ✅ Oui | Toutes les fonctionnalités du cahier des charges sont présentes |
| **Design responsive** | ✅ Oui | Adapté à tous les formats d'écran |
| **Accessibilité WCAG 2.1 AA** | ✅ Oui | Score Lighthouse Accessibility : 96 |
| **Performance** | ✅ Oui | Objectifs de temps de réponse respectés |
| **Sécurité** | ✅ Oui | Conformité OWASP Top 10 |
| **Documentation** | ✅ Oui | Documentation technique et utilisateur livrées |

---

#### 7. Réserves et Conditions

**Réserves mineures :**
1. Correction du bug **BUG-001** (Export CSV) dans les 3 jours ouvrés suivant la signature du PV
2. Validation de la correction par un re-test avant déploiement en production

**Conditions de mise en production :**
1. ✅ Correction du bug BUG-001 validée
2. ✅ Formation des administrateurs effectuée (planning : [Date])
3. ✅ Plan de sauvegarde et de rollback documenté
4. ✅ Monitoring et alerting configurés

---

#### 8. Décision de Recette

**Au vu des résultats présentés, la recette de l'application CESIZen version 1.0 est :**

☐ **ACCEPTÉE SANS RÉSERVE**  
☑ **ACCEPTÉE AVEC RÉSERVES MINEURES** (détaillées en section 7)  
☐ **REFUSÉE** (anomalies bloquantes)

**Justification :**
L'application répond aux exigences fonctionnelles et non-fonctionnelles du cahier des charges. Le taux de réussite des tests (98%) est conforme aux objectifs. L'unique anomalie majeure (BUG-001) est non bloquante pour la mise en production et sera corrigée dans les 3 jours ouvrés.

---

#### 9. Échéancier Post-Recette

| Action | Date Cible | Responsable |
|--------|-----------|-------------|
| Correction BUG-001 | J+3 (20/03/2026) | Équipe Technique |
| Validation correctif BUG-001 | J+4 (21/03/2026) | Testeur |
| Formation administrateurs | J+5 (22/03/2026) | Chef de Projet |
| **Déploiement Production** | **J+7 (24/03/2026)** | **DevOps** |
| Support post-déploiement | J+7 à J+14 | Équipe Technique |

---

#### 10. Documents Annexes

- [x] Cahier de Tests complété avec résultats
- [x] Rapport de tests automatisés (Pest PHP)
- [x] Rapport de performance (Lighthouse)
- [x] Rapport d'audit de sécurité
- [x] Captures d'écran des anomalies
- [x] Documentation utilisateur
- [x] Documentation technique

---

#### 11. Signatures

**Pour le Maître d'Ouvrage :**

Nom : ________________________  
Fonction : ____________________  
Date : __________ / __________ / __________  
Signature :

---

**Pour le Maître d'Œuvre :**

Nom : ________________________  
Fonction : ____________________  
Date : __________ / __________ / __________  
Signature :

---

**Fait à [Ville], le [JJ/MM/AAAA]**

**En deux exemplaires originaux**

---

### ANNEXE A - Tableau Détaillé des Tests

#### Module Comptes Utilisateurs (23 tests)

| ID Test | Scénario | Priorité | Résultat | Commentaire |
|---------|----------|----------|----------|-------------|
| US-01 | Inscription réussie | Haute | ✅ OK | RAS |
| US-02 | Email déjà utilisé | Haute | ✅ OK | Message clair |
| US-03 | Email invalide | Moyenne | ✅ OK | Validation temps réel |
| US-04 | Mot de passe trop court | Haute | ✅ OK | RAS |
| US-05 | Champs vides | Haute | ✅ OK | Messages explicites |
| US-06 | Injection SQL tentée | Critique | ✅ OK | Aucune injection possible |
| US-07 | Connexion réussie (user) | Haute | ✅ OK | RAS |
| US-08 | Connexion réussie (admin) | Haute | ✅ OK | Redirection correcte |
| US-09 | Mot de passe incorrect | Haute | ✅ OK | Message générique (sécurité) |
| US-10 | Email inexistant | Haute | ✅ OK | Message générique (sécurité) |
| US-11 | Brute force (5 tentatives) | Critique | ✅ OK | Rate limiting actif |
| US-12 | Remember me activé | Moyenne | ✅ OK | Cookie persistant |
| US-13 | Modifier le nom | Moyenne | ✅ OK | Mise à jour immédiate |
| US-14 | Modifier l'email | Haute | ✅ OK | Vérification email envoyée |
| US-15 | Changer le mot de passe | Haute | ✅ OK | Hash bcrypt correct |
| US-16 | Ancien mot de passe incorrect | Haute | ✅ OK | Erreur claire |
| US-17 | Confirmation MDP différente | Moyenne | ✅ OK | Validation côté client et serveur |
| US-18 | Déconnexion simple | Haute | ✅ OK | Session détruite |
| US-19 | Accès page protégée après déco | Haute | ✅ OK | Redirection automatique |
| US-20 | Admin accède à /admin | Haute | ✅ OK | Accès autorisé |
| US-21 | User tente d'accéder à /admin | Critique | ✅ OK | Erreur 403 |
| US-22 | Admin désactive un user | Haute | ✅ OK | is_active = false |
| US-23 | User désactivé tente connexion | Haute | ✅ OK | Connexion refusée, message clair |

**Taux de réussite : 100% (23/23)**

---

### ANNEXE B - Plan de Rollback

En cas de problème critique en production, procédure de retour en arrière :

**Étape 1 : Détection (< 5 minutes)**
- Monitoring alerte
- Vérification rapide du problème

**Étape 2 : Décision (< 5 minutes)**
- Go/No-Go pour rollback
- Communication à l'équipe

**Étape 3 : Rollback (< 15 minutes)**
```bash
# 1. Basculer sur ancienne version du code
cd /var/www/cesizen
git checkout v0.9.5  # Version stable précédente
composer install --no-dev --optimize-autoloader

# 2. Restaurer la base de données (si migrations)
php artisan migrate:rollback --step=X

# 3. Rebuild assets
npm run build

# 4. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# 5. Redémarrer services
sudo systemctl restart php8.2-fpm
sudo systemctl reload nginx
```

**Étape 4 : Vérification (< 10 minutes)**
- Tests de fumée
- Monitoring stabilisé
- Communication aux utilisateurs

**Temps total rollback : < 35 minutes**

---

**FIN DU DOCUMENT**

**Document maintenu par :** Équipe Qualité CESIZen  
**Dernière mise à jour :** 9 Mars 2026  
**Contact :** qualite@cesizen.fr
