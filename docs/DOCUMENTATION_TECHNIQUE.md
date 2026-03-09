# Documentation Technique - CESIZen

**Version :** 1.0  
**Date :** 9 Mars 2026  
**Projet :** Application de gestion du stress et de la santé mentale

---

## Table des Matières

1. [Modélisation Physique de la Base de Données (MLD)](#1-modélisation-physique-de-la-base-de-données-mld)
2. [Comparatif des Solutions Techniques](#2-comparatif-des-solutions-techniques)
3. [Guide d'Installation](#3-guide-dinstallation)

---

## 1. Modélisation Physique de la Base de Données (MLD)

### 1.1 Schéma Relationnel

```
USERS
-----
id: BIGINT UNSIGNED [PK]
uuid: CHAR(36) [UNIQUE]
name: VARCHAR(255)
email: VARCHAR(255) [UNIQUE]
role: ENUM('user', 'admin') [DEFAULT 'user']
is_active: BOOLEAN [DEFAULT true]
email_verified_at: TIMESTAMP [NULL]
password: VARCHAR(255)
remember_token: VARCHAR(100) [NULL]
created_at: TIMESTAMP
updated_at: TIMESTAMP

CONTENT_PAGES
-------------
id: CHAR(36) [PK]
slug: VARCHAR(255) [UNIQUE]
title: VARCHAR(255)
content: TEXT
is_published: BOOLEAN [DEFAULT false]
published_at: TIMESTAMP [NULL]
created_by: BIGINT UNSIGNED [FK -> USERS.id]
created_at: TIMESTAMP
updated_at: TIMESTAMP

PASSWORD_RESET_TOKENS
---------------------
email: VARCHAR(255) [PK]
token: VARCHAR(255)
created_at: TIMESTAMP [NULL]

SESSIONS
--------
id: VARCHAR(255) [PK]
user_id: BIGINT UNSIGNED [FK -> USERS.id, NULL]
ip_address: VARCHAR(45) [NULL]
user_agent: TEXT [NULL]
payload: LONGTEXT
last_activity: INTEGER [INDEX]

CACHE
-----
key: VARCHAR(255) [PK]
value: MEDIUMTEXT
expiration: INTEGER

CACHE_LOCKS
-----------
key: VARCHAR(255) [PK]
owner: VARCHAR(255)
expiration: INTEGER

JOBS
----
id: BIGINT UNSIGNED [PK, AUTO_INCREMENT]
queue: VARCHAR(255) [INDEX]
payload: LONGTEXT
attempts: TINYINT UNSIGNED
reserved_at: INTEGER UNSIGNED [NULL]
available_at: INTEGER UNSIGNED
created_at: INTEGER UNSIGNED

JOB_BATCHES
-----------
id: VARCHAR(255) [PK]
name: VARCHAR(255)
total_jobs: INTEGER
pending_jobs: INTEGER
failed_jobs: INTEGER
failed_job_ids: LONGTEXT
options: MEDIUMTEXT [NULL]
cancelled_at: INTEGER [NULL]
created_at: INTEGER
finished_at: INTEGER [NULL]

FAILED_JOBS
-----------
id: BIGINT UNSIGNED [PK, AUTO_INCREMENT]
uuid: VARCHAR(255) [UNIQUE]
connection: TEXT
queue: TEXT
payload: LONGTEXT
exception: LONGTEXT
failed_at: TIMESTAMP [DEFAULT CURRENT_TIMESTAMP]
```

### 1.2 Relations et Contraintes

**Relations :**
- `CONTENT_PAGES.created_by` → `USERS.id` (1:N) - ON DELETE CASCADE
- `SESSIONS.user_id` → `USERS.id` (N:1) - NULLABLE

**Index :**
- `USERS.email` : UNIQUE
- `USERS.uuid` : UNIQUE
- `CONTENT_PAGES.slug` : UNIQUE
- `SESSIONS.user_id` : INDEX
- `SESSIONS.last_activity` : INDEX
- `JOBS.queue` : INDEX

**Contraintes métier :**
- Email utilisateur : unique et validé
- Role utilisateur : uniquement 'user' ou 'admin'
- Slug des pages : unique, URL-friendly
- Les pages de contenu doivent avoir un créateur (relation obligatoire)
- Suppression en cascade des pages lors de la suppression d'un utilisateur

### 1.3 Diagramme MLD

```
┌─────────────────────────┐
│       USERS             │
├─────────────────────────┤
│ PK  id                  │
│     uuid (unique)       │
│     name                │
│     email (unique)      │
│     role                │
│     is_active           │
│     email_verified_at   │
│     password            │
│     remember_token      │
│     timestamps          │
└───────────┬─────────────┘
            │
            │ 1:N (created_by)
            │
            ↓
┌─────────────────────────┐
│    CONTENT_PAGES        │
├─────────────────────────┤
│ PK  id (uuid)           │
│     slug (unique)       │
│     title               │
│     content             │
│     is_published        │
│     published_at        │
│ FK  created_by          │
│     timestamps          │
└─────────────────────────┘
```

---

## 2. Comparatif des Solutions Techniques

### 2.1 Architecture Applicative

#### 2.1.1 Options Envisagées

| Critère | **Monolithe Laravel + Inertia (CHOISI)** | SPA + API REST | Microservices |
|---------|-------------------------------------------|----------------|---------------|
| **Complexité** | ⭐⭐ Moyenne | ⭐⭐⭐ Élevée | ⭐⭐⭐⭐ Très élevée |
| **Temps de développement** | ⭐⭐⭐⭐⭐ Rapide (2-3 mois) | ⭐⭐⭐ Moyen (4-6 mois) | ⭐ Lent (6+ mois) |
| **Maintenabilité** | ⭐⭐⭐⭐ Excellente | ⭐⭐⭐ Bonne | ⭐⭐ Moyenne |
| **Performance** | ⭐⭐⭐⭐ Très bonne | ⭐⭐⭐⭐ Très bonne | ⭐⭐⭐⭐⭐ Excellente |
| **Coût d'hébergement** | ⭐⭐⭐⭐⭐ Faible | ⭐⭐⭐ Moyen | ⭐ Élevé |
| **Scalabilité** | ⭐⭐⭐ Bonne | ⭐⭐⭐⭐ Très bonne | ⭐⭐⭐⭐⭐ Excellente |
| **SEO** | ⭐⭐⭐⭐⭐ Excellent (SSR) | ⭐⭐ Faible (CSR) | ⭐⭐⭐ Moyen |
| **Expérience développeur** | ⭐⭐⭐⭐⭐ Excellente | ⭐⭐⭐ Bonne | ⭐⭐ Complexe |

**Argumentation du choix final : Laravel + Inertia.js**

✅ **Avantages retenus :**
- **Rapidité de développement** : Inertia.js élimine le besoin d'une API, réduisant le code de 40%
- **Expérience moderne** : Réactivité de Vue.js sans la complexité d'un SPA complet
- **SEO natif** : Rendu côté serveur sans configuration supplémentaire
- **Sécurité renforcée** : Pas d'exposition d'API publique, CSRF natif
- **Maintenance facilitée** : Un seul codebase, pas de duplication backend/frontend
- **Coût optimisé** : Un seul serveur nécessaire (vs. 2+ pour SPA+API)
- **Stack mature** : Laravel + Vue = large communauté et documentation

❌ **Inconvénients assumés :**
- Scalabilité horizontale plus complexe qu'avec microservices (non nécessaire à court terme)
- Moins adapté aux applications mobiles natives (non dans le scope actuel)

### 2.2 Framework Backend

| Critère | **Laravel 12 (CHOISI)** | Symfony | Node.js (NestJS) |
|---------|-------------------------|---------|------------------|
| **Maturité** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Documentation** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Écosystème** | ⭐⭐⭐⭐⭐ (Forge, Horizon, etc.) | ⭐⭐⭐⭐ | ⭐⭐⭐ |
| **ORM** | ⭐⭐⭐⭐⭐ Eloquent (intuitif) | ⭐⭐⭐⭐ Doctrine (puissant) | ⭐⭐⭐ TypeORM |
| **Authentification** | ⭐⭐⭐⭐⭐ Fortify (intégré) | ⭐⭐⭐ LexikJWT | ⭐⭐⭐ Passport |
| **Courbe d'apprentissage** | ⭐⭐⭐⭐ Douce | ⭐⭐ Raide | ⭐⭐⭐ Moyenne |
| **Performance** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |

**Choix : Laravel 12**
- Écosystème complet (Fortify, Horizon, Pail, Pint)
- Eloquent ORM très intuitif
- Convention over configuration
- Excellente pour prototypes rapides et maintenables

### 2.3 Framework Frontend

| Critère | **Vue 3 + TypeScript (CHOISI)** | React + TS | Angular |
|---------|----------------------------------|------------|---------|
| **Courbe d'apprentissage** | ⭐⭐⭐⭐⭐ Douce | ⭐⭐⭐ Moyenne | ⭐⭐ Raide |
| **Performance** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Taille bundle** | ⭐⭐⭐⭐ Léger | ⭐⭐⭐ Moyen | ⭐⭐ Lourd |
| **Intégration Inertia** | ⭐⭐⭐⭐⭐ Native | ⭐⭐⭐⭐ Bonne | ⭐⭐ Moyenne |
| **Écosystème UI** | ⭐⭐⭐⭐⭐ Shadcn-Vue, Nuxt UI | ⭐⭐⭐⭐⭐ Shadcn, Material | ⭐⭐⭐⭐ Material |
| **Two-way binding** | ⭐⭐⭐⭐⭐ v-model | ⭐⭐ useState | ⭐⭐⭐⭐⭐ ngModel |

**Choix : Vue 3 avec TypeScript**
- Syntaxe intuitive et progressive
- Composition API moderne (performance)
- Excellente intégration avec Inertia.js
- Écosystème UI riche (Shadcn-Vue, Nuxt UI)

### 2.4 Système de Design

| Solution | **Shadcn-Vue + TailwindCSS (CHOISI)** | Vuetify | Quasar |
|----------|----------------------------------------|---------|--------|
| **Personnalisation** | ⭐⭐⭐⭐⭐ Totale | ⭐⭐⭐ Limitée | ⭐⭐⭐⭐ Bonne |
| **Accessibilité** | ⭐⭐⭐⭐⭐ WAI-ARIA natif | ⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Taille bundle** | ⭐⭐⭐⭐⭐ Léger (tree-shaking) | ⭐⭐ Lourd | ⭐⭐⭐ Moyen |
| **Mobile-first** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Documentation** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |

**Choix : Shadcn-Vue + TailwindCSS v4**
- Composants headless personnalisables à 100%
- Accessibilité WAI-ARIA native (Radix UI)
- Design moderne et épuré
- Tailwind = utility-first, responsive natif

### 2.5 Base de Données

| Base | **MySQL 8 (CHOISI)** | PostgreSQL | MongoDB |
|------|----------------------|------------|---------|
| **Maturité** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Performance lectures** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Performance écritures** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Transactions ACID** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Coût hébergement** | ⭐⭐⭐⭐⭐ Faible | ⭐⭐⭐⭐ Moyen | ⭐⭐⭐ Moyen |
| **Support Laravel** | ⭐⭐⭐⭐⭐ Natif | ⭐⭐⭐⭐⭐ Natif | ⭐⭐⭐ MongoDB |

**Choix : MySQL 8**
- Base de données relationnelle mature et fiable
- Performance optimale pour lectures (cas d'usage principal)
- Coût d'hébergement le plus faible (disponible partout)
- Support natif excellent dans Laravel Eloquent

### 2.6 Récapitulatif des Choix

```
┌─────────────────────────────────────────────────┐
│            STACK TECHNIQUE RETENUE              │
├─────────────────────────────────────────────────┤
│  Backend      Laravel 12 (PHP 8.2+)             │
│  Frontend     Vue 3 + TypeScript                │
│  Bridge       Inertia.js v2                     │
│  UI           Shadcn-Vue + TailwindCSS v4       │
│  Base         MySQL 8.0+                        │
│  Auth         Laravel Fortify                   │
│  Queue        Laravel Horizon                   │
│  Build        Vite 7                            │
│  Tests        Pest PHP                          │
│  Lint/Format  Pint + ESLint + Prettier          │
└─────────────────────────────────────────────────┘
```

---

## 3. Guide d'Installation

### 3.1 Prérequis Système

#### 3.1.1 Configuration Minimale

**Serveur de développement :**
- **OS** : Linux, macOS, Windows (via WSL2)
- **CPU** : 2 cœurs minimum
- **RAM** : 4 GB minimum (8 GB recommandé)
- **Disque** : 2 GB d'espace libre

**Logiciels requis :**
- **PHP** : ≥ 8.2 avec extensions :
  - `pdo_mysql`, `mbstring`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `tokenizer`
- **Composer** : ≥ 2.7
- **Node.js** : ≥ 20.x LTS
- **npm** : ≥ 10.x
- **MySQL** : ≥ 8.0 ou MariaDB ≥ 10.6
- **Git** : ≥ 2.40

#### 3.1.2 Vérification des Prérequis

```bash
# Vérifier PHP
php -v  # Doit afficher ≥ 8.2

# Vérifier les extensions PHP
php -m | grep -E "pdo_mysql|mbstring|xml|json"

# Vérifier Composer
composer --version  # Doit afficher ≥ 2.7

# Vérifier Node.js et npm
node -v  # Doit afficher ≥ v20.x
npm -v   # Doit afficher ≥ 10.x

# Vérifier MySQL
mysql --version  # Doit afficher ≥ 8.0
```

### 3.2 Installation Locale - Étape par Étape

#### Étape 1 : Cloner le Projet

```bash
# Cloner le dépôt
git clone https://github.com/votre-org/cesizen.git
cd cesizen

# Se positionner sur la branche principale
git checkout main
```

#### Étape 2 : Configuration de l'Environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Éditer le fichier .env
nano .env  # ou vim, code, etc.
```

**Configuration minimale du `.env` :**

```env
APP_NAME=CESIZen
APP_ENV=local
APP_KEY=  # Sera généré à l'étape suivante
APP_DEBUG=true
APP_TIMEZONE=Europe/Paris
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cesizen
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe

SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=log  # Pour le dev, les emails seront loggés
```

#### Étape 3 : Créer la Base de Données

```bash
# Se connecter à MySQL
mysql -u root -p

# Dans le shell MySQL
CREATE DATABASE cesizen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

#### Étape 4 : Installation des Dépendances Backend

```bash
# Installer les dépendances PHP
composer install

# Générer la clé d'application
php artisan key:generate

# Optimiser l'auto-loader
composer dump-autoload
```

#### Étape 5 : Installation des Dépendances Frontend

```bash
# Installer les dépendances Node.js
npm install

# Vérifier que tout est bien installé
npm list vue @inertiajs/vue3
```

#### Étape 6 : Migrations et Seeders

```bash
# Exécuter les migrations
php artisan migrate

# (Optionnel) Remplir avec des données de test
php artisan db:seed

# Créer un utilisateur admin par défaut
php artisan db:seed --class=AdminUserSeeder
```

**Compte admin créé :**
- Email : `admin@cesizen.fr`
- Mot de passe : `admin123` (à changer en production)

#### Étape 7 : Compilation des Assets

```bash
# En mode développement (avec hot reload)
npm run dev

# OU en mode build unique
npm run build
```

#### Étape 8 : Lancer le Serveur de Développement

**Terminal 1 - Serveur PHP :**
```bash
php artisan serve
# Serveur accessible sur http://localhost:8000
```

**Terminal 2 - Vite dev server (si npm run dev) :**
```bash
npm run dev
# Hot reload actif
```

**Terminal 3 - Queue worker (optionnel) :**
```bash
php artisan queue:work
# Pour traiter les jobs asynchrones
```

#### Étape 9 : Vérification de l'Installation

**Tests automatiques :**
```bash
# Lancer les tests Pest
php artisan test

# Vérifier la qualité du code
./vendor/bin/pint --test
./vendor/bin/phpstan analyse

# Tests frontend
npm run lint
```

**Vérifications manuelles :**
1. Ouvrir http://localhost:8000
2. Vérifier l'affichage de la page d'accueil
3. Tester l'inscription (http://localhost:8000/register)
4. Tester la connexion (http://localhost:8000/login)
5. Accéder au dashboard admin (http://localhost:8000/admin)

### 3.3 Configuration Avancée

#### 3.3.1 Configuration de la Queue (Horizon)

```bash
# Installer Horizon (déjà dans composer.json)
php artisan horizon:install

# Publier la configuration
php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"

# Lancer Horizon
php artisan horizon
```

Accéder au dashboard : http://localhost:8000/horizon

#### 3.3.2 Configuration des Logs (Pail)

```bash
# Surveiller les logs en temps réel
php artisan pail
```

#### 3.3.3 Optimisation pour Production

```bash
# Mettre le .env en production
APP_ENV=production
APP_DEBUG=false

# Cacher la configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build optimisé frontend
npm run build

# Optimiser l'autoloader Composer
composer install --optimize-autoloader --no-dev
```

### 3.4 Commandes Utiles

```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Formater le code PHP
./vendor/bin/pint

# Formater le code JS/Vue
npm run format

# Analyser le code statiquement
./vendor/bin/phpstan analyse

# Créer un nouveau modèle avec migration
php artisan make:model NomModele -m

# Créer un nouveau contrôleur
php artisan make:controller NomController

# Créer une nouvelle migration
php artisan make:migration create_nom_table

# Lister toutes les routes
php artisan route:list
```

### 3.5 Résolution des Problèmes Courants

#### Problème : "Class not found"
```bash
composer dump-autoload
php artisan config:clear
```

#### Problème : Erreur de permission sur storage/
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Problème : npm install échoue
```bash
rm -rf node_modules package-lock.json
npm cache clean --force
npm install
```

#### Problème : Les assets ne se chargent pas
```bash
# Vérifier que Vite est lancé
npm run dev

# Ou builder les assets
npm run build
```

#### Problème : Erreur de connexion MySQL
```bash
# Vérifier que MySQL est lancé
sudo systemctl status mysql

# Tester la connexion
mysql -u root -p -e "SHOW DATABASES;"

# Vérifier les credentials dans .env
```

### 3.6 Installation avec Docker (Alternative)

**Utiliser Laravel Sail :**

```bash
# Installer les dépendances via Docker
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

# Copier le .env
cp .env.example .env

# Démarrer les conteneurs
./vendor/bin/sail up -d

# Générer la clé
./vendor/bin/sail artisan key:generate

# Migrer la base
./vendor/bin/sail artisan migrate --seed

# Installer npm
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

L'application sera accessible sur : http://localhost

### 3.7 Déploiement en Production

#### 3.7.1 Checklist Pré-Déploiement

- [ ] `APP_ENV=production` dans `.env`
- [ ] `APP_DEBUG=false` dans `.env`
- [ ] `APP_URL` configuré avec le domaine final
- [ ] Certificat SSL configuré (HTTPS)
- [ ] Base de données de production créée
- [ ] Credentials de BDD de production dans `.env`
- [ ] `php artisan config:cache` exécuté
- [ ] `php artisan route:cache` exécuté
- [ ] `npm run build` exécuté
- [ ] Tests passants (`php artisan test`)

#### 3.7.2 Configuration Serveur Recommandée

**NGINX Configuration :**

```nginx
server {
    listen 80;
    server_name cesizen.fr www.cesizen.fr;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name cesizen.fr www.cesizen.fr;
    root /var/www/cesizen/public;

    ssl_certificate /etc/letsencrypt/live/cesizen.fr/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/cesizen.fr/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 3.7.3 Configuration PHP-FPM

```ini
; /etc/php/8.2/fpm/pool.d/www.conf
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 500
```

#### 3.7.4 Supervision (Systemd pour Queue)

```ini
; /etc/systemd/system/cesizen-queue.service
[Unit]
Description=CESIZen Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/cesizen/artisan queue:work --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

```bash
# Activer et démarrer le service
sudo systemctl enable cesizen-queue
sudo systemctl start cesizen-queue
sudo systemctl status cesizen-queue
```

---

## Annexes

### A. Structure des Répertoires

```
cesizen/
├── app/                    # Code métier Laravel
│   ├── Http/              # Contrôleurs, Middleware, Requests
│   ├── Models/            # Modèles Eloquent
│   └── Providers/         # Service Providers
├── config/                # Configuration Laravel
├── database/              # Migrations, Seeders, Factories
├── public/                # Point d'entrée web (index.php)
├── resources/             # Vues et assets
│   ├── css/              # Styles
│   ├── js/               # Code Vue.js/TypeScript
│   └── views/            # Layouts Blade
├── routes/                # Définition des routes
├── storage/               # Fichiers générés, logs, cache
├── tests/                 # Tests Pest
└── vendor/                # Dépendances Composer
```

### B. Commandes Artisan Personnalisées

*(À documenter si des commandes custom sont créées)*

### C. Variables d'Environnement

Liste complète des variables `.env` :

```env
# Application
APP_NAME=CESIZen
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_TIMEZONE=Europe/Paris
APP_URL=https://cesizen.fr

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cesizen_prod
DB_USERNAME=cesizen_user
DB_PASSWORD=***

# Cache
CACHE_STORE=database
CACHE_PREFIX=cesizen

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=database

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=noreply@cesizen.fr
MAIL_PASSWORD=***
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@cesizen.fr
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

---

**Document maintenu par :** Équipe Technique CESIZen  
**Dernière mise à jour :** 9 Mars 2026
