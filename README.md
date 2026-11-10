<div align="center">

# 📦 TechStock

**Application de gestion de parc informatique**

Suivi des équipements, des salles, des catégories et des interventions de maintenance.

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4?style=flat-square&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)
[![Tests](https://img.shields.io/badge/tests-77%20passing-success?style=flat-square)]()
[![License](https://img.shields.io/badge/license-MIT-blue?style=flat-square)](LICENSE)

</div>

---

## 📋 Sommaire

- [À propos](#à-propos)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Structure du projet](#structure-du-projet)
- [Base de données](#base-de-données)
- [Routes](#routes)
- [Tests](#tests)
- [Choix techniques](#choix-techniques)
- [Pistes d'évolution](#pistes-dévolution)
- [Licence](#licence)

---

## À propos

**TechStock** est une application web de gestion de parc informatique, pensée pour
suivre le matériel d'une entreprise ou d'un établissement scolaire : combiens
d'ordinateurs, dans quelles salles, dans quel état, et avec quel historique de
maintenance.

L'interface est en français, légère et **sans JavaScript** : tout fonctionne en
HTML et CSS, ce qui garantit un chargement rapide et un usage possible sur
poste ancien comme sur mobile.

---

## Fonctionnalités

### Tableau de bord

Page d'accueil avec une vue d'ensemble du parc : nombre d'équipements, dont en
panne, nombre de salles, nombre d'interventions, dernières interventions et
liste des salles.

### Équipements

- Liste complète avec **recherche** (nom, marque, numéro de série), **filtre par
  état** et **filtre par salle**, le tout dans un formulaire GET classique.
- **Pagination** qui conserve les filtres, avec flèches en icônes et libellés
  français.
- Fiche détaillée : informations, catégories, historique des interventions.
- Création et modification avec validation complète.
- Suppression protégée par une page de confirmation.

### Salles

- Liste en cartes avec le nombre d'équipements et la capacité.
- Détail d'une salle : matériel présent, taux d'occupation.
- Création, modification, suppression.

### Catégories

- Classification du matériel (portables, postes fixes, écrans, imprimantes…).
- Détail avec la liste des équipements rattachés.
- Création, modification, suppression (le matériel n'est pas supprimé).

### Interventions

Pour chaque équipement : ajout d'une intervention datée (maintenance, panne ou
réparation) avec commentaire, et historique trié du plus récent au plus ancien.

### Common

- Interface **responsive** (les tableaux restent lisibles sur mobile).
- **Accessibilité** : libellés de formulaire, noms accessibles pour les boutons,
  navigation clavier, page 404 personnalisée.
- Messages de validation **en français**.
- Thème clair / sombre automatique selon les préférences du système.

---

## Stack technique

| Élément | Version |
|---|---|
| PHP | ^8.3 |
| Laravel | ^13.8 |
| Bootstrap | ^5.3 (compilé en local) |
| Bootstrap Icons | ^1.11 |
| Sass | ^1.108 |
| Vite | ^8.0 |
| PHPUnit | ^12.5 |
| Base de données | SQLite (par défaut) |

---

## Installation

### Prérequis

- **PHP** ≥ 8.3 avec les extensions `sqlite3`, `mbstring`, `dom`
- **Composer** ≥ 2
- **Node.js** ≥ 20 et **npm**

### Étapes

```bash
# 1. Récupérer le projet
git clone <url-du-depot>
cd gestion-parl_infor

# 2. Dépendances PHP
composer install

# 3. Dépendances JS
npm install

# 4. Fichier d'environnement
cp .env.example .env
php artisan key:generate

# 5. Base de données
touch database/database.sqlite
php artisan migrate --seed      # migration + données de démonstration

# 6. Compiler les assets (obligatoire : le CSS est servi en local)
npm run build

# 7. Lancer le serveur
php artisan serve
```

L'application est alors disponible sur <http://127.0.0.1:8000>.

> **Note** — `npm run build` est indispensable : Bootstrap et les polices sont
> compilés localement, l'application ne dépend d'aucun CDN externe.

### Développement

```bash
npm run dev        # serveur Vite avec rechargement à chaud
php artisan serve  # dans un second terminal
```

---

## Utilisation

### Compte utilisateur

La base est fournie avec un compte de démonstration :

| Champ | Valeur |
|---|---|
| Email | `admin@techstock.local` |
| Mot de passe | `password` |

> ⚠️ **L'application n'a pas encore de page de connexion** : la route
> d'authentification est à brancher (le modèle `User` et la configuration
> `auth` sont déjà en place). Voir [Pistes d'évolution](#pistes-dévolution).

### Données de démonstration

`php artisan migrate:fresh --seed` réinitialise la base et génère :
6 salles, 7 catégories, 28 équipements et 45 interventions.

---

## Structure du projet

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CategoryController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── DeviceController.php
│   │   │   ├── InterventionController.php
│   │   │   └── RoomController.php
│   │   └── Requests/            # validation + messages en français
│   └── Models/
│       ├── Category.php
│       ├── Device.php
│       ├── Intervention.php
│       └── Room.php
├── database/
│   ├── factories/                # factories pour les tests
│   ├── migrations/
│   └── seeders/
├── lang/fr/pagination.php        # traduction de la pagination
├── public/fonts/                 # police Instrument Sans (auto-hébergée)
├── resources/
│   ├── css/app.scss              # styles de l'application
│   └── views/
│       ├── categories/
│       ├── components/           # layout, en-tête de page
│       ├── devices/
│       ├── errors/               # page 404
│       ├── partials/
│       ├── rooms/
│       ├── vendor/pagination/    # pagination Bootstrap personnalisée
│       ├── confirm-delete.blade.php
│       └── dashboard.blade.php
├── routes/web.php
└── tests/Feature/                # 77 tests
```

---

## Base de données

### `rooms` — Salles

| Champ | Type | Contraintes |
|---|---|---|
| `id` | integer | clé primaire |
| `nom` | string | |
| `batiment` | string | |
| `capacite` | integer | |
| `timestamps` | | |

### `categories` — Catégories

| Champ | Type | Contraintes |
|---|---|---|
| `id` | integer | clé primaire |
| `nom` | string | |
| `timestamps` | | |

### `devices` — Équipements

| Champ | Type | Contraintes |
|---|---|---|
| `id` | integer | clé primaire |
| `nom` | string | |
| `marque` | string | |
| `numero_serie` | string | **unique** |
| `etat` | string | `neuf`, `bon` ou `en panne` |
| `date_achat` | date | |
| `description` | text | nullable |
| `room_id` | foreignId | → `rooms.id`, suppression en cascade |
| `timestamps` | | |

### `category_device` — Table pivot

Relation **N-N** entre les catégories et les équipements.

### `interventions` — Interventions

| Champ | Type | Contraintes |
|---|---|---|
| `id` | integer | clé primaire |
| `date` | date | |
| `type` | string | `maintenance`, `panne` ou `reparation` |
| `commentaire` | text | nullable |
| `device_id` | foreignId | → `devices.id`, suppression en cascade |
| `timestamps` | | |

### Relations Eloquent

```
Room      ── hasMany ──────▶ Device
Category  ── belongsToMany ─▶ Device   (via category_device)
Device    ── hasMany ──────▶ Intervention
Device    ── belongsTo ────▶ Room
```

---

## Routes

| Méthode | URL | Rôle |
|---|---|---|
| `GET` | `/` | Tableau de bord |
| `GET` | `/devices` | Liste des équipements (recherche + filtres) |
| `GET` | `/devices/create` | Formulaire de création |
| `POST` | `/devices` | Enregistrement |
| `GET` | `/devices/{device}` | Fiche d'un équipement |
| `GET` | `/devices/{device}/edit` | Formulaire de modification |
| `PUT` | `/devices/{device}` | Mise à jour |
| `GET` | `/devices/{device}/delete` | Confirmation de suppression |
| `DELETE` | `/devices/{device}` | Suppression |
| `POST` | `/devices/{device}/interventions` | Ajout d'une intervention |
| `GET` | `/rooms` · `/rooms/create` · `/rooms/{room}` · `/rooms/{room}/edit` · `/rooms/{room}/delete` | Salles |
| `POST` `PUT` `DELETE` | `/rooms` · `/rooms/{room}` | Écriture sur les salles |
| `GET` | `/categories` · `/categories/create` · `/categories/{category}` · `/categories/{category}/edit` · `/categories/{category}/delete` | Catégories |
| `POST` `PUT` `DELETE` | `/categories` · `/categories/{category}` | Écriture sur les catégories |

Liste complète : `php artisan route:list`

---

## Tests

```bash
php artisan test                        # les 77 tests
php artisan test --filter=UiQualityTest # tests d'interface uniquement
```

| Fichier | Couverture |
|---|---|
| `DeviceTest` | CRUD, recherche, filtres, pagination, validation |
| `RoomTest` | CRUD, suppression protégée, salle vide |
| `CategoryTest` | CRUD, nom unique, suppression sans perte de matériel |
| `InterventionTest` | Création, validation, tri, accents |
| `DashboardTest` | Indicateurs et activité récente |
| `UiQualityTest` | Libellés, noms accessibles, pagination, tableaux, états vides, 404 |

Les tests utilisent `RefreshDatabase` et tournent sur une base SQLite **en
mémoire** : aucun impact sur la base de développement.

> **À savoir** — `assertSessionHasErrors()` redémarre la session et consomme le
> message flash pour la requête suivante. Vérifier *le rendu* des erreurs et
> vérifier *la session* doivent donc être deux tests distincts.

---

## Choix techniques

### Aucun JavaScript

L'application n'embarque **aucun script** : pas de fichier `.js`, pas de balise
`<script>`, pas d'attribut `onclick`.

- Le menu de navigation s'affiche en permanence (pas de menu déroulant).
- La confirmation de suppression est une **page** dédiée, pas une modale.
- Le thème sombre utilise `prefers-color-scheme` en CSS pur.

Conséquence : l'application reste utilisable même si JavaScript est désactivé,
et le poids de la page est réduit au strict nécessaire.

### Assets compilés en local

Bootstrap, Bootstrap Icons et la police *Instrument Sans* sont servis depuis le
projet lui-même : aucune requête vers un CDN externe, pas de dépendance à un
tiers, et un chargement plus rapide.

La police est stockée dans `public/fonts/` (fichiers `.woff2`, licence OFL) et
déclarée en `@font-face` dans `resources/css/app.scss`. Le build est donc
**entièrement hors-ligne** : il ne télécharge rien.

### Pagination personnalisée

Laravel utilise la pagination **Tailwind** par défaut. Comme le projet
n'utilise pas Tailwind, la vue Bootstrap a été publiée et personnalisée
(`resources/views/vendor/pagination/bootstrap-5.blade.php`) avec de vraies
icônes, et le `AppServiceProvider` indique à Laravel de l'utiliser :

```php
Paginator::defaultView('pagination::bootstrap-5');
```

### Suppression d'une salle protégée

La clé étrangère `room_id` est en `onDelete('cascade')` : supprimer une salle
effacerait silencieusement ses équipements. La suppression est donc refusée
si du matériel y est encore rattaché, avec un message explicite.

---

## Pistes d'évolution

- [ ] **Authentification** — ajouter les pages de connexion et le middleware
  d'accès aux routes.
- [ ] **Tri des colonnes** (date d'achat, état) sur la liste des équipements.
- [ ] **Filtre par catégorie** sur la liste des équipements.
- [ ] **Export CSV** du parc pour l'inventaire physique.
- [ ] **Étiquettes avec QR code** pour identifier le matériel.
- [ ] **Historique des modifications** (qui a modifié quoi, et quand).
- [ ] **Notifications par e-mail** à l'ouverture d'une panne.
- [ ] **Statistiques** : évolution du parc, valeur du parc, coût de renouvellement.

---

## Licence

Sous licence **MIT** — voir [LICENSE](LICENSE).

Développé avec ❤️ en Laravel.
