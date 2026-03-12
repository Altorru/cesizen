# 📚 Documentation CESIZen

Ce dossier contient toute la documentation officielle du projet CESIZen.

## 📄 Documents Disponibles

### 1. [Documentation Technique](./DOCUMENTATION_TECHNIQUE.md)

**Contenu :**
- ✅ **Modélisation Physique de la Base de Données (MLD)**
  - Schéma relationnel complet
  - Relations et contraintes
  - Diagrammes MLD
  
- ✅ **Comparatif des Solutions Techniques**
  - Architecture applicative (Monolithe vs SPA vs Microservices)
  - Framework Backend (Laravel vs Symfony vs NestJS)
  - Framework Frontend (Vue vs React vs Angular)
  - Système de Design (Shadcn-Vue vs Vuetify vs Quasar)
  - Base de données (MySQL vs PostgreSQL vs MongoDB)
  - **Argumentation détaillée pour chaque choix technique**
  
- ✅ **Guide d'Installation**
  - Prérequis système
  - Installation locale étape par étape
  - Configuration avancée (Horizon, Pail, etc.)
  - Commandes utiles
  - Résolution des problèmes courants
  - Installation avec Docker
  - Déploiement en production

### 2. [Cahier de Tests](./CAHIER_DE_TESTS.md)

**Contenu :**
- ✅ **Cahier de Tests Complet**
  
  **Module 1 : Comptes Utilisateurs (23 tests)**
  - Inscription (6 scénarios)
  - Connexion (6 scénarios)
  - Gestion du profil (5 scénarios)
  - Déconnexion (2 scénarios)
  - Permissions et rôles (4 scénarios)
  
  **Module 2 : Informations (17 tests)**
  - Consultation des pages (5 scénarios)
  - Création de pages admin (5 scénarios)
  - Modification de pages (4 scénarios)
  - Suppression de pages (3 scénarios)
  
  **Module 3 : Tableau de Bord - Facultatif (11 tests)**
  - Statistiques utilisateur (3 scénarios)
  - Dashboard admin (5 scénarios)
  - Notifications (3 scénarios)