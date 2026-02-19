<?php
/**
 * Page Type d'Hébergement - Annuaire Chambres d'Hôtes
 * URL: /{region}/{departement}/{ville-CP}/{modele}/
 */

require_once __DIR__ . '/../functions.php';

// Récupération des paramètres
$regionSlug = $params['region'] ?? null;
$deptSlug = $params['departement'] ?? null;
$villeSlugCP = $params['ville'] ?? null;
$modeleSlug = $params['modele'] ?? null;

// Extraction slug ville et code postal
preg_match('/^(.+)-(\d{5})$/', $villeSlugCP, $matches);
$villeSlug = $matches[1] ?? null;
$codePostal = $matches[2] ?? null;

if (!$regionSlug || !$deptSlug || !$villeSlug || !$codePostal || !$modeleSlug) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Chargement des données
$region = getRegionBySlug($regionSlug);
$villeData = getVille($villeSlug, $codePostal);
$modele = getModeleBySlug($modeleSlug);

if (!$region || !$villeData || !$modele) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

$ville = $villeData['ville'];
$dept = $villeData['departement'];
$villesProches = $villeData['villes_proches'] ?? [];

// Artisans
$deptCode = getDeptCodeFromPostal($codePostal);
$artisans = getArtisansVille($deptCode, $villeSlug);

// SEO
$pageTitle = seoTitle($modele['nom'] . ' à ' . $ville['nom_standard'] . ' (' . $codePostal . ')');
$pageDescription = seoDescription($modele['nom'] . ' à ' . $ville['nom_standard'] . '. Trouvez les meilleurs hébergements. Chambres d\'hôtes, gîtes et hôtels de charme pour votre séjour ' . strtolower($modele['nom']) . '.');
$canonical = urlModele($regionSlug, $deptSlug, $villeSlug, $codePostal, $modeleSlug);

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => $region['nom'], 'url' => urlRegion($regionSlug)],
    ['name' => $dept['nom'], 'url' => urlDepartement($regionSlug, $deptSlug)],
    ['name' => $ville['nom_standard'], 'url' => urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal)],
    ['name' => $modele['nom'], 'url' => $canonical]
];

// FAQ modèle
$faqModele = [
    [
        'question' => 'Quel est le prix moyen d\'un séjour en ' . strtolower($modele['nom']) . ' à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Le prix d\'un séjour en ' . strtolower($modele['nom']) . ' varie selon la saison, le standing et les équipements. Consultez les fiches des ' . METIER_PLURAL . ' à ' . $ville['nom_standard'] . ' pour comparer les tarifs.'
    ],
    [
        'question' => 'Comment réserver un ' . strtolower($modele['nom']) . ' à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Consultez les fiches des établissements proposant des ' . strtolower($modele['nom']) . ' à ' . $ville['nom_standard'] . ', vérifiez les disponibilités et contactez directement le propriétaire pour réserver.'
    ],
    [
        'question' => 'Quels sont les avantages de ce type d\'hébergement ?',
        'reponse' => 'Chaque type d\'hébergement a ses spécificités. Les établissements à ' . $ville['nom_standard'] . ' vous offrent un cadre unique et un accueil personnalisé pour un séjour mémorable.'
    ],
    [
        'question' => 'Peut-on annuler une réservation facilement ?',
        'reponse' => 'Les conditions d\'annulation varient selon les établissements. La plupart proposent une annulation gratuite jusqu\'à 7-14 jours avant l\'arrivée. Vérifiez les conditions lors de votre réservation.'
    ],
    [
        'question' => 'Y a-t-il des activités à faire autour de ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Les hébergeurs à ' . $ville['nom_standard'] . ' peuvent vous conseiller sur les activités locales : visites culturelles, randonnées, gastronomie et découverte du terroir.'
    ]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs),
    jsonLdService($ville, $modele),
    jsonLdFAQ($faqModele)
];

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Hero avec formulaire -->
<section class="relative py-12 lg:py-16 overflow-hidden">
    <!-- Image de fond -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920&q=80&auto=format&fit=crop"
             alt="Chambres d'hôtes en France"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-start">
            <!-- Colonne gauche : Informations -->
            <div class="mb-8 lg:mb-0">
                <div class="flex items-center space-x-1 mb-4">
                    <div class="flex text-yellow-400">
                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                    </div>
                    <span class="text-white font-semibold ml-2">4.8/5</span>
                    <span class="text-white/70 text-sm">sur +100 séjours à <?= e($ville['nom_standard']) ?></span>
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
                    <?= e($modele['nom']) ?> à<br>
                    <span class="text-primary-200"><?= e($ville['nom_standard']) ?></span>
                </h1>

                <p class="text-lg text-white/90 mb-8">
                    <?= e($modele['nom']) ?> près de <?= e($codePostal) ?>
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Réservation facile</p>
                                <p class="text-sm text-white/70">En ligne</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Assistance 24/7</p>
                                <p class="text-sm text-white/70">Service client</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Formulaire devis -->
            <div>
                <?php include __DIR__ . '/../components/hero-devis-form.php'; ?>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:grid lg:grid-cols-3 lg:gap-8">
        <!-- Main content -->
        <div class="lg:col-span-2 space-y-12">

            <!-- Artisans spécialisés -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Hébergements <?= strtolower(e($modele['nom'])) ?> à <?= e($ville['nom_standard']) ?>
                </h2>

                <?php if (!empty($artisans)): ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($artisans, 0, 10) as $artisan): ?>
                        <?php include __DIR__ . '/../components/card-artisan.php'; ?>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <span class="text-4xl block mb-4"><?= $modele['emoji'] ?></span>
                    <p class="text-gray-600 mb-4">
                        Découvrez les <?= METIER_PLURAL ?>
                        de type <?= strtolower(e($modele['nom'])) ?> à <?= e($ville['nom_standard']) ?>.
                    </p>
                    <a href="#rechercher" class="text-primary-600 font-semibold hover:underline">
                        Rechercher un hébergement &rarr;
                    </a>
                </div>
                <?php endif; ?>
            </section>

            <!-- Autres modèles -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Autres types d'hébergement à <?= e($ville['nom_standard']) ?>
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    <?php foreach (SERVICES_TOITURE_MODELES as $m): ?>
                        <?php if ($m['slug'] !== $modeleSlug): ?>
                        <?php $modele_temp = $m; ?>
                        <a href="<?= urlModele($regionSlug, $deptSlug, $villeSlug, $codePostal, $m['slug']) ?>"
                           class="group flex items-center space-x-3 bg-white rounded-lg border border-gray-200 p-3 hover:border-primary-500 hover:shadow-md transition-all duration-200">
                            <span class="text-2xl"><?= $m['emoji'] ?></span>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-primary-600 transition-colors truncate">
                                <?= e($m['nom']) ?>
                            </span>
                        </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Contenu informatif -->
            <section class="bg-white rounded-xl border border-gray-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <?= e($modele['nom']) ?> : ce qu'il faut savoir
                </h2>
                <div class="prose prose-gray max-w-none">
                    <p>
                        Vous recherchez un <?= strtolower(e($modele['nom'])) ?> à <?= e($ville['nom_standard']) ?> ?
                        Notre annuaire vous aide à trouver l'hébergement idéal pour votre séjour :
                        découvrez les établissements, comparez les offres et réservez en toute simplicité.
                    </p>
                    <h3>Les avantages de ce type d'hébergement</h3>
                    <ul>
                        <li><strong>Cadre unique</strong> : des établissements de caractère sélectionnés</li>
                        <li><strong>Accueil personnalisé</strong> : des hôtes passionnés à votre écoute</li>
                        <li><strong>Authenticité</strong> : découvrez la région à travers un séjour sur mesure</li>
                        <li><strong>Rapport qualité-prix</strong> : comparez et trouvez les meilleures offres</li>
                    </ul>
                    <p>
                        Consultez les fiches des <?= METIER_PLURAL ?> à <?= e($ville['nom_standard']) ?>
                        pour comparer les offres et choisir l'hébergement qui correspond à vos envies.
                    </p>
                </div>
            </section>

            <!-- FAQ -->
            <?php $faqItems = $faqModele; ?>
            <?php include __DIR__ . '/../components/faq.php'; ?>

            <!-- Même modèle dans les villes voisines -->
            <?php if (!empty($villesProches)): ?>
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    <?= e($modele['nom']) ?> dans les villes proches
                </h2>
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (array_slice($villesProches, 0, NEARBY_CITIES_COUNT) as $vp): ?>
                        <a href="<?= urlRelative($regionSlug . '/' . $deptSlug . '/' . $vp['slug_ville'] . '-' . $vp['code_postal'] . '/' . $modeleSlug . '/') ?>"
                           class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-primary-100 hover:text-primary-700 text-gray-700 rounded-full text-sm transition-colors">
                            <?= e($vp['nom_standard']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-8 mt-12 lg:mt-0">
            <div class="lg:sticky lg:top-24">
                <?php $ville_name = $ville['nom_standard']; ?>
                <?php include __DIR__ . '/../components/cta-devis.php'; ?>

                <!-- Retour ville -->
                <div class="mt-8">
                    <a href="<?= urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal) ?>"
                       class="flex items-center justify-center space-x-2 text-primary-600 hover:text-primary-700 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Retour à <?= e($ville['nom_standard']) ?></span>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
