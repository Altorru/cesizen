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

### 2. [Documentation de Livraison](./DOCUMENTATION_LIVRAISON.md)

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

- ✅ **Procédure de Validation**
  - Objectifs et acteurs
  - Environnements de test
  - 4 phases de validation (Technique, Fonctionnelle, UAT, Sécurité)
  - Gestion des anomalies
  - Jalons et critères de réussite

- ✅ **Modèle de PV de Recette**
  - Structure complète et professionnelle
  - Sections participants, résultats, anomalies
  - Décision de recette (accepté/refusé avec réserves)
  - Signatures et échéancier
  - Annexes (tableau détaillé des tests, plan de rollback)

## 🎯 Utilisation

### Pour les Développeurs

1. Consultez la [Documentation Technique](./DOCUMENTATION_TECHNIQUE.md) pour :
   - Comprendre l'architecture technique
   - Installer le projet en local
   - Connaître les choix techniques et leurs justifications

### Pour les Testeurs

1. Utilisez le [Cahier de Tests](./DOCUMENTATION_LIVRAISON.md#1-cahier-de-tests) pour :
   - Exécuter les scénarios de test
   - Documenter les anomalies
   - Suivre l'avancement des tests

### Pour les Chefs de Projet

1. Suivez la [Procédure de Validation](./DOCUMENTATION_LIVRAISON.md#2-procédure-de-validation) pour :
   - Organiser les phases de recette
   - Gérer les anomalies
   - Planifier les jalons

2. Utilisez le [Modèle de PV de Recette](./DOCUMENTATION_LIVRAISON.md#3-modèle-de-pv-de-recette) pour :
   - Formaliser la validation
   - Obtenir les signatures
   - Documenter les conditions de mise en production

## 📊 Statistiques

| Élément | Quantité |
|---------|----------|
| **Tests fonctionnels** | 51 scénarios |
| **Modules testés** | 3 (dont 1 facultatif) |
| **Phases de validation** | 4 phases |
| **Pages de documentation** | ~80 pages |

## 🔄 Mises à Jour

| Version | Date | Auteur | Modifications |
|---------|------|--------|---------------|
| 1.0 | 9 mars 2026 | Équipe Technique | Création initiale des deux documents |

## 📞 Contact

Pour toute question concernant cette documentation :
- **Email :** tech@cesizen.fr
- **Support :** support@cesizen.fr

---

**Note :** Ces documents sont conformes aux exigences du cahier des charges du projet CESIZen et constituent les livrables officiels pour la validation du projet.
