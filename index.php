<?php
/**
 * Page d'accueil - Annuaire Chambres d'Hôtes
 */

require_once __DIR__ . '/functions.php';

// SEO
$pageTitle = seoTitle(SITE_TAGLINE);
$pageDescription = seoDescription(SITE_DESCRIPTION);
$canonical = SITE_URL . '/';

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdWebSite(),
    jsonLdFAQ(FAQ_ACCUEIL)
];

// Data
$regions = getRegions();

include __DIR__ . '/templates/header.php';
?>

<!-- Hero Section -->
<section class="relative overflow-hidden">
    <!-- Image de fond -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920&q=80&auto=format&fit=crop"
             alt="Hébergements en France"
             class="w-full h-full object-cover">
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative">
        <div class="text-center">
            <div class="inline-flex items-center bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium mb-6 backdrop-blur-sm">
                <span class="text-yellow-300 mr-2">&#9733;</span>
                4.8/5 sur +5 000 séjours
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
                Hôtels par Ville<br>
                <span class="text-primary-300">Partout en France</span>
            </h1>

            <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10">
                Trouvez l'hébergement idéal près de votre destination.<br>
                Chambres d'hôtes, gîtes, hôtels de charme : réservez votre séjour.
            </p>

            <!-- Widget Expedia -->
            <div id="rechercher" class="max-w-3xl mx-auto mb-8">
                <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xl">
                    <div class="eg-widget" data-widget="search" data-program="fr-expedia" data-lobs="stays" data-network="pz" data-camref="1110lzZyN" data-pubref=""></div>
                </div>
            </div>

            <!-- CTA button -->
            <a href="#regions"
               class="inline-flex items-center justify-center px-8 py-4 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/20 transition-colors backdrop-blur-sm border border-white/20">
                Explorer par région
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </a>
        </div>
    </div>

</section>

<!-- Types d'hébergement -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Tous nos types d'hébergement
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Quel que soit votre envie, trouvez l'hébergement parfait pour votre séjour
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php foreach (STYLES_TOITURE as $style): ?>
            <a href="/#regions"
               class="group bg-white rounded-xl p-6 text-center border border-gray-200 hover:border-primary-500 hover:shadow-lg transition-all">
                <span class="text-4xl block mb-3"><?= $style['emoji'] ?></span>
                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors text-sm">
                    <?= e($style['nom']) ?>
                </h3>
                <p class="text-xs text-gray-500 mt-1 hidden md:block"><?= e($style['desc']) ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Services -->
<section id="services" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Nos hébergements
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Des chambres d'hôtes aux gîtes, en passant par les hébergements insolites, trouvez le lieu idéal pour votre séjour
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach (SERVICES_TOITURE as $service): ?>
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 border border-gray-200">
                <span class="text-4xl block mb-4"><?= $service['icon'] ?></span>
                <h3 class="text-xl font-bold text-gray-900 mb-3"><?= e($service['titre']) ?></h3>
                <p class="text-gray-600 mb-6"><?= e($service['desc']) ?></p>
                <ul class="space-y-2">
                    <?php foreach ($service['points'] as $point): ?>
                    <li class="flex items-center text-sm text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <?= e($point) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Villes populaires -->
<section id="regions" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                <?= METIER_TITLE ?> dans les villes les plus recherchées
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Des milliers d'hébergements de charme dans toute la France
            </p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php foreach (TOP_VILLES as $topVille): ?>
            <a href="<?= urlRelative($topVille['region'] . '/' . $topVille['dept'] . '/' . $topVille['slug'] . '-' . $topVille['cp'] . '/') ?>"
               class="group bg-white rounded-xl p-4 border border-gray-200 hover:border-primary-500 hover:shadow-lg transition-all text-center">
                <div class="w-12 h-12 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center mx-auto mb-3 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                    <?= e($topVille['nom']) ?>
                </h3>
                <p class="text-xs text-gray-500 mt-1"><?= e($topVille['cp']) ?></p>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8">
            <p class="text-gray-600 mb-4">Vous ne trouvez pas votre ville ?</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <?php foreach (array_slice($regions, 0, 6) as $region): ?>
                <a href="<?= urlRelative($region['slug'] . '/') ?>"
                   class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                    <?= e($region['nom']) ?>
                </a>
                <?php endforeach; ?>
            </div>
            <a href="https://expedia.com/affiliate/Ct26O9m" target="_blank" rel="noopener nofollow sponsored"
               class="inline-flex items-center mt-6 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Trouver un hébergement dans ma ville
            </a>
        </div>
    </div>
</section>

<!-- Avantages -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Pourquoi choisir <?= SITE_NAME ?> ?
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach (AVANTAGES as $avantage): ?>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-100 text-primary-600 text-3xl mb-4">
                    <?= $avantage['icon'] ?>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2"><?= e($avantage['titre']) ?></h3>
                <p class="text-gray-600"><?= e($avantage['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Devis -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php include __DIR__ . '/components/cta-devis.php'; ?>
    </div>
</section>

<!-- FAQ -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php $faqItems = FAQ_ACCUEIL; ?>
        <?php include __DIR__ . '/components/faq.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/templates/footer.php'; ?>
