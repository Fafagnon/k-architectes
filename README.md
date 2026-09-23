# K-ARCHITECTES — Plateforme Web Dynamique & Panneau d'Administration

Application web dynamique et back-office sur mesure pour le cabinet d'architecture **K-ARCHITECTES** (Lomé, Togo), convertie depuis la maquette statique approuvée vers **Laravel 11**.

---

## 1. Contexte & Identité Visuelle

- **Cabinet** : K-ARCHITECTES, fondé en juin 2016, inscrit à l'Ordre National des Architectes du Togo (ONAT).
- **Directeur Général** : Irénée KORTETE.
- **Localisation** : Agoè-Vakpossito, Rue NDE (Notre-Dame de l'Église), 28 BP 305 Télessou, Lomé, Togo.
- **Identité graphique stricte** :
  - Palette : `--noir` (#000), `--blanc` (#fff), `--calque` (#f5f5f5), `--beton` (#e6e6e6), `--graphite` (#444).
  - Typographie : Pile système sans-serif (Helvetica / Arial / Liberation Sans), zéro téléchargement externe.
  - Principes : **0 arrondi (`border-radius: 0`)**, **0 ombre portée**, distinction des plans par contraste de teintes, la photographie comme unique couleur du site.
  - Le panneau d'administration adopte fidèlement la même identité visuelle (vues Blade personnalisées, zéro package d'administration tiers intrusif).

---

## 2. Périmètre Réalisé vs Hors-Scope

### Réalisé (Dynamique & Back-Office)
- **Actualités (`/actualites`)** :
  - Liste paginée avec cartes `.actualite-card`.
  - Véritables pages dédiées par article (`/actualites/{article:slug}`) remplaçant l'ancienne modale JavaScript.
  - Fil d'Ariane, excerpt, temps de lecture, corps enrichi respectant la typographie existante (`h3`, `blockquote.citation-architecte + cite`, `ul.liste-points`).
  - Balises Open Graph & Twitter Cards dynamiques.
  - Boutons de partage social fins en noir et blanc (WhatsApp, LinkedIn, X, Facebook, Copie du lien avec retour visuel).
- **Opportunités (`/opportunites`)** :
  - Système complet d'offres d'emploi et de stages.
  - Liste avec statut (ouvert, fermé, brouillon) et état vide soigné.
  - Page détail (`/opportunites/{opportunity:slug}`) avec bouton « Postuler à cette offre » préremplissant le formulaire.
  - Formulaire `/postuler` avec champ `<select name="poste_vise">` peuplé dynamiquement depuis les offres ouvertes + candidatures spontanées.
- **Formulaires & Gestion en Admin (`/contact`, `/postuler`)** :
  - Les messages de contact et candidatures sont enregistrés de façon sécurisée en base de données avec leurs pièces jointes / CV (au lieu de simples formulaires tiers).
  - Gestion complète dans l'administration : marquage lu/non-lu, téléchargement direct des CV et pièces jointes, suivi des statuts de candidature (*unread*, *reviewed*, *contacted*, *rejected*).
- **Uploads d'images haute résolution (Architecture Pro)** :
  - Prise en charge jusqu'à **20 Mo** par fichier (JPG, JPEG, PNG, WEBP).
  - Redimensionnement et compression automatique côté serveur via `intervention/image` (max 2400px de large, conservation du ratio, qualité JPEG 85%).
  - Placeholder sobre en `--beton` uni avec légende en `--graphite` en l'absence d'image.
- **Panneau d'Administration Sur-Mesure (`/admin`)** :
  - Authentification dédiée via Laravel Breeze minimaliste.
  - Tableau de bord avec indicateurs clés (articles, offres, messages non lus, candidatures à traiter).
  - CRUD complet pour les actualités et opportunités avec confirmation de suppression.
  - Consultation et traitement des messages et candidatures reçus.
- **Compatibilité SEO & Redirections 301** :
  - Redirections 301 transparentes depuis toutes les anciennes URLs statiques (`/index.html`, `/actualites.html`, `/opportunites.html`, `/realisations.html`, `/contact.html`, `/postuler.html`, `/projet-*.html`).

### Périmètre Hors-Scope Assumé
- **Réalisations / Portfolio** : Conservé sous forme de templates Blade statiques avec les 6 projets existants et le composant diaporama maison en JavaScript pur.
- **Le Cabinet (`/le-cabinet`)** : Page de présentation conservée en template Blade statique selon les spécifications.

---

## 3. Prérequis Techniques

- **PHP** : >= 8.2 (recommandé : PHP 8.3 avec extensions `pdo_sqlite` ou `pdo_mysql`, `gd`, `fileinfo`, `mbstring`).
- **Composer** : >= 2.x
- **Node.js** : >= 18.x et **NPM**

---

## 4. Installation & Configuration

### 4.1 Cloner le dépôt et installer les dépendances
```bash
git clone https://github.com/Fafagnon/k-architectes.git
cd k-architectes
composer install
npm install
```

### 4.2 Configurer l'environnement
Copiez le fichier `.env.example` en `.env` :
```bash
cp .env.example .env
php artisan key:generate
```

Configurez les variables suivantes dans le `.env` avant d'exécuter les seeders :
```env
# Base de données (SQLite par défaut en local, MySQL en production)
DB_CONNECTION=sqlite
# Pour MySQL :
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=k_architectes
# DB_USERNAME=root
# DB_PASSWORD=secret

# Identifiants de l'administrateur initial
ADMIN_NAME="Irénée KORTETE"
ADMIN_EMAIL=archkortete@gmail.com
ADMIN_PASSWORD=admin1234
```

### 4.3 Créer la base de données et exécuter les migrations & seeders
Pour SQLite (par défaut) :
```bash
# Crée le fichier sqlite s'il n'existe pas
touch database/database.sqlite

# Exécute les migrations et les seeders
php artisan migrate --seed
```

Les seeders initialisent :
1. Le compte administrateur (`AdminUserSeeder`) avec les valeurs définies dans votre `.env`.
2. Les 4 articles réels verbatim du cabinet (`ArticleSeeder`) avec formatage riche et citations.
3. Les opportunités d'emploi et de stage réalistes du cabinet (`OpportunitySeeder`).

### 4.4 Créer le lien symbolique de stockage
```bash
php artisan storage:link
```

### 4.5 Compiler les assets front-end
```bash
npm run build
```

### 4.6 Lancer le serveur de développement
```bash
php artisan serve
```
L'application est alors accessible sur :
- **Site public** : `http://127.0.0.1:8000` (ou le port indiqué par artisan)
- **Panneau d'administration** : `http://127.0.0.1:8000/admin`

---

## 5. Suite de Tests Automatisés

Une suite complète de tests fonctionnels (Feature tests) valide l'ensemble du périmètre :
- Chargement des pages publiques et navigation active.
- Redirections 301 des anciennes URL `.html`.
- Affichage des listes et fiches détaillées d'articles et d'opportunités.
- Soumission et persistance des messages de contact et des candidatures avec upload de CV.
- Authentification administrateur, contrôle d'accès invité (`guest`).
- CRUD des actualités et opportunités avec test d'upload d'image simulé.
- Traitement et consultation des messages et candidatures dans le back-office.

Exécuter la suite de tests :
```bash
php artisan test
```

---

## 6. Structure Principale du Projet

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/               # Contrôleurs du back-office (Auth, Articles, Opportunités, Messages, Candidatures)
│   │   ├── HomeController.php
│   │   ├── ArticleController.php
│   │   ├── OpportunityController.php
│   │   ├── ProjectController.php
│   │   ├── ContactController.php
│   │   └── ApplicationController.php
│   ├── Models/                  # Modèles Eloquent (Article, Opportunity, ContactMessage, JobApplication, User)
│   └── Services/
│       └── ImageService.php     # Service de traitement et redimensionnement d'images (Intervention Image v4)
├── database/
│   ├── migrations/              # Schémas de base de données
│   └── seeders/                 # Seeders (AdminUserSeeder, ArticleSeeder, OpportunitySeeder)
├── public/
│   ├── assets/                  # Feuilles de style, scripts, images et logo du cabinet
│   ├── storage/                 # Lien symbolique vers storage/app/public
│   └── index.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php    # Layout public (header, nav dynamique, footer)
│   │   │   └── admin.blade.php  # Layout admin sobre noir/blanc
│   │   ├── pages/               # Vues publiques (home, cabinet, realisations, actualités, opportunités, contact, etc.)
│   │   └── admin/               # Vues du back-office (dashboard, articles, opportunités, messages, candidatures)
└── routes/
    └── web.php                  # Routes publiques, redirections 301, routes d'administration protégées
```

---

## 7. Auteur & Licence

- Développé pour : **K-ARCHITECTES** (Lomé, Togo)
- Framework : **Laravel 11**
- Licence : Propriétaire / Réservé au cabinet K-ARCHITECTES.
