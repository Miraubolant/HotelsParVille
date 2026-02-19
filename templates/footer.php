    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo & Description -->
                <div class="md:col-span-1">
                    <a href="/" class="flex items-center space-x-2.5 mb-4 group">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary-600 to-accent-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-tight">
                            <span class="text-white">HOTELS</span><span class="text-primary-400">-PAR-VILLE.FR</span>
                        </span>
                    </a>
                    <p class="text-sm text-gray-400 mb-4">
                        <?= SITE_DESCRIPTION ?>
                    </p>
                    <div class="flex items-center space-x-1 text-sm">
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="font-semibold text-white">4.9/5</span>
                        <span class="text-gray-500">sur +10 000 avis</span>
                    </div>
                </div>

                <!-- Navigation -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Navigation</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="/#regions" class="hover:text-white transition-colors">Toutes les régions</a></li>
                        <li><a href="/#services" class="hover:text-white transition-colors">Hébergements</a></li>
                        <li><a href="/#faq" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="https://expedia.com/affiliate/Ct26O9m" target="_blank" rel="noopener nofollow sponsored" class="hover:text-white transition-colors">Rechercher un hébergement</a></li>
                    </ul>
                </div>

                <!-- Hébergements -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Hébergements</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/#services" class="hover:text-white transition-colors">Chambres d'hôtes</a></li>
                        <li><a href="/#services" class="hover:text-white transition-colors">Gîtes</a></li>
                        <li><a href="/#services" class="hover:text-white transition-colors">Hôtels de charme</a></li>
                        <li><a href="/#services" class="hover:text-white transition-colors">Hébergements insolites</a></li>
                        <li><a href="/#services" class="hover:text-white transition-colors">Avec piscine</a></li>
                    </ul>
                </div>

                <!-- Régions populaires -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Régions populaires</h3>
                    <ul class="space-y-2 text-sm">
                        <?php
                        $popularRegions = ['ile-de-france', 'provence-alpes-cote-d-azur', 'occitanie', 'nouvelle-aquitaine', 'auvergne-rhone-alpes'];
                        $regions = getRegions();
                        foreach ($regions as $region):
                            if (in_array($region['slug'], $popularRegions)):
                        ?>
                        <li>
                            <a href="<?= urlRelative($region['slug'] . '/') ?>" class="hover:text-white transition-colors">
                                <?= e($region['nom']) ?>
                            </a>
                        </li>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>

            <!-- Types d'hébergement -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <h3 class="text-white font-semibold mb-4">Types d'hébergement</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (array_slice(SERVICES_TOITURE_MODELES, 0, 12) as $modele): ?>
                    <span class="text-xs bg-gray-800 text-gray-400 px-3 py-1 rounded-full">
                        <?= e($modele['nom']) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Annuaires partenaires -->
            <?php if (defined('NETWORK_SITES') && !empty(NETWORK_SITES)): ?>
            <div class="border-t border-gray-800 mt-8 pt-8">
                <h3 class="text-white font-semibold mb-4">Nos annuaires partenaires</h3>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (NETWORK_SITES as $partnerSite): ?>
                    <a href="<?= $partnerSite['url'] ?>"
                       title="<?= e($partnerSite['nom']) ?>"
                       target="_blank"
                       rel="noopener"
                       class="text-xs bg-gray-800 text-gray-400 hover:text-white hover:bg-gray-700 px-3 py-1.5 rounded-full transition-colors">
                        <?= e($partnerSite['anchor']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Bottom bar -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-sm text-gray-500">
                        &copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.
                    </div>
                    <div class="flex items-center space-x-6 text-sm">
                        <a href="/mentions-legales/" class="text-gray-500 hover:text-white transition-colors">Mentions légales</a>
                        <a href="/politique-confidentialite/" class="text-gray-500 hover:text-white transition-colors">Confidentialité</a>
                        <a href="/contact/" class="text-gray-500 hover:text-white transition-colors">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating CTA Button -->
    <?php include __DIR__ . '/../components/floating-cta.php'; ?>

    <!-- Expedia Widget Script (after DOM is ready) -->
    <script class="eg-widgets-script" src="https://creator.expediagroup.com/products/widgets/assets/eg-widgets.js"></script>

    <!-- Back to top button -->
    <button x-data="{ show: false }"
            x-show="show"
            x-cloak
            @scroll.window="show = window.scrollY > 500"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 bg-primary-600 hover:bg-primary-700 text-white p-3 rounded-full shadow-lg transition-all z-40">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

</body>
</html>
