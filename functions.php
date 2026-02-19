<?php
/**
 * Fonctions utilitaires - Annuaire Chambres d'Hôtes
 */

require_once __DIR__ . '/config.php';

// ============================================
// CHARGEMENT DES DONNEES JSON
// ============================================

/**
 * Charge et décode un fichier JSON
 */
function loadJson($filepath) {
    if (!file_exists($filepath)) {
        return null;
    }
    $content = file_get_contents($filepath);
    return json_decode($content, true);
}

/**
 * Charge toutes les régions
 */
function getRegions() {
    static $regions = null;
    if ($regions === null) {
        $regions = loadJson(REGIONS_FILE);
    }
    return $regions ?: [];
}

/**
 * Récupère une région par son slug
 */
function getRegionBySlug($slug) {
    $regions = getRegions();
    foreach ($regions as $region) {
        if ($region['slug'] === $slug) {
            return $region;
        }
    }
    return null;
}

/**
 * Charge les données d'un département
 */
function getDepartement($code) {
    $filepath = DATA_PATH . "departements/{$code}.json";
    return loadJson($filepath);
}

/**
 * Récupère un département par son slug dans une région
 */
function getDepartementBySlug($regionSlug, $deptSlug) {
    $region = getRegionBySlug($regionSlug);
    if (!$region) return null;

    foreach ($region['departements'] as $dept) {
        if ($dept['slug'] === $deptSlug) {
            return getDepartement($dept['code']);
        }
    }
    return null;
}

/**
 * Charge les données d'une ville
 */
function getVille($slug, $codePostal) {
    $filename = "{$slug}-{$codePostal}.json";
    $filepath = DATA_PATH . "villes/{$filename}";
    return loadJson($filepath);
}

/**
 * Récupère une ville depuis les données département
 */
function getVilleFromDepartement($deptCode, $villeSlug, $codePostal) {
    $deptData = getDepartement($deptCode);
    if (!$deptData) return null;

    foreach ($deptData['villes'] as $ville) {
        if ($ville['slug_ville'] === $villeSlug && $ville['code_postal'] === $codePostal) {
            return $ville;
        }
    }
    return null;
}

/**
 * Charge les hébergements d'un département
 */
function getArtisansDepartement($code) {
    $filepath = DATA_PATH . "artisans-hotel/{$code}.json";
    return loadJson($filepath);
}

/**
 * Récupère les hébergements d'une ville
 */
function getArtisansVille($deptCode, $villeSlug) {
    $artisans = getArtisansDepartement($deptCode);
    if (!$artisans || !isset($artisans[$villeSlug])) {
        return [];
    }
    return $artisans[$villeSlug]['artisans'] ?? [];
}

/**
 * Récupère un hébergement spécifique par son slug
 */
function getArtisan($deptCode, $villeSlug, $artisanSlug) {
    $artisans = getArtisansVille($deptCode, $villeSlug);
    foreach ($artisans as $artisan) {
        if ($artisan['slug'] === $artisanSlug) {
            return $artisan;
        }
    }
    return null;
}

/**
 * Récupère les villes proches depuis le fichier ville
 */
function getVillesProches($villeSlug, $codePostal, $limit = NEARBY_CITIES_COUNT) {
    $villeData = getVille($villeSlug, $codePostal);
    if (!$villeData || !isset($villeData['villes_proches'])) {
        return [];
    }
    return array_slice($villeData['villes_proches'], 0, $limit);
}

/**
 * Récupère les départements voisins
 */
function getDepartementsVoisins($deptCode, $limit = NEARBY_DEPARTMENTS_COUNT) {
    $deptData = getDepartement($deptCode);
    if (!$deptData || !isset($deptData['voisins'])) {
        return [];
    }
    return array_slice($deptData['voisins'], 0, $limit);
}

// ============================================
// GENERATION D'URLs
// ============================================

/**
 * Génère l'URL d'une région
 */
function urlRegion($regionSlug) {
    return SITE_URL . "/{$regionSlug}/";
}

/**
 * Génère l'URL d'un département
 */
function urlDepartement($regionSlug, $deptSlug) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/";
}

/**
 * Génère l'URL d'une ville
 */
function urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/{$villeSlug}-{$codePostal}/";
}

/**
 * Génère l'URL d'un type d'hébergement pour une ville
 */
function urlModele($regionSlug, $deptSlug, $villeSlug, $codePostal, $modeleSlug) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/{$villeSlug}-{$codePostal}/{$modeleSlug}/";
}

/**
 * Génère l'URL d'un hébergement
 */
function urlArtisan($regionSlug, $deptSlug, $villeSlug, $codePostal, $artisanSlug) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/{$villeSlug}-{$codePostal}/artisans/{$artisanSlug}/";
}

/**
 * Génère l'URL relative (sans domaine)
 */
function urlRelative($path) {
    return '/' . ltrim($path, '/');
}

// ============================================
// SEO - META TAGS & JSON-LD
// ============================================

/**
 * Génère le titre SEO de la page
 */
function seoTitle($title) {
    return htmlspecialchars($title) . ' | ' . SITE_NAME;
}

/**
 * Génère la meta description
 */
function seoDescription($desc, $maxLength = 160) {
    $desc = strip_tags($desc);
    if (strlen($desc) > $maxLength) {
        $desc = substr($desc, 0, $maxLength - 3) . '...';
    }
    return htmlspecialchars($desc);
}

/**
 * Génère le JSON-LD Organization
 */
function jsonLdOrganization() {
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => SITE_NAME,
        'url' => SITE_URL,
        'logo' => SITE_URL . '/assets/img/favicon.svg',
        'image' => SITE_URL . '/assets/img/og-image.svg',
        'description' => SITE_DESCRIPTION,
        'email' => 'contact@annuaire-chambres-hotes.fr',
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'France'
        ],
        'sameAs' => []
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD WebSite avec SearchAction (sitelinks searchbox)
 */
function jsonLdWebSite() {
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => SITE_NAME,
        'url' => SITE_URL,
        'description' => SITE_DESCRIPTION,
        'inLanguage' => 'fr-FR',
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => SITE_URL . '/?q={search_term_string}'
            ],
            'query-input' => 'required name=search_term_string'
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD FAQPage
 */
function jsonLdFAQ($questions) {
    $mainEntity = [];
    foreach ($questions as $q) {
        $mainEntity[] = [
            '@type' => 'Question',
            'name' => $q['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $q['reponse']
            ]
        ];
    }

    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $mainEntity
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD LodgingBusiness pour un hébergement
 */
function jsonLdLocalBusiness($artisan, $ville) {
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'LodgingBusiness',
        'name' => $artisan['nom'],
        'description' => METIER_TITLE . ' à ' . $ville['nom_standard'],
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $ville['nom_standard'],
            'postalCode' => $ville['code_postal'],
            'addressCountry' => 'FR'
        ]
    ];

    if (!empty($artisan['telephone'])) {
        $data['telephone'] = $artisan['telephone'];
    }

    if (!empty($artisan['note']) && !empty($artisan['avis'])) {
        $data['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => $artisan['note'],
            'reviewCount' => $artisan['avis']
        ];
    }

    return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD BreadcrumbList
 */
function jsonLdBreadcrumb($items) {
    $listItems = [];
    foreach ($items as $i => $item) {
        $listItems[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url']
        ];
    }

    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $listItems
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD Service
 */
function jsonLdService($ville, $modele = null) {
    $serviceName = $modele
        ? $modele['nom'] . ' à ' . $ville['nom_standard']
        : METIER_TITLE . ' à ' . $ville['nom_standard'];

    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'serviceType' => $modele ? $modele['nom'] : 'Hébergement et chambres d\'hôtes',
        'name' => $serviceName,
        'provider' => [
            '@type' => 'Organization',
            'name' => SITE_NAME
        ],
        'areaServed' => [
            '@type' => 'City',
            'name' => $ville['nom_standard'],
            'postalCode' => $ville['code_postal']
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

// ============================================
// HELPERS DIVERS
// ============================================

/**
 * Formate un numéro de téléphone français
 */
function formatTelephone($tel) {
    if (empty($tel)) return '';
    // Nettoie le numéro
    $tel = preg_replace('/[^0-9+]/', '', $tel);
    // Formate en XX XX XX XX XX
    if (strlen($tel) === 10) {
        return implode(' ', str_split($tel, 2));
    }
    return $tel;
}

/**
 * Génère les étoiles de notation
 */
function renderStars($note, $maxStars = 5) {
    $note = floatval($note);
    $fullStars = floor($note);
    $halfStar = ($note - $fullStars) >= 0.5;
    $emptyStars = $maxStars - $fullStars - ($halfStar ? 1 : 0);

    $html = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<span class="text-yellow-400">&#9733;</span>';
    }
    if ($halfStar) {
        $html .= '<span class="text-yellow-400">&#9734;</span>';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $html .= '<span class="text-gray-300">&#9734;</span>';
    }
    return $html;
}

/**
 * Génère le slug d'une chaîne
 */
function slugify($string) {
    $string = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $string);
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    return trim($string, '-');
}

/**
 * Pagination helper
 */
function paginate($items, $page, $perPage = ITEMS_PER_PAGE) {
    $total = count($items);
    $totalPages = ceil($total / $perPage);
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;

    return [
        'items' => array_slice($items, $offset, $perPage),
        'current' => $page,
        'total' => $totalPages,
        'count' => $total,
        'hasNext' => $page < $totalPages,
        'hasPrev' => $page > 1
    ];
}

/**
 * Extrait le code département du code postal
 */
function getDeptCodeFromPostal($codePostal) {
    if (strlen($codePostal) === 5) {
        $prefix = substr($codePostal, 0, 2);
        // Gestion Corse
        if ($prefix === '20') {
            $next = substr($codePostal, 0, 3);
            return ($next >= '201' && $next <= '209') ? '2A' : '2B';
        }
        // DOM-TOM
        if ($prefix === '97') {
            return substr($codePostal, 0, 3);
        }
        return $prefix;
    }
    return null;
}

/**
 * Compte le nombre total d'hébergements dans un département
 */
function countArtisansDepartement($deptCode) {
    $artisans = getArtisansDepartement($deptCode);
    if (!$artisans) return 0;

    $count = 0;
    foreach ($artisans as $villeArtisans) {
        $count += count($villeArtisans['artisans'] ?? []);
    }
    return $count;
}

/**
 * Sécurise les sorties HTML
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Génère un ID unique pour Alpine.js
 */
function uniqueId($prefix = 'el') {
    static $counter = 0;
    return $prefix . '_' . (++$counter);
}

/**
 * Vérifie si on est sur mobile (approximatif)
 */
function isMobile() {
    return isset($_SERVER['HTTP_USER_AGENT']) &&
           preg_match('/Mobile|Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']);
}

// ============================================
// GENERATION DE CONTENU UNIQUE (anti-duplicate)
// ============================================

/**
 * Calcule les stats agrégées d'un département
 */
function getDeptStats($deptData) {
    $villes = $deptData['villes'] ?? [];
    $dept = $deptData['departement'];
    $code = $dept['code'] ?? '';

    $totalPop = 0;
    $totalSurface = 0;
    $plusGrandeVille = null;
    $maxPop = 0;

    foreach ($villes as $v) {
        $pop = $v['population'] ?? 0;
        $totalPop += $pop;
        $totalSurface += $v['superficie_km2'] ?? 0;
        if ($pop > $maxPop) {
            $maxPop = $pop;
            $plusGrandeVille = $v['nom_standard'];
        }
    }

    $nbArtisans = countArtisansDepartement($code);
    $densite = $totalSurface > 0 ? round($totalPop / $totalSurface) : 0;

    return [
        'population' => $totalPop,
        'superficie' => round($totalSurface),
        'nb_villes' => count($villes),
        'plus_grande_ville' => $plusGrandeVille,
        'plus_grande_pop' => $maxPop,
        'nb_artisans' => $nbArtisans,
        'densite' => $densite,
        'est_urbain' => $densite > 200,
        'voisins' => $deptData['voisins'] ?? [],
    ];
}

/**
 * Calcule les stats d'une région
 */
function getRegionStats($region) {
    $totalVilles = 0;
    $deptNoms = [];
    foreach ($region['departements'] as $d) {
        $totalVilles += $d['villes_count'] ?? 0;
        $deptNoms[] = $d['nom'];
    }
    return [
        'total_villes' => $totalVilles,
        'nb_depts' => $region['departements_count'] ?? count($region['departements']),
        'dept_noms' => $deptNoms,
    ];
}

/**
 * Sélection déterministe d'un index de template basé sur un slug
 */
function pickVariant($slug, $count) {
    return abs(crc32($slug)) % $count;
}

/**
 * Génère le paragraphe hero pour une page région
 */
function generateRegionHero($region, $stats) {
    $nom = e($region['nom']);
    $nbDepts = $stats['nb_depts'];
    $nbVilles = $stats['total_villes'];

    $templates = [
        "Découvrez les plus belles chambres d'hôtes et hébergements de charme dans les $nbDepts départements de la région $nom. $nbVilles communes référencées pour votre prochain séjour.",
        "$nbDepts départements, $nbVilles destinations : trouvez l'hébergement idéal en $nom. Chambres d'hôtes, gîtes, hôtels de charme et hébergements insolites.",
        "Notre sélection couvre toute la région $nom : $nbVilles communes réparties sur $nbDepts départements. Réservez votre chambre d'hôtes ou gîte au meilleur prix.",
        "Envie d'un séjour en $nom ? Parcourez nos hébergements dans $nbVilles communes et $nbDepts départements. Chambres d'hôtes, gîtes et logements de charme vous attendent.",
    ];

    return $templates[pickVariant($region['slug'], count($templates))];
}

/**
 * Génère le contenu éditorial unique pour une page région
 */
function generateRegionContent($region, $stats) {
    $nom = e($region['nom']);
    $nbDepts = $stats['nb_depts'];
    $nbVilles = $stats['total_villes'];
    $deptListe = implode(', ', array_slice($stats['dept_noms'], 0, 5));
    $reste = max(0, $nbDepts - 5);

    $intros = [
        "La région $nom regroupe $nbDepts départements dont $deptListe" . ($reste > 0 ? " et $reste autres" : "") . ". Vous y trouverez une grande diversité d'hébergements : chambres d'hôtes de charme, gîtes ruraux, hôtels boutique et logements insolites au coeur de paysages remarquables.",
        "Avec $nbVilles communes réparties dans $nbDepts départements ($deptListe" . ($reste > 0 ? "…" : "") . "), la région $nom offre un patrimoine touristique exceptionnel. Des séjours à la campagne aux escapades urbaines, chaque type de voyageur trouvera l'hébergement qui lui convient.",
        "En $nom, nos $nbDepts départements référencés ($deptListe" . ($reste > 0 ? " et plus" : "") . ") vous ouvrent les portes de centaines d'hébergements de qualité : chambres d'hôtes avec table d'hôtes, gîtes de caractère, domaines viticoles et refuges de montagne, parmi les $nbVilles communes disponibles.",
        "Explorez la région $nom à travers ses $nbDepts départements et $nbVilles communes d'hébergement. De $deptListe" . ($reste > 0 ? " jusqu'aux territoires voisins" : "") . ", chaque destination vous réserve un cadre exceptionnel et un accueil authentique.",
    ];

    $whys = [
        [
            'Hébergements sélectionnés' => 'des établissements de qualité vérifiés dans chaque département',
            'Diversité' => 'chambres d\'hôtes, gîtes, hôtels de charme, hébergements insolites',
            'Authenticité' => 'un accueil personnalisé et des expériences locales uniques',
            'Cadre exceptionnel' => 'des lieux de séjour au coeur de paysages remarquables',
        ],
        [
            'Disponibilité toute l\'année' => 'des hébergements ouverts en toute saison, pour chaque envie d\'évasion',
            'Établissements labellisés' => 'Gîtes de France, Clévacances, Fleurs de Soleil et autres labels de qualité',
            'Réservation directe' => 'contactez les propriétaires sans intermédiaire pour le meilleur prix',
            'Expérience complète' => 'table d\'hôtes, activités, conseils personnalisés sur la région',
        ],
        [
            'Couverture complète' => "$nbDepts départements et $nbVilles communes d'hébergement en $nom",
            'Séjours sur mesure' => 'week-end romantique, vacances en famille, escapade nature ou culturelle',
            'Meilleurs prix' => 'comparez les offres et réservez directement auprès des établissements',
            'Patrimoine & terroir' => 'gastronomie locale, sites historiques, activités de plein air',
        ],
    ];

    $i = pickVariant($region['slug'], count($intros));
    $j = pickVariant($region['slug'] . '-why', count($whys));

    $html = '<p>' . $intros[$i] . '</p>';
    $html .= '<h3>Pourquoi séjourner en ' . $nom . ' ?</h3><ul>';
    foreach ($whys[$j] as $titre => $desc) {
        $html .= '<li><strong>' . $titre . '</strong> : ' . $desc . '</li>';
    }
    $html .= '</ul>';

    return $html;
}

/**
 * Génère le paragraphe hero pour une page département
 */
function generateDeptHero($dept, $stats) {
    $nom = e($dept['nom']);
    $code = e($dept['code']);
    $nbVilles = $stats['nb_villes'];
    $nbArtisans = $stats['nb_artisans'];

    $templates = [
        "$nbVilles communes et $nbArtisans hébergements référencés dans le $nom ($code). Trouvez votre chambre d'hôtes, gîte ou hôtel de charme idéal.",
        "Découvrez $nbArtisans hébergements de qualité dans le $nom. $nbVilles destinations pour un séjour inoubliable dans le $code.",
        "Chambres d'hôtes, gîtes, hôtels : $nbArtisans établissements sélectionnés dans le $nom ($code). Comparez et réservez parmi $nbVilles communes.",
        "Le département $nom ($code) propose $nbArtisans hébergements sur $nbVilles communes. Réservez votre séjour au meilleur prix.",
        "Nos $nbArtisans hébergements dans le $nom couvrent $nbVilles communes. Chambres d'hôtes, gîtes et logements de charme dans le $code.",
    ];

    return $templates[pickVariant($dept['slug'], count($templates))];
}

/**
 * Génère le contenu intro unique pour une page département
 */
function generateDeptIntro($dept, $stats) {
    $nom = e($dept['nom']);
    $code = e($dept['code']);
    $nbVilles = $stats['nb_villes'];
    $nbArtisans = $stats['nb_artisans'];
    $grandeVille = $stats['plus_grande_ville'] ? e($stats['plus_grande_ville']) : $nom;
    $pop = $stats['population'];
    $popStr = $pop > 0 ? number_format($pop, 0, ',', ' ') . ' habitants' : '';
    $surface = $stats['superficie'];

    $voisinNoms = [];
    foreach (array_slice($stats['voisins'], 0, 3) as $v) {
        $voisinNoms[] = $v['dep_nom'];
    }
    $voisinStr = !empty($voisinNoms) ? implode(', ', $voisinNoms) : '';

    if ($stats['est_urbain']) {
        $contexte = "département à forte attractivité touristique urbaine";
        $specificite = "Les hôtels de charme, boutique-hôtels et chambres d'hôtes en centre-ville offrent un accès privilégié aux sites culturels, restaurants et boutiques que nos visiteurs apprécient.";
    } else {
        $contexte = "département où les hébergements ruraux et de charme sont particulièrement prisés";
        $specificite = "Les chambres d'hôtes à la campagne, les gîtes de caractère et les hébergements insolites en pleine nature offrent un cadre exceptionnel pour se ressourcer loin de l'agitation urbaine.";
    }

    $intros = [
        "Le <strong>$nom</strong> ($code) est un $contexte" . ($popStr ? " avec $popStr répartis sur $nbVilles communes" : " avec $nbVilles communes") . ". Nos <strong>$nbArtisans établissements</strong> vous accueillent de $grandeVille jusqu'aux villages alentour pour des séjours authentiques en chambres d'hôtes, gîtes et hôtels de charme. $specificite",

        "Avec $nbVilles communes" . ($popStr ? " et $popStr" : "") . ", le département <strong>$nom</strong> ($code) regorge de destinations touristiques variées. Nos $nbArtisans hébergements, situés notamment à $grandeVille, proposent chambres d'hôtes avec petit-déjeuner, gîtes indépendants, tables d'hôtes et logements insolites." . ($voisinStr ? " La découverte se poursuit dans les départements voisins : $voisinStr." : ""),

        "Vous cherchez où séjourner dans le <strong>$nom</strong> ($code) ? Nos $nbArtisans hébergements couvrent les $nbVilles communes du département pour tous vos projets : week-end romantique, vacances en famille, escapade nature ou séjour gastronomique." . ($popStr ? " Ce $contexte" : " Ce département") . " mérite des établissements à la hauteur de ses paysages. $specificite",

        "Notre sélection dans le <strong>$nom</strong> ($code) réunit $nbArtisans établissements de qualité dans $nbVilles communes" . ($popStr ? " ($popStr)" : "") . ". De $grandeVille aux petits villages de caractère, découvrez chambres d'hôtes de charme, gîtes ruraux, domaines et hébergements insolites." . ($voisinStr ? " À explorer aussi : $voisinStr." : ""),

        "$nbArtisans hébergements sélectionnés dans le <strong>$nom</strong> ($code)" . ($surface > 0 ? " sur $surface km²" : "") . " pour vos séjours en chambres d'hôtes, gîtes et hôtels de charme. La ville principale, $grandeVille, et les $nbVilles communes environnantes offrent un cadre exceptionnel pour votre prochain voyage. $specificite",
    ];

    return $intros[pickVariant($dept['slug'], count($intros))];
}

/**
 * Génère le texte sidebar unique pour un département
 */
function generateDeptSidebar($dept, $stats) {
    $nom = e($dept['nom']);
    $nbArtisans = $stats['nb_artisans'];
    $nbVilles = $stats['nb_villes'];

    $templates = [
        "$nbArtisans hébergements dans $nbVilles communes du <strong>$nom</strong>. Chambres d'hôtes, gîtes et hôtels : trouvez votre séjour idéal.",
        "Séjour dans le <strong>$nom</strong> : $nbArtisans établissements disponibles sur $nbVilles communes. Réservez aux meilleurs prix.",
        "Nos $nbArtisans hébergements dans le <strong>$nom</strong> vous accueillent dans $nbVilles communes. Vérifiez les disponibilités.",
        "Envie d'un séjour dans le <strong>$nom</strong> ? $nbArtisans établissements de charme, $nbVilles destinations. Consultez les disponibilités.",
    ];

    return $templates[pickVariant($dept['slug'] . '-side', count($templates))];
}
