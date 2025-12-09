# AGENT_GUIDELINES for CESIZen Project

## 1. Contexte du Projet
- **Nom:** CESIZen
- **Objectif:** Application de gestion du stress et de la santé mentale pour le grand public.
- **Modèle de Projet:** Prototype "beau, simple, maintenable, évolutif".

## 2. Stack Technique
- **Backend:** Laravel (MVC, Eloquent ORM).
- **Frontend:** Vue.js (Single File Components), Shadcn-Vue (pour les composants UI), TailwindCSS (pour le stylisme).
- **Base de données:** (Mentionnez ici votre choix, ex: MySQL).
- **Authentification:** Laravel Breeze ou Sanctum (si API SPA) pour un démarrage rapide.

## 3. Principes de Design et Qualité
- **Design:** Moderne, épuré, agréable, "Mobile First" et "Responsive Design" impératifs. Utiliser les composants Shadcn-Vue pour l'uniformité.
- **Simplicité:** Prioriser les solutions simples et élégantes. Éviter la complexité inutile.
- **Maintenabilité:** Code clair, commenté, respect des conventions (PSR-12 pour PHP, Vue Style Guide).
- **Évolutivité:** Architecture modulaire, facile à étendre.
- **Sécurité:** Respect du RGPD, toutes les requêtes Web via HTTPS, cryptage des données sensibles (mots de passe, etc.).

## 4. Stratégie de Développement (TDD - Test-Driven Development)
- **TDD:** Non négociable. Toujours écrire les tests (unitaires, fonctionnels) *avant* l'implémentation du code.
- **Cycles Red-Green-Refactor:** Travailler par petites étapes : Écrire un test qui échoue (Red), écrire le code minimal pour qu'il passe (Green), refactoriser le code pour l'améliorer (Refactor).
- **Tests Ciblés:** Tester l'API exposée (entrées/sorties) plutôt que les détails d'implémentation.
- **Critères de "Done":** Une tâche n'est pas "done" si :
    - Le linter ne passe pas.
    - Un nouveau comportement n'a pas de tests pour le garantir.

## 5. Fonctionnalités à Implémenter (Focus Prototype Activité 2)

**A. Comptes Utilisateurs (Must-Have)**
- Enregistrement, connexion, déconnexion.
- Gestion basique du profil utilisateur.
- Gestion des rôles (utilisateur, administrateur).

**B. Informations (Must-Have)**
- Back-office CRUD pour les pages de contenu statique (par ex. "À propos", "Santé Mentale").
- Affichage des pages d'information sur le front-office.

**C. Exercice de Respiration (Non Programmable - Could-Have / Should-Have pour le prototype)**
- Implémentation visuelle de l'exercice de cohérence cardiaque (7-4-8, 5-0-5, 4-0-6).
- Uniquement côté front-end (Vue/Shadcn), sans interaction backend pour cette phase.

**D. Tracker d'Émotions (Chosen Facultative - Must-Have)**
- Enregistrement d'une émotion (principale, secondaire).
- Journal de bord pour visualiser ses émotions passées.
- Configuration des listes d'émotions par l'administrateur.

## 6. Instructions Additionnelles
- Utiliser le CLI Kiro pour interagir avec l'agent.
- Privilégier les composants Shadcn-Vue pour toute l'interface.
- Se concentrer sur la qualité du code et l'expérience utilisateur.
