# Hôtels par Ville - Documentation Projet

## Vue d'ensemble

Annuaire SEO d'hébergements (chambres d'hôtes, gîtes, hôtels) en France avec maillage massif pour le référencement naturel.

- **Domaine** : hotels-par-ville.fr
- **Stack** : PHP 8.2 natif + TailwindCSS (compilé) + Alpine.js
- **Monétisation** : Expedia (widget search + lien affilié)
- **Données** : JSON (13 régions, 101 départements, ~10000 villes, ~5000 hébergements)
- **Email** : contact@hotels-par-ville.fr
- **Déploiement** : Docker (Coolify self-hosted)

## Configuration

Modifier `config.php` pour changer le site/métier :

```php
define('SITE_NAME', 'hotels-par-ville.fr');
define('SITE_DOMAIN', 'hotels-par-ville.fr');
define('SITE_URL', 'https://hotels-par-ville.fr');
define('METIER', 'hébergement');
define('EXPEDIA_AFFILIATE_URL', 'https://expedia.com/affiliate/Ct26O9m');
define('EXPEDIA_CAMREF', '1110lzZyN');
```

### TOP_VILLES (config.php)

18 villes populaires affichées dans le menu header et la page d'accueil :

```php
define('TOP_VILLES', [
    ['nom' => 'Paris', 'slug' => 'paris', 'cp' => '75000', 'region' => 'ile-de-france', 'dept' => 'paris'],
    ['nom' => 'Marseille', 'slug' => 'marseille', 'cp' => '13000', ...],
    // ... 16 autres villes
]);
```

## Structure des URLs

| Route | Pattern | Exemple |
|-------|---------|---------|
| Accueil | `/` | `/` |
| Contact | `/contact/` | `/contact/` |
| Mentions légales | `/mentions-legales/` | `/mentions-legales/` |
| Confidentialité | `/politique-confidentialite/` | `/politique-confidentialite/` |
| Région | `/{region}/` | `/ile-de-france/` |
| Département | `/{region}/{dept}/` | `/ile-de-france/paris/` |
| Ville | `/{region}/{dept}/{ville-CP}/` | `/ile-de-france/paris/paris-75000/` |
| Catégorie | `/{region}/{dept}/{ville-CP}/{categorie}/` | `.../paris-75000/chambre-d-hotes/` |
| Hébergement | `/{region}/{dept}/{ville-CP}/artisans/{slug}/` | `.../paris-75000/artisans/hotel-de-charme-paris/` |

## Maillage SEO

- **Accueil** → 18 villes populaires + 6 régions
- **Région** → ~10 départements
- **Département** → toutes villes + 6 dept voisins
- **Ville** → 40 catégories + 100 villes proches = ~140 liens
- **Catégorie** → 40 catégories + 100 villes = ~140 liens

## Tailwind CSS (Production Build)

Le CSS est compilé en production (pas de CDN) pour des performances optimales.

### Couleurs (Teal)
- Couleurs primaires: `primary-50` à `primary-900` (teal #14b8a6)
- Couleurs accent: `accent-400` à `accent-600` (cyan #06b6d4)

### Commandes
```bash
npm install              # Installer dépendances
npm run build:css        # Build production (minifié)
npm run watch:css        # Mode développement (watch)
```

### Docker
Le Dockerfile installe Node.js et compile automatiquement le CSS au build.

## Lancer avec Docker

```bash
docker-compose up -d
```

Accès : http://localhost:8000

## Structure des fichiers

```
├── config.php           # Configuration globale (MODIFIER ICI)
├── functions.php        # Helpers et fonctions utilitaires
├── index.php            # Page d'accueil
├── router.php           # Routeur principal
├── sitemap.php          # Générateur de sitemaps
├── robots.php           # Robots.txt dynamique
├── .htaccess            # URL rewriting Apache
├── docker-compose.yml   # Configuration Docker
├── Dockerfile           # Image PHP/Apache + Node.js
├── package.json         # Dépendances npm (Tailwind)
├── tailwind.config.js   # Configuration Tailwind (bleu)
│
├── src/                 # Sources CSS
│   └── input.css        # CSS source Tailwind
│
├── assets/              # Assets statiques
│   ├── css/
│   │   └── style.css    # CSS compilé
│   └── img/
│
├── templates/           # Templates de base
│   ├── header.php
│   ├── footer.php
│   └── 404.php
│
├── components/          # Composants réutilisables
│   ├── breadcrumb.php
│   ├── cta-devis.php         # Widget Expedia (section CTA)
│   ├── hero-devis-form.php   # Widget Expedia (hero)
│   ├── sidebar-cta.php       # CTA sidebar (lien affilié Expedia)
│   ├── floating-cta.php      # CTA flottant mobile + desktop
│   ├── card-*.php
│   ├── faq.php
│   └── search-autocomplete.php
│
├── pages/               # Pages dynamiques
│   ├── region.php
│   ├── departement.php
│   ├── ville.php
│   ├── modele.php       # Catégories hébergement
│   ├── artisan.php      # Fiche hébergement
│   ├── contact.php
│   └── mentions-legales.php
│
├── api/                 # API
│   └── search.php       # Autocomplete villes
│
└── data/                # Données JSON
    ├── regions/
    ├── departements/
    ├── villes/
    ├── artisans-hotel/  # Hébergements par département
    └── stats.json
```

## Données JSON

### artisans-hotel/{code_dept}.json
```json
{
  "nom-ville": {
    "artisans": [{
      "id": "123",
      "nom": "L'Ain avec l'hôte",
      "slug": "l-ain-avec-lhote",
      "telephone": "06 21 60 82 69",
      "site_web": "https://...",
      "adresse": "...",
      "note": 5,
      "avis": 120,
      "type": "Gîte"
    }]
  }
}
```

## 40 Catégories d'hébergement

**Types d'hébergement** : chambre-d-hotes, gite, hotel, hotel-de-charme, auberge, maison-d-hotes, bed-and-breakfast, lodge, chalet, villa, camping, glamping, yourte, cabane, roulotte, peniche, domaine, chateau, ferme-auberge, refuge

**Thématiques** : sejour-romantique, sejour-familial, sejour-nature, hebergement-luxe, spa-bien-etre, avec-piscine, animaux-acceptes, gastronomie-terroir, en-montagne, en-bord-de-mer, a-la-campagne, au-coeur-des-vignobles, week-end-detente, eco-hebergement, hebergement-insolite, randonnee-plein-air, accueil-velo, accessible-pmr, seminaire-groupes, peche-nature

## Commandes utiles

```bash
# Démarrer le site
docker-compose up -d

# Voir les logs
docker-compose logs -f

# Arrêter
docker-compose down

# Rebuild après modification Dockerfile
docker-compose up -d --build

# Build CSS Tailwind
npm run build:css
npm run watch:css
```

## Monétisation Expedia

### Widget de recherche Expedia
Intégré dans les composants `hero-devis-form.php` et `cta-devis.php` :
```html
<div class="eg-widget" data-widget="search" data-program="fr-expedia" data-lobs="stays" data-network="pz" data-camref="1110lzZyN" data-pubref=""></div>
```

Script chargé dans `footer.php` (IMPORTANT : après le DOM, pas dans le head) :
```html
<script class="eg-widgets-script" src="https://creator.expediagroup.com/products/widgets/assets/eg-widgets.js"></script>
```

### Lien affilié Expedia
Utilisé dans les CTAs (header, sidebar, floating, footer, etc.) :
```
https://expedia.com/affiliate/Ct26O9m
```
Toujours avec `target="_blank" rel="noopener nofollow sponsored"`.
