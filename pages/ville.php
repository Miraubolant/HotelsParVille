<?php
/**
 * Page Ville (Page Lead) - Annuaire Chambres d'Hôtes
 * URL: /{region}/{departement}/{ville-CP}/
 */

require_once __DIR__ . '/../functions.php';

// Récupération des paramètres
$regionSlug = $params['region'] ?? null;
$deptSlug = $params['departement'] ?? null;
$villeSlugCP = $params['ville'] ?? null;

// Extraction slug ville et code postal
preg_match('/^(.+)-(\d{5})$/', $villeSlugCP, $matches);
$villeSlug = $matches[1] ?? null;
$codePostal = $matches[2] ?? null;

if (!$regionSlug || !$deptSlug || !$villeSlug || !$codePostal) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Chargement des données
$region = getRegionBySlug($regionSlug);
$villeData = getVille($villeSlug, $codePostal);

if (!$region || !$villeData) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

$ville = $villeData['ville'];
$dept = $villeData['departement'];
$villesProches = $villeData['villes_proches'] ?? [];

// Artisans de la ville
$deptCode = getDeptCodeFromPostal($codePostal);
$artisans = getArtisansVille($deptCode, $villeSlug);

// SEO
$pageTitle = seoTitle('Hébergements ' . $ville['nom_standard'] . ' ' . $codePostal . ' : Chambres d\'hôtes & Gîtes ' . date('Y'));
$pageDescription = seoDescription('Hébergements à ' . $ville['nom_standard'] . ' : ' . count($artisans) . ' établissements référencés. Chambres d\'hôtes, gîtes, hôtels de charme. Trouvez votre séjour idéal à ' . $codePostal . '.');
$canonical = urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal);

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => $region['nom'], 'url' => urlRegion($regionSlug)],
    ['name' => $dept['nom'], 'url' => urlDepartement($regionSlug, $deptSlug)],
    ['name' => $ville['nom_standard'], 'url' => $canonical]
];

// FAQ ville
$faqVille = [
    [
        'question' => 'Quel est le prix moyen d\'une nuit à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Le prix moyen d\'une nuit à ' . $ville['nom_standard'] . ' varie selon le type d\'hébergement : chambre d\'hôtes 70-120€, gîte 60-150€/nuit, hôtel de charme 100-200€. Comparez les offres pour trouver le meilleur rapport qualité-prix.'
    ],
    [
        'question' => 'Quels types d\'hébergement sont disponibles à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'À ' . $ville['nom_standard'] . ' vous trouverez des chambres d\'hôtes, gîtes, hôtels de charme, auberges et hébergements insolites. Consultez notre annuaire pour découvrir toutes les options disponibles.'
    ],
    [
        'question' => 'Comment réserver un hébergement à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Consultez les fiches des hébergements à ' . $ville['nom_standard'] . ' sur notre annuaire, vérifiez les disponibilités et contactez directement le propriétaire par téléphone ou via son site web pour réserver.'
    ],
    [
        'question' => 'Y a-t-il des hébergements avec piscine à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Oui, plusieurs hébergements à ' . $ville['nom_standard'] . ' disposent d\'une piscine. Utilisez nos filtres pour trouver les chambres d\'hôtes et gîtes avec piscine dans les environs.'
    ],
    [
        'question' => 'Les animaux sont-ils acceptés dans les hébergements ?',
        'reponse' => 'Certains hébergements à ' . $ville['nom_standard'] . ' acceptent les animaux. Vérifiez sur la fiche de chaque établissement ou utilisez notre filtre "Animaux acceptés" pour trouver un hébergement pet-friendly.'
    ],
    [
        'question' => 'Quelle est la meilleure période pour séjourner à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Chaque saison a son charme à ' . $ville['nom_standard'] . '. La haute saison (juillet-août) offre le meilleur temps mais les tarifs sont plus élevés. Le printemps et l\'automne offrent un excellent rapport qualité-prix avec moins de touristes.'
    ]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs),
    jsonLdService($ville),
    jsonLdFAQ($faqVille)
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
                    Hébergements à<br>
                    <span class="text-primary-200"><?= e($ville['nom_standard']) ?></span>
                </h1>

                <p class="text-lg text-white/90 mb-8">
                    Trouvez votre hébergement idéal à <?= e($ville['nom_standard']) ?> : chambres d'hôtes, gîtes et hôtels de charme près du code postal <?= e($codePostal) ?>
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

            <!-- Liste des artisans -->
            <section id="artisans">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Les hébergements recommandés à <?= e($ville['nom_standard']) ?>
                </h2>

                <?php if (!empty($artisans)): ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($artisans, 0, ARTISANS_PER_PAGE) as $artisan): ?>
                        <?php include __DIR__ . '/../components/card-artisan.php'; ?>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="bg-gray-50 rounded-xl p-8 text-center">
                    <span class="text-4xl block mb-4">🏨</span>
                    <p class="text-gray-600 mb-4">
                        Aucun hébergement référencé à <?= e($ville['nom_standard']) ?> pour le moment.
                    </p>
                    <a href="#rechercher"
                       class="text-primary-600 font-semibold hover:underline">
                        Recherchez un hébergement dans les environs &rarr;
                    </a>
                </div>
                <?php endif; ?>
            </section>

            <!-- Services -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    Nos hébergements à <?= e($ville['nom_standard']) ?>
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">🏡</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Chambres d'hôtes</h4>
                            <p class="text-sm text-gray-600">Accueil chaleureux, petit-déjeuner inclus, charme local.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">🏠</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Gîtes & Locations</h4>
                            <p class="text-sm text-gray-600">Logements indépendants, idéal familles et groupes.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Zone d'intervention (carte) -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    Localisation : <?= e($ville['nom_standard']) ?>
                </h3>
                <div class="bg-gray-100 rounded-xl overflow-hidden h-64 flex items-center justify-center">
                    <?php if (!empty($ville['latitude']) && !empty($ville['longitude'])): ?>
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q=<?= $ville['latitude'] ?>,<?= $ville['longitude'] ?>&z=13&output=embed"
                        class="rounded-xl">
                    </iframe>
                    <?php else: ?>
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q=<?= urlencode($ville['nom_standard'] . ', France') ?>&z=13&output=embed"
                        class="rounded-xl">
                    </iframe>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Types d'hébergement -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-4">
                    Nos types d'hébergement à <?= e($ville['nom_standard']) ?>
                </h3>
                <p class="text-gray-600 mb-6">
                    Découvrez l'ensemble de nos hébergements disponibles. Des chambres d'hôtes traditionnelles aux hébergements insolites, trouvez le lieu parfait pour votre séjour.
                </p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (SERVICES_TOITURE_MODELES as $modele): ?>
                    <a href="<?= urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeSlug . '-' . $codePostal . '/' . $modele['slug'] . '/') ?>"
                       class="inline-flex items-center px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm hover:border-primary-500 hover:text-primary-600 transition-colors">
                        <span class="mr-2"><?= $modele['emoji'] ?></span>
                        <?= e($modele['nom']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Section guide -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Votre guide hébergement à <?= e($ville['nom_standard']) ?> (<?= e($codePostal) ?>)
                </h2>

                <div class="prose prose-gray max-w-none mb-8">
                    <p>
                        Vous cherchez un hébergement à <strong><?= e($ville['nom_standard']) ?></strong> ?
                        Notre annuaire référence les meilleures chambres d'hôtes, gîtes et hôtels de charme pour vous aider à trouver le séjour idéal.
                    </p>
                </div>

                <!-- Pourquoi choisir -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
                    <h3 class="font-bold text-gray-900 mb-4">Pourquoi choisir nos hébergements à <?= e($ville['nom_standard']) ?> ?</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3">&#9989;</span>
                            <span>Hébergements vérifiés et de qualité</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">&#128205;</span>
                            <span>Établissements locaux sélectionnés</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">&#128182;</span>
                            <span>Meilleurs prix garantis</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">&#9889;</span>
                            <span>Réservation simple et rapide</span>
                        </li>
                    </ul>
                </div>

                <!-- Étapes du projet -->
                <h3 class="font-bold text-gray-900 mb-4">Comment trouver votre hébergement à <?= e($ville['nom_standard']) ?></h3>
                <div class="grid sm:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <div class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold mx-auto mb-3">01</div>
                        <h4 class="font-bold text-gray-900 mb-2">Recherchez</h4>
                        <p class="text-sm text-gray-600">Explorez les hébergements disponibles selon vos critères.</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <div class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold mx-auto mb-3">02</div>
                        <h4 class="font-bold text-gray-900 mb-2">Comparez</h4>
                        <p class="text-sm text-gray-600">Comparez les offres, les avis et les équipements.</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <div class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold mx-auto mb-3">03</div>
                        <h4 class="font-bold text-gray-900 mb-2">Réservez</h4>
                        <p class="text-sm text-gray-600">Contactez directement l'hébergeur et réservez votre séjour.</p>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-6">Questions Fréquentes (FAQ)</h3>
                <?php $faqItems = $faqVille; ?>
                <?php include __DIR__ . '/../components/faq.php'; ?>
            </section>

            <!-- Villes proches -->
            <?php if (!empty($villesProches)): ?>
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    Hébergements à proximité de <?= e($ville['nom_standard']) ?>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    <?php foreach (array_slice($villesProches, 0, NEARBY_CITIES_COUNT) as $vp): ?>
                    <?php
                        $vpDeptCode = getDeptCodeFromPostal($vp['code_postal']);
                        $vpRegion = $regionSlug;
                    ?>
                    <a href="<?= urlRelative($vpRegion . '/' . $deptSlug . '/' . $vp['slug_ville'] . '-' . $vp['code_postal'] . '/') ?>"
                       class="bg-white rounded-lg border border-gray-200 p-3 hover:border-primary-500 hover:shadow-md transition-all text-center">
                        <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900 truncate"><?= e($vp['nom_standard']) ?></p>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-8 mt-12 lg:mt-0">
            <!-- CTA Sidebar sticky -->
            <div class="lg:sticky lg:top-24">
                <?php include __DIR__ . '/../components/sidebar-cta.php'; ?>

                <!-- Info ville -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mt-8">
                    <h3 class="font-bold text-gray-900 mb-4">
                        <?= e($ville['nom_standard']) ?> en bref
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between">
                            <span class="text-gray-500">Code postal</span>
                            <span class="font-medium text-gray-900"><?= e($codePostal) ?></span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Département</span>
                            <span class="font-medium text-gray-900"><?= e($dept['nom']) ?></span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Région</span>
                            <span class="font-medium text-gray-900"><?= e($region['nom']) ?></span>
                        </li>
                        <?php if (!empty($ville['population'])): ?>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Population</span>
                            <span class="font-medium text-gray-900"><?= number_format($ville['population'], 0, ',', ' ') ?> hab.</span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
