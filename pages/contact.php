<?php
/**
 * Page Contact - Annuaire Chambres d'Hôtes
 * URL: /contact/
 */

require_once __DIR__ . '/../functions.php';

// SEO
$pageTitle = seoTitle('Contact');
$pageDescription = seoDescription('Contactez l\'équipe annuaire-chambres-hotes.fr. Nous sommes à votre disposition pour répondre à vos questions sur nos hébergements référencés.');
$canonical = SITE_URL . '/contact/';

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => 'Contact', 'url' => $canonical]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs)
];

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Contenu -->
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Une question sur nos services ? Notre équipe est à votre disposition pour vous répondre.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Informations de contact -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Nos coordonnées</h2>

                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Email</h3>
                            <p class="text-gray-600">contact@annuaire-chambres-hotes.fr</p>
                            <p class="text-sm text-gray-500 mt-1">Réponse sous 24-48h</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Horaires</h3>
                            <p class="text-gray-600">Du lundi au vendredi</p>
                            <p class="text-sm text-gray-500 mt-1">9h00 - 18h00</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Couverture</h3>
                            <p class="text-gray-600">France métropolitaine & DOM-TOM</p>
                            <p class="text-sm text-gray-500 mt-1">Des milliers d'hébergements référencés</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ rapide -->
                <div class="mt-10 p-6 bg-gray-50 rounded-xl">
                    <h3 class="font-semibold text-gray-900 mb-4">Questions fréquentes</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            L'annuaire est-il gratuit ? <strong class="text-gray-900">Oui, 100% gratuit</strong>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Comment réserver ? <strong class="text-gray-900">Contactez directement l'hébergeur</strong>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Suis-je engagé ? <strong class="text-gray-900">Non, sans engagement</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CTA -->
            <div>
                <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-8 text-white">
                    <h2 class="text-xl font-bold mb-4">Trouvez votre hébergement idéal</h2>
                    <p class="text-primary-100 mb-6">
                        Découvrez les plus belles chambres d'hôtes, gîtes et hôtels de charme partout en France.
                    </p>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Service 100% gratuit
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Sans engagement
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Hébergements vérifiés et de qualité
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Réservation simple et rapide
                        </li>
                    </ul>

                    <a href="https://expedia.com/affiliate/Ct26O9m" target="_blank" rel="noopener nofollow sponsored"
                       class="block w-full text-center bg-white text-primary-600 font-bold py-4 px-6 rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                        Rechercher un hébergement
                    </a>
                </div>

                <!-- Infos légales -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        En nous contactant, vous acceptez notre
                        <a href="/politique-confidentialite/" class="text-primary-600 hover:underline">politique de confidentialité</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
