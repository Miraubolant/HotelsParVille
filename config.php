<?php
/**
 * Configuration Hôtels par Ville
 * MODIFIER CES VARIABLES POUR CHANGER LE SITE
 */

// ============================================
// SITE - Configuration générale
// ============================================
define('SITE_NAME', 'hotels-par-ville.fr');
define('SITE_DOMAIN', 'hotels-par-ville.fr');
define('SITE_URL', 'https://hotels-par-ville.fr');
define('SITE_TAGLINE', 'Hôtels par Ville en France');
define('SITE_DESCRIPTION', 'Trouvez les meilleurs hôtels ville par ville en France. Comparez les offres et réservez votre hébergement au meilleur prix.');

// ============================================
// METIER - Configuration du métier affiché
// ============================================
define('METIER', 'hébergement');
define('METIER_PLURAL', 'hébergements');
define('METIER_TITLE', 'Hébergements');
define('METIER_ICON', 'home');

// ============================================
// MONETISATION - Partenaires affiliation
// ============================================
define('EXPEDIA_AFFILIATE_URL', 'https://expedia.com/affiliate/Ct26O9m');
define('EXPEDIA_CAMREF', '1110lzZyN');

// ============================================
// AFFICHAGE - Paramètres de pagination et liens
// ============================================
define('ITEMS_PER_PAGE', 24);
define('NEARBY_CITIES_COUNT', 100);
define('NEARBY_DEPARTMENTS_COUNT', 6);
define('ARTISANS_PER_PAGE', 15);

// ============================================
// CHEMINS - Dossiers de données
// ============================================
define('DATA_PATH', __DIR__ . '/data/');
define('REGIONS_FILE', DATA_PATH . 'regions/regions.json');

// ============================================
// SERVICES HEBERGEMENT - MODELES (Types + Thématiques)
// ============================================
define('SERVICES_TOITURE_MODELES', [
    // Types d'hébergement
    ['slug' => 'chambre-d-hotes', 'nom' => 'Chambre d\'hôtes', 'emoji' => '🏡'],
    ['slug' => 'gite', 'nom' => 'Gîte', 'emoji' => '🏠'],
    ['slug' => 'hotel', 'nom' => 'Hôtel', 'emoji' => '🏨'],
    ['slug' => 'hotel-de-charme', 'nom' => 'Hôtel de charme', 'emoji' => '🌟'],
    ['slug' => 'auberge', 'nom' => 'Auberge', 'emoji' => '🍽️'],
    ['slug' => 'maison-d-hotes', 'nom' => 'Maison d\'hôtes', 'emoji' => '🏘️'],
    ['slug' => 'bed-and-breakfast', 'nom' => 'Bed & Breakfast', 'emoji' => '☕'],
    ['slug' => 'lodge', 'nom' => 'Lodge', 'emoji' => '🌲'],
    ['slug' => 'chalet', 'nom' => 'Chalet', 'emoji' => '🏔️'],
    ['slug' => 'villa', 'nom' => 'Villa', 'emoji' => '🏖️'],
    ['slug' => 'camping', 'nom' => 'Camping', 'emoji' => '⛺'],
    ['slug' => 'glamping', 'nom' => 'Glamping', 'emoji' => '✨'],
    ['slug' => 'yourte', 'nom' => 'Yourte', 'emoji' => '🎪'],
    ['slug' => 'cabane', 'nom' => 'Cabane', 'emoji' => '🌳'],
    ['slug' => 'roulotte', 'nom' => 'Roulotte', 'emoji' => '🎠'],
    ['slug' => 'peniche', 'nom' => 'Péniche', 'emoji' => '🚢'],
    ['slug' => 'domaine', 'nom' => 'Domaine', 'emoji' => '🏰'],
    ['slug' => 'chateau', 'nom' => 'Château', 'emoji' => '👑'],
    ['slug' => 'ferme-auberge', 'nom' => 'Ferme-auberge', 'emoji' => '🐄'],
    ['slug' => 'refuge', 'nom' => 'Refuge', 'emoji' => '⛰️'],

    // Thématiques
    ['slug' => 'sejour-romantique', 'nom' => 'Séjour romantique', 'emoji' => '💕'],
    ['slug' => 'sejour-familial', 'nom' => 'Séjour familial', 'emoji' => '👨‍👩‍👧‍👦'],
    ['slug' => 'sejour-nature', 'nom' => 'Séjour nature', 'emoji' => '🌿'],
    ['slug' => 'hebergement-luxe', 'nom' => 'Hébergement de luxe', 'emoji' => '💎'],
    ['slug' => 'spa-bien-etre', 'nom' => 'Spa & Bien-être', 'emoji' => '🧖'],
    ['slug' => 'avec-piscine', 'nom' => 'Avec piscine', 'emoji' => '🏊'],
    ['slug' => 'animaux-acceptes', 'nom' => 'Animaux acceptés', 'emoji' => '🐾'],
    ['slug' => 'gastronomie-terroir', 'nom' => 'Gastronomie & Terroir', 'emoji' => '🍷'],
    ['slug' => 'en-montagne', 'nom' => 'En montagne', 'emoji' => '🏔️'],
    ['slug' => 'en-bord-de-mer', 'nom' => 'En bord de mer', 'emoji' => '🌊'],
    ['slug' => 'a-la-campagne', 'nom' => 'À la campagne', 'emoji' => '🌾'],
    ['slug' => 'au-coeur-des-vignobles', 'nom' => 'Au cœur des vignobles', 'emoji' => '🍇'],
    ['slug' => 'week-end-detente', 'nom' => 'Week-end détente', 'emoji' => '🧘'],
    ['slug' => 'eco-hebergement', 'nom' => 'Éco-hébergement', 'emoji' => '♻️'],
    ['slug' => 'hebergement-insolite', 'nom' => 'Hébergement insolite', 'emoji' => '🎭'],
    ['slug' => 'randonnee-plein-air', 'nom' => 'Randonnée & Plein air', 'emoji' => '🥾'],
    ['slug' => 'accueil-velo', 'nom' => 'Accueil vélo', 'emoji' => '🚴'],
    ['slug' => 'accessible-pmr', 'nom' => 'Accessible PMR', 'emoji' => '♿'],
    ['slug' => 'seminaire-groupes', 'nom' => 'Séminaire & Groupes', 'emoji' => '👥'],
    ['slug' => 'peche-nature', 'nom' => 'Pêche & Nature', 'emoji' => '🎣'],
]);

// ============================================
// STYLES HEBERGEMENT (pour page accueil - 6 catégories vedettes)
// ============================================
define('STYLES_TOITURE', [
    ['slug' => 'chambre-d-hotes', 'nom' => 'Chambres d\'hôtes', 'emoji' => '🏡', 'desc' => 'Accueil chaleureux'],
    ['slug' => 'gite', 'nom' => 'Gîtes', 'emoji' => '🏠', 'desc' => 'En toute liberté'],
    ['slug' => 'hotel-de-charme', 'nom' => 'Hôtels de charme', 'emoji' => '🌟', 'desc' => 'Élégance & confort'],
    ['slug' => 'hebergement-insolite', 'nom' => 'Insolite', 'emoji' => '🎭', 'desc' => 'Expériences uniques'],
    ['slug' => 'avec-piscine', 'nom' => 'Avec piscine', 'emoji' => '🏊', 'desc' => 'Détente assurée'],
    ['slug' => 'sejour-romantique', 'nom' => 'Romantique', 'emoji' => '💕', 'desc' => 'Escapade en amoureux'],
]);

// ============================================
// FAQ ACCUEIL (10 questions)
// ============================================
define('FAQ_ACCUEIL', [
    [
        'question' => 'Quelle est la différence entre une chambre d\'hôtes et un gîte ?',
        'reponse' => 'Une chambre d\'hôtes est une chambre chez l\'habitant avec petit-déjeuner inclus (5 chambres max, 15 personnes). Le gîte est un logement indépendant meublé loué à la semaine ou au week-end, sans service de restauration obligatoire.'
    ],
    [
        'question' => 'Quel est le prix moyen d\'une nuit en chambre d\'hôtes ?',
        'reponse' => 'En France, le prix moyen d\'une nuit en chambre d\'hôtes est de 70 à 120€ petit-déjeuner inclus. Les tarifs varient selon la région, le standing et la saison : comptez 50-80€ en campagne et 100-200€ pour un hébergement de charme.'
    ],
    [
        'question' => 'Comment réserver une chambre d\'hôtes ?',
        'reponse' => 'Vous pouvez réserver directement auprès de l\'établissement via notre annuaire. Consultez la fiche de l\'hébergement, vérifiez les disponibilités et contactez le propriétaire par téléphone ou via son site web.'
    ],
    [
        'question' => 'Les chambres d\'hôtes acceptent-elles les animaux ?',
        'reponse' => 'Cela dépend de chaque établissement. Utilisez notre filtre "Animaux acceptés" pour trouver les hébergements pet-friendly. Certains facturent un supplément de 5 à 15€ par nuit pour les animaux.'
    ],
    [
        'question' => 'Quels labels garantissent la qualité d\'une chambre d\'hôtes ?',
        'reponse' => 'Les principaux labels sont : Gîtes de France (épis), Clévacances (clés), Fleurs de Soleil, Accueil Paysan. Ces labels garantissent un niveau de confort et de qualité d\'accueil contrôlé régulièrement.'
    ],
    [
        'question' => 'Peut-on dîner dans une chambre d\'hôtes ?',
        'reponse' => 'Beaucoup de chambres d\'hôtes proposent la table d\'hôtes : un repas convivial préparé par le propriétaire avec des produits locaux. Comptez 20 à 35€ par personne. Il faut généralement réserver à l\'avance.'
    ],
    [
        'question' => 'Quand réserver pour les vacances d\'été ?',
        'reponse' => 'Pour la haute saison (juillet-août), il est conseillé de réserver 3 à 6 mois à l\'avance, surtout dans les régions touristiques (Provence, Bretagne, Côte d\'Azur). Hors saison, 2 à 4 semaines suffisent.'
    ],
    [
        'question' => 'Quelle est la durée minimum de séjour ?',
        'reponse' => 'En chambre d\'hôtes, la plupart acceptent une nuit minimum. Les gîtes exigent souvent un minimum de 2 nuits en basse saison et une semaine (du samedi au samedi) en haute saison.'
    ],
    [
        'question' => 'Les chambres d\'hôtes sont-elles adaptées aux familles ?',
        'reponse' => 'Oui, de nombreuses chambres d\'hôtes proposent des chambres familiales ou des suites pouvant accueillir 3 à 5 personnes. Certaines disposent d\'équipements enfants (lit bébé, chaise haute, jeux).'
    ],
    [
        'question' => 'Comment annuler une réservation ?',
        'reponse' => 'Les conditions d\'annulation varient selon les établissements. En général, une annulation gratuite est possible jusqu\'à 7-14 jours avant l\'arrivée. Des arrhes de 25 à 30% sont souvent demandées à la réservation.'
    ],
]);

// ============================================
// SERVICES HEBERGEMENT (pour page accueil - 3 services vedettes)
// ============================================
define('SERVICES_TOITURE', [
    [
        'titre' => 'Hôtels par Ville en France',
        'icon' => '🏡',
        'desc' => 'Séjournez chez l\'habitant pour une expérience authentique et conviviale.',
        'points' => ['Petit-déjeuner inclus', 'Accueil personnalisé', 'Charme et authenticité']
    ],
    [
        'titre' => 'Hôtels & Hébergements de charme',
        'icon' => '🌟',
        'desc' => 'Des établissements sélectionnés pour leur confort et leur caractère unique.',
        'points' => ['Confort garanti', 'Cadre exceptionnel', 'Services haut de gamme']
    ],
    [
        'titre' => 'Hébergements insolites',
        'icon' => '🎭',
        'desc' => 'Yourtes, cabanes, roulottes, péniches : vivez des expériences uniques.',
        'points' => ['Expérience originale', 'En pleine nature', 'Souvenirs inoubliables']
    ],
]);

// ============================================
// TOP VILLES (les plus recherchées - menu header)
// ============================================
define('TOP_VILLES', [
    ['nom' => 'Paris', 'slug' => 'paris', 'cp' => '75000', 'region' => 'ile-de-france', 'dept' => 'paris'],
    ['nom' => 'Marseille', 'slug' => 'marseille', 'cp' => '13000', 'region' => 'provence-alpes-cote-d-azur', 'dept' => 'bouches-du-rhone'],
    ['nom' => 'Lyon', 'slug' => 'lyon', 'cp' => '69000', 'region' => 'auvergne-rhone-alpes', 'dept' => 'rhone'],
    ['nom' => 'Toulouse', 'slug' => 'toulouse', 'cp' => '31100', 'region' => 'occitanie', 'dept' => 'haute-garonne'],
    ['nom' => 'Bordeaux', 'slug' => 'bordeaux', 'cp' => '33300', 'region' => 'nouvelle-aquitaine', 'dept' => 'gironde'],
    ['nom' => 'Nantes', 'slug' => 'nantes', 'cp' => '44200', 'region' => 'pays-de-la-loire', 'dept' => 'loire-atlantique'],
    ['nom' => 'Lille', 'slug' => 'lille', 'cp' => '59260', 'region' => 'hauts-de-france', 'dept' => 'nord'],
    ['nom' => 'Strasbourg', 'slug' => 'strasbourg', 'cp' => '67000', 'region' => 'grand-est', 'dept' => 'bas-rhin'],
    ['nom' => 'Rennes', 'slug' => 'rennes', 'cp' => '35700', 'region' => 'bretagne', 'dept' => 'ille-et-vilaine'],
    ['nom' => 'Rouen', 'slug' => 'rouen', 'cp' => '76100', 'region' => 'normandie', 'dept' => 'seine-maritime'],
    ['nom' => 'Grenoble', 'slug' => 'grenoble', 'cp' => '38000', 'region' => 'auvergne-rhone-alpes', 'dept' => 'isere'],
    ['nom' => 'Reims', 'slug' => 'reims', 'cp' => '51100', 'region' => 'grand-est', 'dept' => 'marne'],
    ['nom' => 'Dijon', 'slug' => 'dijon', 'cp' => '21000', 'region' => 'bourgogne-franche-comte', 'dept' => 'cote-d-or'],
    ['nom' => 'Tours', 'slug' => 'tours', 'cp' => '37100', 'region' => 'centre-val-de-loire', 'dept' => 'indre-et-loire'],
    ['nom' => 'Orléans', 'slug' => 'orleans', 'cp' => '45000', 'region' => 'centre-val-de-loire', 'dept' => 'loiret'],
    ['nom' => 'Angers', 'slug' => 'angers', 'cp' => '49000', 'region' => 'pays-de-la-loire', 'dept' => 'maine-et-loire'],
    ['nom' => 'Caen', 'slug' => 'caen', 'cp' => '14000', 'region' => 'normandie', 'dept' => 'calvados'],
    ['nom' => 'Amiens', 'slug' => 'amiens', 'cp' => '80090', 'region' => 'hauts-de-france', 'dept' => 'somme'],
]);

// ============================================
// AVANTAGES (pour page accueil)
// ============================================
define('AVANTAGES', [
    ['titre' => 'Partout en France', 'desc' => 'Des milliers d\'hébergements de charme dans toute la France', 'icon' => '🗺️'],
    ['titre' => 'Réservation facile', 'desc' => 'Trouvez et réservez votre hébergement idéal en quelques clics', 'icon' => '⚡'],
    ['titre' => 'Meilleurs prix', 'desc' => 'Comparez les offres et trouvez le meilleur rapport qualité-prix', 'icon' => '💰'],
]);

// ============================================
// RESEAU ANNUAIRES PARTENAIRES (cross-linking)
// ============================================
$allNetworkSites = [
    ['url' => 'https://hotels-par-ville.fr', 'nom' => 'Hôtels par Ville', 'anchor' => 'Chambres d\'hôtes & Gîtes'],
];
define('NETWORK_SITES', array_values(array_filter($allNetworkSites, function($site) {
    return parse_url($site['url'], PHP_URL_HOST) !== SITE_DOMAIN;
})));

// ============================================
// FONCTIONS UTILITAIRES CONFIG
// ============================================
function getModeleBySlug($slug) {
    foreach (SERVICES_TOITURE_MODELES as $modele) {
        if ($modele['slug'] === $slug) {
            return $modele;
        }
    }
    return null;
}

function getAllModeles() {
    return SERVICES_TOITURE_MODELES;
}
